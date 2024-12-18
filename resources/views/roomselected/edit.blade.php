<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Edit Room Selected</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">RoomSelecteds</li>
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
                <form role="form" id="quickForm" action="{{ route('selecteds.update', $selected->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-8 offset-md-2">
                  <div class="form-group">
                    <label>Room No.</label>
                    <input type="text" name="room_no" class="form-control" placeholder="ex. RM-0001" value="{{$selected->room_no}}">
                    @if ($errors->has('room_no'))
                    <span class="text-danger" style="color: red">{{ $errors->first('room_no') }}</span>
                    @endif 
		  </div></div>
		
		  <div class="col-md-8 offset-md-2">
        <div class="form-group">
        <label>Bed Numbers</label>
        <select name="bed_no" class="form-control">
            <option value="" disabled selected>Select Bed Number</option>
            <option value="BD - 1" {{ $selected->bed_no == 'BD - 1' ? 'selected' : '' }}>BD - 1</option>
            <option value="BD - 2" {{ $selected->bed_no == 'BD - 2' ? 'selected' : '' }}>BD - 2</option>
            <option value="BD - 3" {{ $selected->bed_no == 'BD - 3' ? 'selected' : '' }}>BD - 3</option>
            <option value="BD - 4" {{ $selected->bed_no == 'BD - 4' ? 'selected' : '' }}>BD - 4</option>
            <option value="BD - 5" {{ $selected->bed_no == 'BD - 5' ? 'selected' : '' }}>BD - 5</option>
            </select>
             </div>
       </div> 

            <div class="col-md-8 offset-md-2">
                    <label>Bed Status</label>
                    <div class="form-group">
                        <select class="form-control" name="bed_status">
                             <option value="occupied" {{ $selected->bed_status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="available" {{ $selected->bed_status == 'available' ? 'selected' : '' }}>Available</option>
                        </select>
                </div></div>



                  <div class="col-md-8 offset-md-2">
                  <div class="form-group">
                    <label>Description</label>
                    <input class="form-control" name="description" placeholder="ex. Neque porro quisquam est qui dolorem ipsum quia dolor sit amet" value="{{$selected->description}}">
                    @if ($errors->has('description'))
                    <span class="text-danger" style="color: red">{{ $errors->first('description') }}</span>
                    @endif 
                  </div></div>
                  <div class="col-md-8 offset-md-2">
                  
                    <div class="form-group">
                        <label for="exampleInputPassword1">Room Picture</label>
                      </div>
                      @php
                      $profiles = [
                          ['profile' => 'profile1', 'caption' => 'caption1'],
                          ['profile' => 'profile2', 'caption' => 'caption2'],
                          ['profile' => 'profile3', 'caption' => 'caption3'],
                          ['profile' => 'profile4', 'caption' => 'caption4'],
                          ['profile' => 'profile5', 'caption' => 'caption5'],
                          ['profile' => 'profile6', 'caption' => 'caption6'],
                      ];
                  @endphp

                  <div class="image-grid">
                      @foreach ($profiles as $index => $profile)
                          @php
                              $imagePath = $selected->{$profile['profile']};
                              $imageExists = $imagePath && file_exists(public_path('storage/' . $imagePath));
                              $imageSrc = $imageExists ? asset('storage/' . $imagePath) : '';
                              $caption = $selected->{$profile['caption']} ?? '';
                          @endphp

                          @if ($imageExists || $caption)
                              <div class="form-group image-item">
                                  <div class="image-container">
                                      @if ($imageExists)
                                          <img id="preview{{ $index + 1 }}" src="{{ $imageSrc }}" class="image-preview mt-2">
                                      @else
                                          <img id="preview{{ $index + 1 }}" src="{{ asset($selected->{$profile['profile']}) }}" class="image-preview mt-2">
                                      @endif
                                      
                                      <div class="file-input-container">
                                        <input type="file" name="{{ $profile['profile'] }}" accept=".png, .jpg, .jpeg" onchange="previewImage(event, 'preview{{ $index + 1 }}')">
                                    </div>
                                    

                                      <div class="caption-container">
                                          <input type="text" name="{{ $profile['caption'] }}" class="caption-input" placeholder="Enter caption" value="{{ $caption }}">
                                      </div>
                                  </div>
                              </div>
                          @endif
                      @endforeach
                  </div>
		    </div>


<div class="col-md-8 offset-md-2">
    <div class="form-group">
        <label for="hubrental_id">Your Hubrental</label>
        <input type="text" class="form-control" value="{{ $hubrentals->find($selected->hubrental_id)->address }}" readonly>
    </div>
</div>
                 </div>
                </div><br><br>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
          .image-grid {
              display: flex;
              flex-wrap: wrap;
              gap: 10px; /* Space between images */
              justify-content: center; /* Center the images horizontally */
          }
      
          .image-item {
              flex-basis: calc(33.33% - 10px); /* Takes 1/3 of the width minus some space for margins */
              display: flex;
              flex-direction: column;
              align-items: center;
          }
      
          .image-container {
              position: relative;
              width: 100%; /* Full width for responsiveness */
              max-width: 200px; /* Max width of the image container */
              height: 200px; /* Fixed height */
          }
      
          .image-preview {
              width: 100%;
              height: 100%;
              object-fit: cover; /* Ensures the image covers the area without distortion */
          }
      
          .file-input-container {
              position: absolute;
              top:8px; /* Distance from the top */
              left: 50%;
              transform: translateX(-50%);
              z-index: 10;
              width: 100%;
              text-align: center;
              padding: 5px;
              background: rgba(255, 255, 255, 0.7);
              border-radius: 5px; 
          }
      
          .file-input-container input[type="file"] {
              cursor: pointer; /* Show pointer cursor */
              width: 100%; /* Make it cover the container area */
          }
      
          .caption-container {
              position: absolute;
              bottom: -4%;
              left: 50%;
              transform: translateX(-50%);
              width: 100%;
              padding: 5px;
              background: rgba(0, 0, 0, 0.5);
          }
      
          .caption-input {
              width: 100%;
              background: transparent;
              border: none;
              color: white;
              text-align: center;
          }
      </style>

      <script>
          function previewImage(event, previewId) {
              var input = event.target;
              var preview = document.getElementById(previewId);

              var reader = new FileReader();
              reader.onload = function() {
                  preview.src = reader.result;
                  preview.style.display = 'block'; // Ensure the image is displayed
              };

              if (input.files[0]) {
                  reader.readAsDataURL(input.files[0]); // Read the new uploaded file
              } else {
                  preview.src = ''; // Clear the preview if no file is selected
                  preview.style.display = 'none'; // Hide the preview if no file is selected
              }
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
      html: '<img src="{{ asset('logo.png') }}" alt="Logo" width="50" height="46"><br><h2>Are you sure?</h2>Do you want to update this room select?',
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


    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
        });
    </script>
    @endif
</x-app-layout>
