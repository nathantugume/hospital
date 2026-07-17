{{-- header --}}
@include('admin.header')

<style>
    .label-design{
        color: aliceblue;
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
                      <div class="card" >
                        <div class="card-body">
                          <h4 class="card-title">Add Doctor</h4>
                     
                          <form class="forms-sample" action="{{url('add_doctor')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="name">Doctor Name</label>
                              <input type="text" name="name" @required(true) class="form-control" id="name" placeholder="Doctor Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Speciality</label>
                                <select style="color: white" name="speciality" class="form-control" id="exampleSelectSpeciality">
                                  <option value="">-- Select speciality--</option>  
                                  <option value="skin">Skin</option>
                                  <option value="heart">Heart</option>
                                  <option value="eye">Eyes</option>
                                  <option value="bones">Bones</option>
                               
                                </select>
                              </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" name="email" @required(true) class="form-control" id="exampleInputEmail1" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone1">Phone Number</label>
                                <input type="tel" name="phone" @required(true) class="form-control" id="exampleInputPhone1" placeholder="Phone number">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputRoomNumber">Room Number</label>
                                <input type="number" name="room" @required(true) class="form-control" id="exampleInputRoomNumber" placeholder="Room number">
                              </div>
                       
                              <div class="form-group">
                                <label>Image upload</label>
                                <input type="file" @required(true) name="file" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                  </span>
                                </div>
                              </div>
                            <div class="form-check form-check-flat form-check-primary">
              
                            <button type="submit" class="btn btn-md btn-primary me-4">Submit</button>
                         
                          </form>
                        </div>
                      </div>
                    </div>
            
          
                
               
               
                
                  </div>
            
            </div>

    
                </div>
    {{-- footer --}}
    @include('admin.footer')