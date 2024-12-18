<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Edit Tenants Profile</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Tenants Profile</li>
                  </ol>
                </div>
              </div>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-success">
              <!-- form start -->
              <form role="form" id="quickForm" action="{{ route('tenantprofiles.update', $tenantprofile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" class="form-control" placeholder="Last Name" value="{{$tenantprofile->lname}}">
                    @if ($errors->has('lname'))
                    <span class="text-danger" style="color: red">{{ $errors->first('lname') }}</span>
                    @endif 
                  </div></div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" class="form-control" placeholder="First Name" value="{{$tenantprofile->fname}}">
                    @if ($errors->has('fname'))
                    <span class="text-danger" style="color: red">{{ $errors->first('fname') }}</span>
                    @endif 
                  </div></div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" name="mname" class="form-control" placeholder="Middle Name" value="{{$tenantprofile->mname}}">
                    @if ($errors->has('mname'))
                    <span class="text-danger" style="color: red">{{ $errors->first('mname') }}</span>
                    @endif 
                  </div>
                  </div>
                  <div class="col-md-12">
                  <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" name="address" placeholder="ex. Manggahan, Pasig City, Manila" value="{{$tenantprofile->address}}">
                    @if ($errors->has('address'))
                    <span class="text-danger" style="color: red">{{ $errors->first('address') }}</span>
                    @endif 
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="ex. email@gmail.com" value="{{$tenantprofile->email}}">
                    @if ($errors->has('email'))
                    <span class="text-danger" style="color: red">{{ $errors->first('email') }}</span>
                    @endif 
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control" placeholder="ex. 09654645341" value="{{$tenantprofile->contact}}">
                    @if ($errors->has('contact'))
                    <span class="text-danger" style="color: red">{{ $errors->first('contact') }}</span>
                    @endif 
                  </div>
                  </div>
                  <div class="col-md-4">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                      <option value="male" {{ $tenantprofile->gender == 'male' ? 'selected' : '' }}>Male</option>
                      <option value="female" {{ $tenantprofile->gender == 'female' ? 'selected' : '' }}>Female</option>
                  </select>
                  </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Profile</label>
                    <input type="file" name="profile" class="form-control" accept=".png, .jpg, .jpeg" onchange="previewImage(event)" style="width: 7%; border:none;">
                  </div>
                  @if($tenantprofile->profile)
                  @if(file_exists(public_path('storage/' . $tenantprofile->profile)))
                      <img id="preview" src="{{ asset('storage/' . $tenantprofile->profile) }}" alt="User Image" class="profile-image">
                  @else
                      <img id="preview" src="{{ asset($tenantprofile->profile) }}" alt="User Image" class="profile-image">
                  @endif
                @else
                  <img id="preview" src="{{ asset('avatar.jpg') }}" alt="Preview" class="profile-image">
                @endif
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <style>
        .profile-image {
          border-radius: 50%;
         width: 150px;
         height: 150px;
         object-fit: cover;
        }
        </style>
      <script>
        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('preview');
        
            var reader = new FileReader();
            reader.onload = function(){
                preview.src = reader.result;
            };
        
            reader.readAsDataURL(input.files[0]);
        }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        document.getElementById('quickForm').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevent the form from submitting immediately
  
          Swal.fire({
              // title: 'Are you sure?',
              // text: 'Do you want to save the changes?',
              icon: null, // Disable the default icon
              html: '<img src="{{ asset('logo.png') }}" alt="Logo" width="50" height="46"><br><h2>Are you sure?</h2>Do you want to save the changes?',
              showCancelButton: true,
              confirmButtonText: 'Yes, save it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if (result.isConfirmed) {
                  event.target.submit(); // If confirmed, submit the form
              }
          });
      });
  </script>
</x-app-layout>
