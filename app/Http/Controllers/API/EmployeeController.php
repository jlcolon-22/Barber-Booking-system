<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Branch;
use App\Models\Certificate;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
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
                    $value->update(['status'=>3]);
                }


            }
            elseif($checkDate > 0)
            {
                $value->update(['status'=>3]);
            }

        }
           $branch = Branch::where('owner_id',Auth::user()->owner_id)->first();
        $appointments = Reservation::with('postInfo','branchInfo')->where('branch_id',$branch->id)->where('status',1)->orWhere('status',3)->latest()->paginate(10);

        return view('employee.reservation',compact('appointments'));
    }
    public function update_appointment(Reservation $id)
    {
        $id->update([
            'status' => 3
        ]);
$branch = Branch::with('ownerInfo')->where('id',$id->branch_id)->first();
        $data = [
            'name' => $id->firstname.' '.$id->lastname,
            'email' => $id->email,
            'date'=>$id->date,
            'time'=>$id->time,
            'message'=>'Your reservation is finished.'
        ];
         Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id',$branch->owner_id)->latest()->get();
         $owner = [
                  'name' => $id->firstname.' '.$id->lastname,
            'email' => $id->email,
            'date'=>$id->date,
            'time'=>$id->time,
            'message'=>$id->firstname.' '.$id->lastname." reservation is finished."
         ];
            Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if($owners)
        {
            foreach ($owners as $key => $value) {
                Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }
        return back()->with('success','true');
    }
}
