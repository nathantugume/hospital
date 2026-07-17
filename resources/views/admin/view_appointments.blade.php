{{-- header --}}
@include('admin.header')

<style>
    .label-design{
        color: aliceblue;
    }
    th{
      text-align: center;
      color:white;
    }
</style>

    {{-- sidebar --}}
    @include('admin.sidebar')

    {{-- navbar --}}
    @include('admin.navbar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
        
             <div class="container" >
                @include('sweetalert::alert')
                {{-- @include('admin.alert') --}}


                <div class="row" style="align-content: center">
                    <div class="col-lg-12 grid-margin stretch-card" >
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Appointments</h4>
                     
                          <div class="table-responsive">
                             <table class="table table-stripped" style="width: 80%">
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Phone</th>
                                <th>status</th>
                                <th>Mail</th>
                                <th>Action</th>

                                <tbody>
                                    @foreach ($appointment as $appointments)
                               
                                    <tr>
                                    <td>{{$appointments->id}}</td>
                                    <td>{{$appointments->pname}}</td>
                                    <td>{{$appointments->date}}</td>
                                    <td>{{$appointments->doctor_name}}</td>
                                    <td>{{$appointments->phone}}</td>
                                    <td><a href="{{url('emailview',$appointments->id)}}" class="btn btn-primary"><i class="fa fa-envelope"></i>SendEmail</a></td>
                                    <td>{{$appointments->status ? "revised" : "pending"}}</td>
                                    <td>
                                        <button class="btn"><i class="fa fa-edit"></i></button>
                                        <button class="btn"><i class="fa fa-eye"></i></button>
                                        <button class="btn"><i class="fa fa-trash"></i></button>
                                    </td>
                                    </tr> 
                                        
                                    @endforeach
                                </tbody>



                            </table>
                          </div>
                       



                        </div>
                      </div>
                    </div>
            
          
                
               
               
                
                  </div>
            
            </div>

    
                </div>
    {{-- footer --}}
    @include('admin.footer')