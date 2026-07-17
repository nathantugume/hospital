<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Notifications\SendEmail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\SendEmailNotification;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointment = appointment::select('appointments.id','appointments.name as pname','appointments.date','appointments.email','appointments.phone','appointments.doctor_id','appointments.reason','appointments.status','doctors.name as doctor_name')
                                    ->leftJoin('doctors','appointments.doctor_id','=','doctors.id')
                                    ->get();

        // $appointment = appointment::join('doctors','doctor_id','=','doctorid')


        return view('admin.view_appointments',['appointment'=>$appointment]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $appointment = new appointment;
        $appointment->name = $request->name;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone;
        $appointment->reason = $request->reason;
        $appointment->date = $request->date;
        $appointment->doctor_id = $request->doctor;

        if(Auth::id()){
            $appointment->user_id = Auth::user()->id;
        }

        $appointment->save();
        Alert::success("Congragulations","Appointment saved successfully!");
        return redirect()->back();


    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
      
        return view("admin.view_appointments", compact("appointment"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }

    public function myappointment(){
        if(Auth::id())
        {
            $userid = Auth::user()->id;
            $appoint = appointment::where('user_id',$userid)->get();
            return view('user.my_appointment',compact('appoint'));
        }
        else{
          Alert::error("Failed","Please Login to access appointments");
        return redirect()->back();  
        }
        
    }

    public function cancel_appointment($id){
        $appointment = Appointment::where('id',$id)->update(['status'=>3]);
 
        Alert::success("Congragulations","Appointment cancelled successfully!");

        return redirect()->back();

    }


    public function emailview($id){
        $data= appointment::find($id);
        return view('admin.email_view',compact('data'));
    }

    public function sendemail(Request $request,$id){
      $data = appointment::find($id);
      $details =  [
        'subject' => $request->subject,
        'email_text' => $request->email_text,
        'action_text' => $request->action_text,
        'action_url' => $request->action_url,
        'footer' => $request->footer
      ];

      Notification::send($data,new SendEmailNotification($details));

      Alert::success("Congragulations","Email sent successfully!");

      return redirect()->back();


    }
}
