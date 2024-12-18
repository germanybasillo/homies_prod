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
   $hubrentals = App\Models\Hubrental::with(['selecteds' => function($query) {
    // Remove this line to no longer filter by user_id
    // $query->where('user_id', Auth::id());
}])->get();
    $tenantprofiles = App\Models\Tenantprofile::all();
 $users = \App\Models\User::where('user_type', 'rental_owner')->get();
  @endphp

              <form role="form" id="quickForm" action="{{ route('booking_messages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
		  <div class="row">

                       <div class="form-group" style="display:none;">
                              <label>Address</label>
                              <input class="form-control" name="address" value="{{ $tenantprofiles->first()->address }}"  readonly>
                          </div>


                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Room No.</label>
                                <select name="selected_id" id="selected" class="form-control" onchange="updateRoomDetails()">
                                    <option value="" disabled selected>Select A Room Number</option>
				  @foreach($hubrentals as $hubrental)
				 @foreach ($hubrental->selecteds as $selected)

                                        <option value="{{ $selected->id }}" 
						data-description="{{ $selected->description }}"
						 data-bed_no="{{ $selected->bed_no }}" 
					         data-bed_status="{{ $selected->bed_status }}"  
                                                {{ old('selected_id', $selectedRoomId ?? '') == $selected->id ? 'selected' : '' }}>
					    {{ $selected->room_no }} - Name: {{ $hubrental->name }} - Location:{{ $hubrental->address }}
 
                                        </option>
					@endforeach
					@endforeach
				</select>
                     @error('selected_id')
                     <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                            </div>
                        </div>
           			 
                     
                        <div id="room-details" class="col-md-8 offset-md-2" style="display: none;">
                           
                        <div class="col-md-8 offset-md-2">
                          <div class="form-group">
                              <label for="exampleInputPassword1">Room Picture</label>
                              <div id="room-pictures">
                                @foreach($hubrentals as $hubrental)
				 @foreach ($hubrental->selecteds as $selected)
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
				@endforeach
                          </div>
                      </div>
                    </div>

                  <div class="form-group">
                              <label>Description</label>
                              <input id="description" class="form-control" name="description" readonly>
			  </div>

		 <div class="form-group">
                              <label>Bed No</label>
                              <input id="bed_no" class="form-control" name="bed_no" readonly>
			  </div>

                        <div class="form-group">
                              <label>Bed Status</label>
                              <input id="bed_status" class="form-control" name="bed_status" readonly>
			  </div>
                    </div>
		
                 <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" placeholder="ex. 120.00" value="{{ old('start_date') }}">
                                @if ($errors->has('start_dater'))
                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                            @endif
                            </div>
                        </div>
            
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" name="due_date" class="form-control" placeholder="ex. 6000.00" value="{{ old('due_date') }}">
                                @if ($errors->has('due_date'))
                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                            @endif
                            </div>
			</div>


		<div class="col-md-8 offset-md-2">
       		 <div class="form-group">
        	<label for="receiver_id">Rental Owner Name</label>
        	<select name="receiver_id" class="form-control">
        	    <option value="" disabled selected>Select Name</option>
        	    @foreach($users as $user)
        	    <option value="{{ $user->id }}">{{ $user->name}}</option>
        	    @endforeach
        	    </select>
        	     </div>
		       </div>
 

        
                  <div class="col-md-8 offset-md-2" style="display:none">
                      <div class="form-group">
                         <label>Status</label>
                               <select class="form-control" name="status">
                         <option value="pending" style="color:red">Pending</option> 
                      <option value="approaved" style="color:green">Approved</option>
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
function updateRoomDetails() {
    var select = document.getElementById('selected');
    var selectedOption = select.options[select.selectedIndex];
    var selectedRoomId = select.value;
    var roomDetails = document.getElementById('room-details');
    var roomImages = document.querySelectorAll('.room-images');

    // Update room description, bed_no, and bed_status fields
    if (selectedRoomId) {
        roomDetails.style.display = 'block';
        document.getElementById('description').value = selectedOption.getAttribute('data-description') || '';
        document.getElementById('bed_no').value = selectedOption.getAttribute('data-bed_no') || '';
        document.getElementById('bed_status').value = selectedOption.getAttribute('data-bed_status') || '';

        // Show the images for the selected room and hide others
        roomImages.forEach((container) => {
            container.style.display = container.getAttribute('data-id') === selectedRoomId ? 'block' : 'none';
        });
    } else {
        roomDetails.style.display = 'none';
        document.getElementById('description').value = '';
        document.getElementById('bed_no').value = '';
        document.getElementById('bed_status').value = '';
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

       </x-app-layout>
