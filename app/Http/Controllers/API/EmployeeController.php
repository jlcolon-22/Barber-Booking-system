<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\User;
use App\Models\Certificate;
use App\Models\Reservation;
use App\Models\Branch;

class EmployeeController extends Controller
{
    public function appointment()
    {
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
         \Mail::to($id->email)->send(new \App\Mail\Reservation($data));
        $owners = User::where('owner_id',$branch->owner_id)->latest()->get();
         $owner = [
                  'name' => $id->firstname.' '.$id->lastname,
            'email' => $id->email,
            'date'=>$id->date,
            'time'=>$id->time,
            'message'=>$id->firstname.' '.$id->lastname." reservation is finished."
         ];
            \Mail::to($branch->ownerInfo->email)->send(new \App\Mail\Reservation($owner));

        if($owners)
        {
            foreach ($owners as $key => $value) {
                \Mail::to($value->email)->send(new \App\Mail\Reservation($owner));
            }
        }
        return back()->with('success','true');
    }
}
