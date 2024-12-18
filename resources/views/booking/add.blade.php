<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Choose Room and Bed</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Room and Bed</li>
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
 @php
   $selecteds = App\Models\Selected::all();
   $selectbeds = App\Models\Selectbed::all();
   $tenantprofiles = App\Models\Tenantprofile::all();
  @endphp

              <form role="form" id="quickForm" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
		  <div class="row">

                       <div class="form-group" style="display:none;">
                              <label>Address</label>
                              <input class="form-control" name="address" value="{{ $tenantprofiles->first()->address }}"  readonly>
                          </div>


                  <div class="col-md-8 offset-md-2" style="display:none">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div></div>


                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Room No.</label>
                                <select name="selected_id" id="selected" class="form-control" onchange="updateRoomDetails()">
                                    <option value="" disabled selected>Select A Room Number</option>
                                    @foreach($selecteds as $selected)
                                        <option value="{{ $selected->id }}" 
                                                data-description="{{ $selected->description }}" 
                                                {{ old('selected_id', $selectedRoomId ?? '') == $selected->id ? 'selected' : '' }}>
                                            {{ $selected->room_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
            
                     
                        <div id="room-details" class="col-md-8 offset-md-2" style="display: none;">
                         
                          <div class="form-group">
                              <label>Description</label>
                              <input id="description" class="form-control" name="description" readonly>
                          </div>

                          
                        <div class="col-md-8 offset-md-2">
                          <div class="form-group">
                              <label for="exampleInputPassword1">Room Picture</label>
                              <div id="room-pictures">
                                @foreach($selecteds as $selected)
                                <div class="slideshow-container room-images" data-id="{{ $selected->id }}" style="display: none;">
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
                            
                                    @foreach ($profiles as $profile)
                                        @php
                                            $profilePath = $selected->{$profile['profile']};
                                            $captionText = $selected->{$profile['caption']};
                                            $imagePath = storage_path('app/public/' . $profilePath);
                                            $isImageExists = file_exists($imagePath);
                                        @endphp
                            
                                        @if ($profilePath)
                                            <div class="mySlides">
                                                <img 
                                                    src="{{ $isImageExists ? asset('storage/' . $profilePath) : asset($profilePath) }}" 
                                                    alt="{{ $captionText }}">
                                                <div class="text">{{ $captionText }}</div>
                                            </div>
                                        @endif
                                    @endforeach
                            
                               
                                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                </div>
                            @endforeach
                          </div>
                      </div>
                    </div>
                </div>
                 <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Check In</label>
                                <input type="date" name="check_in" class="form-control" placeholder="ex. 120.00" value="{{ old('check_in') }}">
                                @if ($errors->has('check_in'))
                                <span class="text-danger">{{ $errors->first('check_in') }}</span>
                            @endif
                            </div>
                        </div>
            
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Check Out</label>
                                <input type="date" name="check_out" class="form-control" placeholder="ex. 6000.00" value="{{ old('check_out') }}">
                                @if ($errors->has('check_out'))
                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                            @endif
                            </div>
                        </div> 

            <div class="col-md-8 offset-md-2">
                  <div class="form-group">
                    <label>Bed No.</label>
                    <select name="selectbed_id" id="selectbed" class="form-control" onchange="updateBedDetails()">
                      <option value="" disabled selected>Select A Room Number</option>
                      @foreach($selectbeds as $selectbed)
                          <option value="{{ $selectbed->id }}" 
                                  data-status="{{ $selectbed->bed_status }}"
                                  data-descript="{{ $selectbed->description }}"
                                  {{ old('selectbed_id', $selectbedId ?? '') == $selectbed->id ? 'selected' : '' }}>
                              {{ $selectbed->bed_no }}
                          </option>
                      @endforeach
                  </select>
                  </div></div>
                  <div class="col-md-8 offset-md-2" id="monthlyRateContainer" style="display: none;">
                    <div class="form-group">
                    <label>Description</label>
                    <input  id="descript" name="description" class="form-control" readonly>
                  </div></div>
                  <div class="col-md-8 offset-md-2" id="bedStatusContainer" style="display: none;">
                    <div class="form-group">
                    <label>Bed Status</label>
                    <input id="status" class="form-control" name="status" readonly>
                </div>
                </div>
 
                  <div class="col-md-8 offset-md-2" style="display:none">
                      <div class="form-group">
                         <label>Status</label>
                               <select class="form-control" name="status">
                         <option value="pending" style="color:red">Pending</option> 
                      <option value="received" style="color:green">Approved</option>
                       </select>
                          </div>
                      </div>

                </div>
                </div>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    // This listens for the form submission
    document.getElementById('quickForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent immediate submission

        const formData = new FormData(this);

        // Make an AJAX request to the store method
        fetch("{{ route('booking.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Send CSRF token for security
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Handle validation errors
                let errorMessage = '';
                for (const [key, value] of Object.entries(data.errors)) {
                    errorMessage += value[0] + '\n';  // Concatenate all error messages
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Okay'
                });
            } else if (data.success) {
                // Handle success response
                Swal.fire({
                    title: 'Success!',
                    text: data.success, // Display the success message from the server
                    icon: 'success',
                    confirmButtonText: 'Okay'
                }).then((result) => {
                    // Redirect after the user clicks "Okay"
                    if (result.isConfirmed) {
                        window.location.href = "/";  // Redirect to the home page after success
                    }
                });
            }
        })
        .catch(error => {
            // Handle any unexpected errors
            console.error('Error:', error);
            Swal.fire({
                title: 'Something went wrong!',
                text: 'Please try again later.',
                icon: 'error',
                confirmButtonText: 'Okay'
            });
        });
    });
    
