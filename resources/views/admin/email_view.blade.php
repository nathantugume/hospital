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
                          <h4 class="card-title">Send Mail</h4>
                     
                          <form class="forms-sample" action="{{url('sendemail',$data->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="name">Subject</label>
                              <input type="text" name="subject" @required(true) class="form-control" id="subject" placeholder="Enter Subject">
                            </div>
           
                            <div class="form-group">
                              <label for="exampleInputEmail1">Body</label>
                               <textarea class="form-control" name="email_text" id="email_text" cols="30" rows="5"></textarea>
                            </div>
                        
                      
                              <div class="form-group">
                                <label for="action_text">Action Text</label>
                                <input type="text" name="action_text" @required(true) class="form-control" id="action_text" placeholder="Action">
                              </div>
                              <div class="form-group">
                                <label for="action_url">Action Url</label>
                                <input type="text" name="action_url" @required(true) class="form-control" id="action_url" placeholder="url">
                              </div>

                              <div class="form-group">
                                <label for="footer">Footer</label>
                                <input type="text" name="footer" @required(true) class="form-control" id="footer" placeholder="Email footer">
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