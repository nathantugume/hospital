<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //
    public function addview(){
        return view("admin.add_doctor");
    }

    public function add_doctor(Request $request){
        $doctor = new doctor;

        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;

        $image = $request->file;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $request->file->move('doctorimage', $imagename);
        $doctor->image = $imagename;

        $doctor->save();

        Alert::success('Congragulations', 'Doctor added successfully');
        return redirect()->back()->with('message','Doctor added Successfully');

    }

}
