@include('user.header');
<div class="page-section">
    @include('sweetalert::alert')
      <div class="container">
        <h1 class="text-center wow fadeInUp">My Appointments</h1>

        <table class="table table-stripped data-table">
            <tr>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Message</th>
                <th>Status</th>
                <th>Picture</th>
                <th>Action</th>

            </tr>
            <tbody>
                @foreach ($appoint as $appoints)          
     
                    <tr>
                    <td>{{$appoints->pname}}</td>
                    <td>{{$appoints->date}}</td>
                    <td>{{$appoints->reason}}</td>
                    <td>{{$appoints->status ? "pending":"approved"}}</td>
                    <td><img style="width: 40px;border-radius: 50%;" src="doctorimage/{{$appoints->image}}" alt="{{$appoints->name}}"></td>
                    <td><a href="{{url('cancel_appointment',$appoints->id)}}" class="btn btn-danger">Cancel</a></td>
                </tr> 
                @endforeach
             
            </tbody>
        </table>

      </div>
    </div> <!-- .page-section -->

@include('user.footer');