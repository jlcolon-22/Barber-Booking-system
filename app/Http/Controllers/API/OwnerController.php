<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Branch;
use App\Models\Message;
use App\Models\Certificate;
use App\Models\Reservation;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OwnerController extends Controller
{
    public function owner_store_message(Request $request, $convoId)
    {

        $message = Message::query()->create([
            'conversation_id' => $convoId,
            'body' => $request->body,
            'sender_id' => Auth::id()
        ]);
        return response()->json($message);
    }

    public function owner_fetch_message($convoId)
    {

        $messages = Message::query()->where('conversation_id', $convoId)->get();
        return response()->json($messages);
    }

    public function view_message($convoId)
    {
        $branch = Conversation::query()->with('customerInfo', function ($q) {
            $q->with('branch');
        })->where('id', $convoId)->first();
        return view('owner.chat_convo', compact('branch',));
    }

    public function messages()
    {
        $branches = Conversation::query()->with('customerInfo')->where('user_two', Auth::id())->get();
        return view('owner.Message', compact('branches'));
    }

    public function post_delete(Post $id)
    {

        Reservation::where('post_id', $id->id)->delete();
        $id->delete();
        return back()->with('success', 'true');
    }

    public function account_delete(User $id)
    {
        $id->delete();

        return back()->with('success', 'true');
    }


    public function update_appointment(Reservation $id)
    {
        $id->update([
            'status' => 1
        ]);
        $branch = Branch::with('ownerInfo')->where('id', $id->branch_id)->first();
        $data = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
            'message' => 'Your request has been approved.'
        ];
        Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
            'message' => $id->firstname . ' ' . $id->lastname . " reservation request has been approved."
        ];
        Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if ($owners) {
            foreach ($owners as $key => $value) {
                Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }
        return back()->with('success', 'true');
    }

    public function cancel_appointment(Reservation $id)
    {
        $id->update([
            'status' => 2
        ]);
        $branch = Branch::with('ownerInfo')->where('id', $id->branch_id)->first();
        $data = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
            'message' => 'Your request has been canceled.'
        ];
        Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
            'message' => $id->firstname . ' ' . $id->lastname . " reservation request has been canceled."
        ];
        Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if ($owners) {
            foreach ($owners as $key => $value) {
                Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }
        return back()->with('success', 'true');
    }


    public function appointment()
    {
        $branch = Branch::where('owner_id', Auth::id())->first();
        if (!$branch) {
            $appointments = [];
            return view('owner.reservation', compact('appointments'))->with('error', 'true');
        }
        $appointments = Reservation::with('postInfo', 'branchInfo')->where('branch_id', $branch->id)->latest()->paginate(6);

        return view('owner.reservation', compact('appointments'));
    }

    public function certificate()
    {
        $certificates = Certificate::where('owner_id', Auth::id())->get();
        return view('owner.certificate', compact('certificates'));
    }

    public function delete_certificate(Certificate $id)
    {
        unlink(substr($id->photo, 1));
        $id->delete();
        return back();
    }

    public function store_certificate(Request $request)
    {
        $filename = time() . '-certificate.' . $request->photo->extension();
        Certificate::create([
            'photo' => '/storage/certificate/' . $filename,
            'owner_id' => Auth::id()
        ]);
        $request->photo->storeAs('public/certificate', $filename);
        return back();
    }

    public function index()
    {
        $reservations = Reservation::where('status','!=',2)->where('status','!=',3)->latest()->get();
        foreach($reservations as $value)
        {
            $now = Carbon::now();
            $date = Carbon::parse($value->date);
            $checkDate = $date->diffInDays($now,false);

            if($checkDate == 0)
            {
                $resev = Carbon::parse(explode(' to ',$value->time)[1]);

                $checkTime = $resev->diffInMinutes($now,false);

                if($checkTime >= 0)
                {
                    $value->update(['status'=>3]);
                }


            }
            elseif($checkDate > 0)
            {
                $value->update(['status'=>3]);
            }

        }
        $employees = User::select('firstname', 'lastname', 'id')->where('role', 1)->where('owner_id', Auth::id())->get();
        $posts = Post::query()->with('employeeInfo')->where('owner_id', Auth::id())->latest()->paginate(10);


        return view("owner.Dashboard", compact('employees', 'posts'));
    }

    public function account()
    {
        $employees = User::where('role', 1)->where('owner_id', Auth::id())->latest()->paginate(10);
        return view('owner.Accounts', compact('employees'));
    }

    public function store_account(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',

        ]);
        $user = User::query()->create([
            "firstname" => ucfirst($request->firstname),
            "lastname" => ucfirst($request->lastname),
            "email" => $request->email,
            'role' => 1,
            'email_verified_at' => now(),
            'owner_id' => Auth::id(),
            'password' => Hash::make($request->password)
        ]);
        $user->markEmailAsVerified();
        if ($user) {
            $filename = time() . '-employee.' . $request->profile->extension();
            $user->update([
                'profile' => '/storage/employee/' . $filename
            ]);
            $request->profile->storeAs('public/employee', $filename);
        }
    }

    public function update_account(Request $request, User $id)
    {
        $id->update([
            "firstname" => ucfirst($request->firstname),
            "lastname" => ucfirst($request->lastname),
            "email" => $request->email,
        ]);

        if (!!$request->password) {
            $id->update(['password' => Hash::make($request->password)]);
        }
        if (!!$request->profile) {
            $filename = time() . '-employee.' . $request->profile->extension();
            if (!!$id->profile) {
                unlink(substr($id->profile, 1));
            }
            $id->update([
                'profile' => '/storage/employee/' . $filename
            ]);
            $request->profile->storeAs('public/employee', $filename);
        }
    }

    public function posts()
    {
        $employees = User::select('firstname', 'lastname', 'id')->where('role', 1)->where('owner_id', Auth::id())->get();
        $posts = Post::query()->with('employeeInfo')->where('owner_id', Auth::id())->latest()->paginate(10);
        return view('owner.Post', compact('employees', 'posts'));
    }

    public function store_post(Request $request)
    {
        $post = Post::query()->create([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'owner_id' => Auth::id(),
            'price' => $request->price,
            'category' => $request->category
        ]);

        if ($post) {
            $filename = time() . '-post.' . $request->photo->extension();
            $post->update([
                'photo' => '/storage/post/' . $filename
            ]);

            $request->photo->storeAs('public/post', $filename);
        }
    }

    public function update_post(Request $request, Post $id)
    {
        $id->update([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'price' => $request->price,
            'category' => $request->category
        ]);

        if (!!$request->photo) {

            $filename = time() . '-post.' . $request->photo->extension();

            unlink(substr($id->photo, 1));
            $id->update([
                'photo' => '/storage/post/' . $filename
            ]);

            $request->photo->storeAs('public/post', $filename);
        }
    }
}
