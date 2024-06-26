<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Branch;
use GuzzleHttp\Client;
use App\Models\Message;
use App\Models\Feedback;
use App\Models\BranchTime;
use App\Events\ChatMessage;
use App\Models\Reservation;
use Illuminate\Support\Str;
use App\Models\Conversation;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class FrontendController extends Controller
{

    public function chechIfVerify(Request $request)
    {
        $user = Otp::where('number',$request->number)->where('status',1)->exists();

        return response()->json($user);
    }
    public function checkOtp(Request $request)
    {
        $otp = $request->first.$request->second.$request->third.$request->fourth;
        $number = Otp::query()->where('number',$request->number)->where('otp',$otp)->exists();
        if($number)
        {
            Otp::query()->where('number',$request->number)->where('otp',$otp)->update(['status' => true]);
            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
    public function send_otp(Request $request)
    {
        $randomNumber = rand(1000, 9999);
        Otp::query()->create([
            'otp'=>$randomNumber,
            'number'=>$request->number
        ]);
        $response = Http::post('https://api.semaphore.co/api/v4/messages',[
            'apikey' => '169d841753ebe36cd27e3ce7cdc6e51d',
            'number'=>$request->number,
            'message'=> 'our OTP code is now '.$randomNumber.'. Please use it quickly!',
           ]);
        return response()->json($randomNumber);
    }
    public function sms()
    {
        // 169d841753ebe36cd27e3ce7cdc6e51d
       $response = Http::post('https://api.semaphore.co/api/v4/messages',[
        'apikey' => '169d841753ebe36cd27e3ce7cdc6e51d',
        // 'number'=>
       ]);
       dd($response);
    // $client = new Client();
    // $parameters = [
    //     'apikey' => 'a1398f27fe149bb183094ecc07c84de6' // Your API KEY

    // ];

    // try {
    //     $response = $client->get('https://api.semaphore.co/api/v4/account', [
    //         'form_params' => [
    //             'apikey' => 'a1398f27fe149bb183094ecc07c84de6'
    //         ]
    //     ]);

    //     $output = $response->getBody()->getContents();
    //     // Show the server response
    //     echo $output;
    // } catch (\Exception $e) {
    //     // Handle exceptions
    //     echo $e->getMessage();
    // }

    }
    public function getBranchTIme(Request $request,Branch $id)
    {
        $check = BranchTime::where('date',$request->date)->where('branch_id',$id->id)->first();
        if(!$check)
        {
            $start = Carbon::parse($id->start_time);
            $end = Carbon::parse($id->end_time)->subHours(1);

            if( $start->diffInHours($end) % 2 != 0)
            {

                $end = Carbon::parse($id->end_time)->subHour();

            }
            $currentDateTime = $start->copy();

            while ($currentDateTime <= $end) {
                $nextDateTime = $currentDateTime->copy()->addHour();

                $x = $currentDateTime->format('h:ia') . ' to ' . $nextDateTime->format('h:ia');
                BranchTime::create([
                    'branch_id'=>$id->id,
                    'time'=>$x,
                    'date'=>$request->date
                ]);
                $currentDateTime = $nextDateTime;
            }
        }
        return response()->json(BranchTime::where('branch_id',$id->id)->where('date',$request->date)->get());
    }
    public function getBranchDate($branch_id)
    {
        $branches = Reservation::query()->where('branch_id',$branch_id)->get('date')->groupBy('date');
        $times = BranchTime::query()->where('branch_id',$branch_id)->get()->groupBy('date');
        $dates = [];
        $bol = true;
        foreach($times as $key => $value)
        {
            $bol = true;
            foreach($value as $x)
            {
                if($x->status == 0)
                {
                    $bol = false;
                }
            }
            if($bol)
            {
                $dates[] = $key;
            }
        }
        return response()->json($dates);
        // $dates = [];
        // foreach($branches as $branch)
        // {
        //     if(count($branch) == 10)
        //     {
        //         $dates[] = $branch[0];
        //     }

        // }

        // return response()->json($all);
    }
    public function admin_message_fetch()
    {
        if(Auth::check())
        {
            $user = User::query()->where('role',3)->first();
            $check = Conversation::query()
                ->where('user_one', Auth::id())
                ->where('user_two', $user->id)
                ->where('type',1)
                ->first();

            if ($check) {
                $messages = Message::query()->where('conversation_id',$check->id)->get();
                return response()->json($messages);
            } else {
                $messages = [];

                return response()->json($messages);
            }
        }else{
            $messages = [];

            return response()->json($messages);
        }
    }
    public function admin_message_store(Request $request)
    {

        $user = User::query()->where('role',3)->first();

        $check = Conversation::query()
            ->where('user_one', Auth::id())
            ->where('user_two', $user->id)
            ->where('type',1)
            ->first();

        if ($check) {
            $message = Message::query()->create([
                'conversation_id' => $check->id,
                'body' => $request->body,
                'sender_id' => Auth::id()
            ])->toArray();
            broadcast(new ChatMessage($message))->toOthers();
            return response()->json($message['conversation_id']);

        } else {
            $convo = Conversation::query()
                ->create([
                    'id' => Str::uuid(),
                    'user_one' => Auth::id(),
                    'user_two' => $user->id,
                    'type'=>1
                ]);
            $message = Message::query()->create([
                'conversation_id' => $convo->id,
                'body' => $request->body,
                'sender_id' => Auth::id()
            ]);
            broadcast(new ChatMessage($message))->toOthers();
            return response()->json($convo->id);

        }

    }

    public function fetch_message($convoId)
    {
        $messages = Message::query()->where('conversation_id', $convoId)->get();
        return response()->json($messages);
    }

    public function view_convo_store(Request $request, $convoId)
    {

        $message = Message::query()->create([
            'conversation_id' => $convoId,
            'body' => $request->body,
            'sender_id' => Auth::id()
        ]);
        broadcast(new ChatMessage($message))->toOthers();

    }

    public function view_convo($branch_id)
    {
        $branch = Conversation::query()->with('ownerInfo', function ($q) {
            $q->with('branch');
        })->where('id', $branch_id)->first();
        return view('pages.chat_convo', compact('branch',));
    }

    //messages
    public function meessage()
    {
        $branches = Conversation::query()->with('ownerInfo', function ($q) {
            $q->with('branch')->where('role','!=',3);
        })->where('user_one', Auth::id())->get();

        return view('pages.chat', compact('branches'));
    }

    public function create_message($branch_id)
    {

        $check = Conversation::query()
            ->where('user_one', Auth::id())
            ->where('user_two', $branch_id)
            ->first();

        if ($check) {
            return redirect('/message/convo/' . $check->id);
        } else {
            $convo = Conversation::query()
                ->create([
                    'id' => Str::uuid(),
                    'user_one' => Auth::id(),
                    'user_two' => $branch_id
                ]);
            return redirect('/message/convo/' . $convo->id);
        }

    }

    public function feedback(Request $request)
    {


        Feedback::create([
            'user_id' => Auth::id(),
            'branch_id' => $request->id,
            'message' => $request->message,
        ]);
        return back()->with('feedback', 's');
    }

    public function contact(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
        Mail::to('Onlinebarbershopreservation@gmail.com')->send(new \App\Mail\ContactMail($data));
        return back()->with('success', 'true');
    }


    public function services()
    {

        $branches = Branch::where('status', 1)->paginate(10);
        $datas = json_encode($branches->items());

        return view('pages.services', compact('branches','datas'));
    }

    public function reservation(Request $request)
    {

        $offer = Post::query()->with('branch')->where('id', $request->q)->first();

        return view('pages.reservation', compact('offer'));
    }

    public function store_reservation(Request $request)
    {

        $request->validate([
            // 'number' => 'required|numeric|digits:11'
            'number' => 'required|numeric|digits:11|regex:/(0)[0-9]{9}/'
        ]);

        $check = Reservation::where('date', $request->date)->where('branch_id', $request->branch_id)->get()->count();
        // Check if the given date meets the maximum bookings per day.
        if ($check == 10) {
            return response()->json('true', 204);
        }

        Reservation::create([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'lastname' => $request->lastname,
            'number' => $request->number,
            'time' => $request->time,
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'branch_id' => $request->branch_id,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'status'=>1
        ]);
        BranchTime::query()->where('branch_id',$request->branch_id)->where('time',$request->time)->update(['status'=>1]);
        $branch = Branch::with('ownerInfo')->where('id', $request->branch_id)->first();
        $data = [
            'name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'message' => 'you have successfully reservation.'
        ];
        Mail::to($request->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'message' => 'you have successfully reservation.'
        ];
        Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if ($owners) {
            foreach ($owners as $key => $value) {
                Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }

    }

    public function appointment()
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
                    if($value->status == 1 )
                    {
                        $value->update(['status'=>3]);
                        $data = [
                            'name' => $value->firstname.' '.$value->lastname,
                            'email' => $value->email,
                            'date'=>$value->date,
                            'time'=>$value->time,
                            'number'=>$value->number,
                            'message'=>'Your reservation is finished.'
                        ];
                        Mail::to($value->email)->send(new \App\Mail\Reservation($data));
                    }
                }


            }
            elseif($checkDate > 0)
            {
                $value->update(['status'=>3]);
            }

        }

        $appointments = Reservation::with('postInfo', 'branchInfo')->where('user_id', Auth::id())->latest()->paginate(10);
        return view('pages.appointment', compact('appointments'));
    }

    public function update_appointment(Reservation $id)
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
            'number' => $id->number,
            'message' => 'Your cancellation of the reservation request was successful.'
        ];
        $x = BranchTime::where('branch_id', $id->branch_id)->where('time',$id->time)->whereDate('date',Carbon::parse($id->date)->format('d/m/Y'))->update(['status'=>0]);

        Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
            'number' => $id->number,
            'message' => $id->firstname . ' ' . $id->lastname . " canceled the reservation request."
        ];
        Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if ($owners) {
            foreach ($owners as $key => $value) {
                Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }
        return back()->with('success', 'true');
    }

    public function account()
    {


        return view('pages.account');
    }

    public function update_account(Request $request, User $id)
    {

        if (!!$request->password) {
            $request->validate([
                'password' => 'min:8',


            ]);
        }
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

                if ($id->profile[0] != 'h') {
                    unlink(substr($id->profile, 1));

                }
                $id->update([
                    'profile' => '/storage/employee/' . $filename
                ]);
                $request->profile->storeAs('public/employee', $filename);
            } else {
                $id->update([
                    'profile' => '/storage/employee/' . $filename
                ]);
                $request->profile->storeAs('public/employee', $filename);
            }
        }

        return back()->with('success', 'true');
    }

    public function branch(Request $request)
    {
        $branch = Branch::query()->with('feedbacks', function ($q) {
            $q->with('userInfo');
        })->where('id', $request->q)->first();
        $owner = User::with('posts', 'certificates')->where('id', $branch->owner_id)->first();
        $posts = Post::query()->where('owner_id',$owner->id)->get()->groupBy('category');


        return view('pages.branch', compact('branch', 'owner','posts'));
    }
}
