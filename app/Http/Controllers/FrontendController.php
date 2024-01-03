<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use App\Models\Post;
use App\Models\Reservation;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class FrontendController extends Controller
{
    public function getBranchDate($branch_id)
    {
        $branches = Reservation::query()->where('branch_id',$branch_id)->get('date')->groupBy('date');
        $dates = [];
        foreach($branches as $branch)
        {
            if(count($branch) == 10)
            {
                $dates[] = $branch[0];
            }

        }

        return response()->json($dates);
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
            ]);
             return response()->json($message);
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
            return response()->json($message);
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
        return response()->json($message);
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
            $q->with('branch');
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
            'time' => $request->time['hours'] . ':' . $request->time['minutes'],
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'branch_id' => $request->branch_id,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'status'=>1
        ]);
        $branch = Branch::with('ownerInfo')->where('id', $request->branch_id)->first();
        $data = [
            'name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time['hours'] . ':' . $request->time['minutes'],
            'message' => 'You have successfully submitted the reservation request. Please wait for us to approve your reservation.'
        ];
        Mail::to($request->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $request->firstname . ' ' . $request->lastname,
            'email' => $request->email,
            'date' => $request->date,
            'time' => $request->time['hours'] . ':' . $request->time['minutes'],
            'message' => $request->firstname . ' ' . $request->lastname . ' submitted a reservation request.'
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
            'message' => 'Your cancellation of the reservation request was successful.'
        ];
        Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id', $branch->owner_id)->latest()->get();
        $owner = [
            'name' => $id->firstname . ' ' . $id->lastname,
            'email' => $id->email,
            'date' => $id->date,
            'time' => $id->time,
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

        return view('pages.branch', compact('branch', 'owner'));
    }
}