</script>


<script>          
     function updateRoomDetails() {
    var select = document.getElementById('selected');
    var selectedOption = select.options[select.selectedIndex];
    var selectedRoomId = select.value;
    var roomDetails = document.getElementById('room-details');
    var roomImages = document.querySelectorAll('.room-images');

    // Update room description (removed monthly due update)
    if (selectedRoomId) {
        roomDetails.style.display = 'block';
        document.getElementById('description').value = selectedOption.getAttribute('data-description') || '';

        // Show the images for the selected room and hide others
        roomImages.forEach((container) => {
            container.style.display = container.getAttribute('data-id') === selectedRoomId ? 'block' : 'none';
        });
    } else {
        roomDetails.style.display = 'none';
        roomImages.forEach((container) => {
            container.style.display = 'none';
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateRoomDetails();
});

      let slideIndex = 1;

function showSlides(n) {
    let slides = document.querySelectorAll(".room-images[data-id='" + document.getElementById('selected').value + "'] .mySlides");
    if (slides.length === 0) return; // Exit if no slides are available
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slides[slideIndex - 1].style.display = "block";  
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

document.addEventListener("DOMContentLoaded", function() {
    // Ensure the first slide is shown when the page is loaded
    let containers = document.querySelectorAll('.slideshow-container');
    containers.forEach(container => {
        container.style.display = 'block';
        showSlides(slideIndex);
    });
});

// Update the slides when a new room is selected
document.getElementById('selected').addEventListener('change', function() {
    slideIndex = 1; // Reset to the first slide when a new room is selected
    showSlides(slideIndex);
});
      </script>

<style>
   .slideshow-container {
    position: relative;
    max-width: 80%;
    margin: auto;
}

.mySlides {
    display: none;
    position: relative;
}

.mySlides img {
    width: 100%; /* Ensure images fill the container width */
    height: 300px; /* Set a fixed height for the images */
    object-fit: cover; /* Maintain aspect ratio while filling the container */
    border: 2px solid gray;
    margin: 5px;
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
}

.text {
    color: #f2f2f2;
    font-size: 20px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: auto;
    max-width: 100%;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 5px;
}
</style>

<script>
               function updateBedDetails() {
            const selectbed = document.getElementById('selectbed');
            const statusInput = document.getElementById('status');
            const descriptionInput = document.getElementById('descript');
            const bedStatusContainer = document.getElementById('bedStatusContainer');
            const monthlyRateContainer = document.getElementById('monthlyRateContainer');

            if (selectbed.selectedIndex > 0) {
                const selectedOption = selectbed.options[selectbed.selectedIndex];
                const status = selectedOption.getAttribute('data-status');
                const description = selectedOption.getAttribute('data-descript');

                statusInput.value = status || 'N/A';
                descriptionInput.value = description || 'N/A';

                bedStatusContainer.style.display = 'block';
                monthlyRateContainer.style.display = 'block';
            } else {
                statusInput.value = '';
                descriptionInput.value = '';
                bedStatusContainer.style.display = 'none';
                monthlyRateContainer.style.display = 'none';
            }
        }   
</script>





       </x-app-layout>
