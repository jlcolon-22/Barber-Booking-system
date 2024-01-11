<?php

namespace App\Http\Controllers\API\admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Branch;
use App\Models\Message;
use App\Models\BranchTime;
use App\Events\ChatMessage;
use App\Models\Reservation;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class AdminDashboardController extends Controller
{

    public function get_reports(Request $request)
    {
        if($request->type == 'day')
        {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $appointments = Reservation::query()->with('postInfo','branchInfo')->whereDate('date',$date)->get();
            return response()->json($appointments);
        }
        if($request->type == 'month')
        {
            $date = $request->date;

            $appointments = Reservation::query()->with('postInfo','branchInfo')->whereMonth('date',explode('-',$date)[1])->whereYear('date',explode('-',$date)[0])->get();
            return response()->json($appointments);
        }
        if($request->type == 'years')
        {
            $date = $request->date;
            $appointments = Reservation::query()->with('postInfo','branchInfo')->whereYear('date',$date)->get();
            return response()->json($appointments);
        }
        return response()->json($request->all());
    }
    public function reports()
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

        return view('admin.Reports');
    }
    public function admin_store_message(Request $request, $convoId)
    {

        $message = Message::query()->create([
            'conversation_id' => $convoId,
            'body' => $request->body,
            'sender_id' => Auth::id()
        ]);
        broadcast(new ChatMessage($message))->toOthers();
        return response()->json($convoId);
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

        return view('admin.chat_convo', compact('branch'));
    }
    public function message()
    {
        $branches = Conversation::query()->with('customerInfo')->where('type',1)->get();
        return view('admin.Message',compact('branches'));
    }
    public function index(Request $request)
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
        $branches =  Branch::orderBy('name','asc')->get();
        if(!!$request->branch && $request->branch != 'all')
        {
            $branch = Branch::where('name','LIKE', '%'.$request->branch.'%')->first();
            $posts = Post::query()->with('employeeInfo','branch')->where('owner_id',$branch->owner_id)->latest()->paginate(10);
            return view("admin.Dashboard",compact('posts','branches'));
        }
        $posts = Post::query()->with('employeeInfo','branch')->latest()->paginate(10);


        return view("admin.Dashboard",compact('posts','branches'));
    }

    public function appointment()
    {

        $appointments = Reservation::with('postInfo','branchInfo')->orderBy('id','desc')->paginate(10);
        return view('admin.reservation',compact('appointments'));
    }


    public function account()
    {

        $owners = User::where('role',2)->orderBy('id','desc')->paginate(8);
        return view("admin.Accounts",compact('owners'));
    }
    public function branch()
    {
        $owners = User::where('role',2)->latest()->get();
        $branches = Branch::with('ownerInfo')->latest()->paginate(8);
        return view('admin.Branch',compact('owners','branches'));
    }
    public function store_account(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',

        ]);
        $user = User::query()->create([
            "firstname"=> ucfirst($request->firstname),
            "lastname"=> ucfirst($request->lastname),
            "email"=> $request->email,
            'role'=>2,
            'email_verified_at'=>now(),
            'password'=>Hash::make($request->password)
        ]);
        $user->markEmailAsVerified();
        if($user)
        {
            $filename = time().'-owner.'.$request->profile->extension();
            $user->update([
                'profile'=> '/storage/owner/'.$filename
            ]);
            $request->profile->storeAs('public/owner',$filename);
        }
    }

    public function update_account(Request $request ,User $id)
    {
        $id->update([
            "firstname"=> ucfirst($request->firstname),
            "lastname"=> ucfirst($request->lastname),
            "email"=> $request->email,
        ]);

        if(!!$request->password)
        {
            $id->update(['password'=>Hash::make($request->password)]);
        }
        if(!!$request->profile)
        {
            $filename = time().'-owner.'.$request->profile->extension();
            if (!!$id->profile) {
                unlink(substr($id->profile, 1));
            }
            $id->update([
                'profile'=>'/storage/owner/'.$filename
            ]);
            $request->profile->storeAs('public/owner',$filename);
        }
    }

    public function store_branch(Request $request)
    {
        $branch = Branch::query()->create([
            'name'=>$request->name,
            'number'=>$request->number,
            'location'=>$request->location,
            'email'=>$request->email,
            'status'=>$request->status,
            'owner_id'=>$request->owner_id,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'lat_long'=>$request->lat_long,
        ]);
        // $start = Carbon::parse($request->start_time);
        // $end = Carbon::parse($request->end_time)->subHours(1);

        // if( $start->diffInHours($end) % 2 != 0)
        // {

        //     $end = Carbon::parse($request->end_time)->subHour();

        // }
        // $currentDateTime = $start->copy();

        // while ($currentDateTime <= $end) {
        //     $nextDateTime = $currentDateTime->copy()->addHour();

        //     $x = $currentDateTime->format('h:ia') . ' to ' . $nextDateTime->format('h:ia');
        //     BranchTime::create([
        //         'branch_id'=>$branch->id,
        //         'time'=>$x
        //     ]);
        //     $currentDateTime = $nextDateTime;
        // }
        if($branch)
        {
            $filename = time().'-branch.'.$request->photo->extension();
            $branch->update([
                'photo'=>'/storage/branch/'.$filename
            ]);
            $request->photo->storeAs('public/branch',$filename);
        }
    }
    public function update_branch(Request $request, Branch $id)
    {
        $id->update([
            'name'=>$request->name,
            'number'=>$request->number,
            'location'=>$request->location,
            'email'=>$request->email,
            'status'=>$request->status,
            'owner_id'=>$request->owner_id,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'lat_long'=>$request->lat_long,
        ]);
        // BranchTime::where('branch_id',$id->id)->delete();
        // $start = Carbon::parse($request->start_time);
        // $end = Carbon::parse($request->end_time)->subHours(1);

        // if( $start->diffInHours($end) % 2 != 0)
        // {

        //     $end = Carbon::parse($request->end_time)->subHour();

        // }
        // $currentDateTime = $start->copy();

        // while ($currentDateTime <= $end) {
        //     $nextDateTime = $currentDateTime->copy()->addHour();

        //     $x = $currentDateTime->format('h:ia') . ' to ' . $nextDateTime->format('h:ia');
        //     BranchTime::create([
        //         'branch_id'=>$id->id,
        //         'time'=>$x
        //     ]);
        //     $currentDateTime = $nextDateTime;
        // }

        if(!!$request->photo)
        {
            $filename = time().'-branch.'.$request->photo->extension();
            if(!!$id->photo)
            {
                unlink(substr($id->photo, 1));

            }
            $id->update([
                'photo'=>'/storage/branch/'.$filename
            ]);
            $request->photo->storeAs('public/branch',$filename);
        }
    }
    public function delete_branch(Branch $id)
    {
        Reservation::where('branch_id',$id->id)->delete();
        $id->delete();
        return back()->with('success','true');
    }
}
