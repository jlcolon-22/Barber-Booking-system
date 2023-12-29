<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
class AuthController extends Controller
{

    public function reset_password(Request $request,User $id)
    {

        if($id)
        {
            $id->update([
                'password'=>Hash::make($request->password)
            ]);
            Auth::login($id);

                return redirect()->intended('/');

        }
    }
    public function password($id)
    {
        return view('auth.reset',compact('id'));
    }
    public function forget(Request $request)
    {
        $user = User::where('email',$request->email)->first();
 $url = env('APP_MAIN_DOMAIN');
        if($user)
        {
               $data = [
            'link'=>'http://127.0.0.1:8000/auth/password/reset/'.$user->id,

            ];
              \Mail::to($request->email)->send(new \App\Mail\Password($data));
              return redirect('/auth/forget/message');
        }else{
            return back()->with('error','ss');
        }
    }

    public function verified(User $id)
    {
        $id->markEmailAsVerified();
        return redirect('/auth/login')->with('verified','true');
    }

    public function store_signup(Request $request)
    {
         $url = env('APP_MAIN_DOMAIN');

      $request->validate([
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',

        ]);

        $user = User::create([
            'firstname' =>$request->firstname,
            'lastname' =>$request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password), // password
            'remember_token' => Str::random(10),
            'role'=>0
        ]);

        $data = [
            'link'=>'http://127.0.0.1:8000/auth/verification/'.$user->id,

        ];
          \Mail::to($user->email)->send(new \App\Mail\SignupMail($data));

        return redirect('/verified/message');
    }
    public function index()
    {
        return view("auth.login");
    }

    public function signup()
    {
        return view("auth.signup");
    }

    public function signup_google()
    {
        return Socialite::driver("google")->stateless()->redirect();
    }

    public function google_callback()
    {

        try {

            $user = Socialite::driver('google')->stateless()->user();


            $finduser = User::where('google_id', $user->id)->orWhere('email',$user->email)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('/');
                // return true;

            }else{
                $newUser = User::create([
                    'firstname' => $user->user['given_name'],
                    'lastname' => $user->user['family_name'],
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'profile'=> $user->avatar,
                    'password' => Hash::make($user->password),
                ]);
                $newUser->markEmailAsVerified();
                Auth::login($newUser);

                return redirect()->intended('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function userLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
                $request->session()->regenerate();

                if(Auth::user()->email_verified_at == null)
                {
                    $request->session()->regenerateToken();
                    $request->session()->invalidate();
                    Auth::logout();
                    return back()->with('errors','s');
                }
               if(Auth::user()->role == 3)
               {

                return redirect('/admin/dashboard');
               }
               if(Auth::user()->role == 2)
               {

                return redirect('/owner/dashboard');
               }
               if(Auth::user()->role == 0)
               {

                return redirect('/');
               }
                if(Auth::user()->role == 1)
               {

                return redirect('/employee/appointment');
               }
        }else{
            return back()->with(['error'=>'Wrong Credentials']);
        }
    }
    public function userLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/auth/login');
    }
}
