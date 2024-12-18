<script>
    // Ensure SweetAlert2 is loaded before executing the script
    // Check that SweetAlert2 library is loaded
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 is not loaded');
    } else {
        // Listen for the button click event
        document.getElementById('bookNowButton').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default anchor tag behavior

            // First SweetAlert modal with "Book Now?" button inside it
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to book a room?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'No, cancel',
                focusConfirm: false,
                preConfirm: () => {
                    // Show second SweetAlert modal with booking form
                    Swal.fire({
                        title: 'Booking Form',
				html: `      
	<form id="bookingForm" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
  
                <div class="card-body">
                   
		   <div class="row">
                    <div class="col centered">
                        <div class="form-group">
                            <label for="selectbed">Bed No.</label>
                            <select name="selectbed_id" id="selectbed" class="form-control" onchange="updateBedDetails()">
                                <option value="" disabled selected>Select A Bed Number</option>
                                @foreach($selectbeds as $selectbed)
                                    <option value="{{ $selectbed->id }}" 
                                        data-status="{{ $selectbed->bed_status }}"
                                        data-description="{{ $selectbed->description }}"
                                        {{ old('selectbed_id', $selectbedId ?? '') == $selectbed->id ? 'selected' : '' }}>
                                        {{ $selectbed->bed_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="col centered" id="monthlyRateContainer" style="display: none;">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input id="description" name="description" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col centered" id="bedStatusContainer" style="display: none;">
                        <div class="form-group">
                            <label for="status">Bed Status</label>
                            <input id="status" name="status" class="form-control" readonly>
                        </div>
                    </div>
		    </div>

		         <div class="card-body">
                            <div class="row">
                                <div class="col centered">
                                    <div class="form-group">
                                        <label>Room No.</label>
                                        <select name="selected_id" id="selected" class="form-control" onchange="updateRoomDetails()">
                                            <option value="" disabled selected>Select A Room Number</option>
                                            @foreach($selecteds as $selected)
                                                <option value="{{ $selected->id }}" 
                                                    data-room-description="{{ $selected->description }}"
                                                    data-room-monthly_due="{{ $selected->monthly_due }}" 
                                                    {{ old('selected_id', $selectedRoomId ?? '') == $selected->id ? 'selected' : '' }}>
                                                    {{ $selected->room_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="room-details" class="col centered" style="display: none;">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input id="room-description" class="form-control" name="description" readonly>
                                    </div>
                                    <div class="col centered">
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
                                                                        alt="{{ $captionText }}" class="images">
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
                                <div class="col centered">
                                    <div class="form-group">
                                        <label>Check In</label>
                                        <input type="date" name="check_in" class="form-control">
                                    </div>
                                </div>
                                <div class="col centered">
                                    <div class="form-group">
                                        <label>Check Out</label>
                                        <input type="date" name="check_out" class="form-control">
                                    </div>
				   </div>
				  <div class="col centered" style="display:none;">
                                    <div class="form-group">
                                        <label>Status</label>
					<select class="form-control" name="status">
                                        <option value="pending" style="color:red">Pending</option>
                                        <option value="underpaid" style="color:yellow">Receive/Underpaid</option>
                                        <option value="received" style="color:green">Receive/Paid</option>
                                    </select>
				</div>
                                </div>
                            </div>
			    </div>
			    </form>

  `,
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Submit',
                        focusConfirm: false,
                        preConfirm: () => {
                            // Automatically submit the form when the user clicks 'Submit'
                            document.getElementById('bookingForm').submit(); 
                        }
                    });
                }
            });
        });
    }
</script>

<script> 
// Function to update bed details based on selected bed
function updateBedDetails() {
    var bedSelect = document.getElementById("selectbed");
    var selectedOption = bedSelect.options[bedSelect.selectedIndex];
    var bedStatus = selectedOption.getAttribute("data-status");
    var description = selectedOption.getAttribute("data-description");

    // Update the bed status and description
    document.getElementById("status").value = bedStatus;
    document.getElementById("description").value = description;

    // Show the corresponding sections if needed
    document.getElementById("bedStatusContainer").style.display = bedStatus ? "block" : "none";
    document.getElementById("monthlyRateContainer").style.display = description ? "block" : "none";
}
// Function to update room details based on selected room
function updateRoomDetails() {
    var roomSelect = document.getElementById("selected");
    var selectedOption = roomSelect.options[roomSelect.selectedIndex];

    var roomDescription = selectedOption.getAttribute("data-room-description");
    var roomMonthlyDue = selectedOption.getAttribute("data-room-monthly_due");

    // Update room description and monthly due
    document.getElementById("room-description").value = roomDescription;

    // Show the room details section
    var roomDetailsContainer = document.getElementById("room-details");
    if (roomDetailsContainer) {
        roomDetailsContainer.style.display = "block";
    }

    // Show the slideshow images for the selected room
    var roomImages = document.querySelectorAll('.room-images');
    roomImages.forEach(function(slide) {
        if (slide.getAttribute('data-id') == selectedOption.value) {
            slide.style.display = 'block';
            initializeSlideshow(slide);  // Initialize the slideshow for the selected room
        } else {
            slide.style.display = 'none';
        }
    });
}

// Initialize the slideshow for each room's image container
function initializeSlideshow(slideContainer) {
    var slides = slideContainer.getElementsByClassName("mySlides");
    var slideIndex = 0;

    // Show the first slide
    showSlides(slides, slideIndex);

    // Attach event listeners to the previous and next buttons
    slideContainer.querySelector('.prev').onclick = function() {
        plusSlides(-1, slides);
    };

    slideContainer.querySelector('.next').onclick = function() {
        plusSlides(1, slides);
    };
}

// Function to change slides
function plusSlides(n, slides) {
    var slideIndex = getCurrentSlideIndex(slides);
    slideIndex += n;
    if (slideIndex >= slides.length) {
        slideIndex = 0; // Loop back to the first slide
    } else if (slideIndex < 0) {
        slideIndex = slides.length - 1; // Loop back to the last slide
    }
    showSlides(slides, slideIndex);
}

// Function to get the current slide index
function getCurrentSlideIndex(slides) {
    for (var i = 0; i < slides.length; i++) {
        if (slides[i].style.display === "block") {
            return i;
        }
    }
    return 0;  // Default to the first slide if none are visible
}

// Function to show the slides based on the index
function showSlides(slides, n) {
    for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[n].style.display = "block";
}
// Function to preview selected image
function previewImage(event) {
    var preview = document.getElementById("preview");
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function() {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>
<style>
   .slideshow-container {
    position: relative;
    width: 100;
    margin: auto;
}
.mySlides {
    display: none;
    position: relative;
}

.mySlides img{
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

  .card-body {
    padding: 16px;
  }
  .col {
    margin: 0 auto;
    width: 100%;
    max-width: 600px;
  }
  .centered {
    text-align: left;
  }
 

.custom-modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
}

.custom-modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 5px;
}

.custom-modal-close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.custom-modal-close:hover,
.custom-modal-close:focus {
    color: black;
    text-decoration: none;
}

.btn {
    margin-top: 10px;
}

  .card-body {
    padding: 16px;
  }
  .col {
    flex: 1;
    min-width: 200px;
  }
  .form-group {
    margin-bottom: 16px;
  }
  .form-control {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
  }
  .profile-image {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-top: 8px;
margin-left:150px;
  }
</style>






















<x-app-layout>
    <style>
       .profile-image {
    border-radius: 50%;
    width: 120px;  /* Default size */
    height: 120px; /* Default size */
    object-fit: cover;
    margin-bottom: 20px; /* Space below the image */
    margin-left: auto; /* Centers image horizontally */
    margin-right: auto; /* Centers image horizontally */
    display: block; /* Ensures margin auto works for centering */
}

/* Media Query for Smaller Screens */
@media (max-width: 768px) {
    .profile-image {
        width: 100px; /* Adjust for smaller screens */
        height: 100px; /* Adjust for smaller screens */
    }
}

/* Media Query for Very Small Screens (e.g., phones) */
@media (max-width: 480px) {
    .profile-image {
        width: 80px; /* Further reduce size for very small screens */
        height: 80px; /* Further reduce size for very small screens */
    }
} 
       .card-body {
          text-align: center; /* Center-align all card content */
       }
 
       .card-body h5 {
          font-size: 1.5rem; /* Increased font size */
          margin-bottom: 20px; /* Add space below the name */
       }
 
       .card-body p {
          font-size: 1.2rem; /* Increased font size */
          margin-bottom: 10px; /* Add space between information rows */
          text-align: left; /* Align text to the left */
       }
 
       .container-fluid h1 {
          font-size: 2.5rem; /* Increased header size */
       }
 
       .breadcrumb-item a {
          font-size: 1.2rem; /* Increased breadcrumb size */
       }
 
       .breadcrumb-item.active {
          font-size: 1.2rem; /* Increased breadcrumb size */
       }
 
       .modal-body h3 {
          font-size: 1.8rem; /* Increased modal text size */
       }
 
       .modal-body button {
          font-size: 1.2rem; /* Increased modal button size */
          padding: 10px 20px; /* Increased modal button padding */
       }
    </style>
 <style>
 /* General Styles */
 body {
     font-family: Arial, sans-serif;
     margin: 0;
 }
 
 * {
     box-sizing: border-box;
 }
 
 img {
     vertical-align: middle;
 }
 
 /* Image Container */
 .container {
     position: relative;
     max-width: 100%;
     margin: auto;
 }
 
 /* Slideshow Container */
 .slideshow-container {
     position: relative;
     max-width: 100%;
     margin: auto;
 }
 
 /* Hide the images by default */
 .mySlides {
     display: none;
     position: relative;
 }
 
 /* Slideshow Image */
 .mySlides img {
     width: 100%;
     height: 300px; /* Set a fixed height */
     object-fit: cover; /* Maintain aspect ratio and fill the container */
 }
 
 /* Cursor for clickable elements */
 .cursor {
     cursor: pointer;
 }
 
 /* Next & Previous Buttons */
 .prev,
 .next {
     cursor: pointer;
     position: absolute;
     top:42%;
     width: auto;
     padding: 16px;
     color: white;
     font-weight: bold;
     font-size: 20px;
     border-radius: 0 3px 3px 0;
     user-select: none;
     background-color: rgba(0, 0, 0, 0.5); /* Slightly transparent background */
 }
 
 .next {
     right: 0;
     border-radius: 3px 0 0 3px;
 }
 
 .prev {
     left: 0;
     border-radius: 3px 0 0 3px;
 }
 
 /* On hover, add a black background color with a little bit see-through */
 .prev:hover,
 .next:hover {
     background-color: rgba(0, 0, 0, 0.8);
 }
 
 /* Number Text (1/3 etc) */
 .numbertext {
     color: #f2f2f2;
     font-size: 12px;
     padding: 8px 12px;
     position: absolute;
     top: 0;
 }
 
 /* Container for Image Text */
 .caption-container {
     text-align: center;
     background-color: #222;
     padding: 2px 16px;
     color: white;
 }
 
 /* Row Clearfix */
 .row:after {
     content: "";
     display: table;
     clear: both;
 }
 
 /* Column Layout */
 .column {
     float: left;
     width: 16.66%;
 }
 
 /* Transparency for Thumbnail Images */
 .demo {
     opacity: 0.6;
 }
 
 .active,
 .demo:hover {
     opacity: 1;
 }
 
 /* Responsive Styles */
 @media only screen and (max-width: 768px) {
     .prev, .next {
         font-size: 18px;
         padding: 12px;
     }
 
     .caption-container {
         padding: 2px 10px;
     }
 
     .numbertext {
         font-size: 10px;
     }
 
     .column {
         width: 33.33%; /* Three columns on tablets */
     }
 }
 
 @media only screen and (max-width: 480px) {
     .prev, .next {
         font-size: 16px;
         padding: 10px;
     }
 
     .caption-container {
         padding: 2px 8px;
     }
 
     .numbertext {
         font-size: 8px;
     }
 
     .column {
         width: 50%; /* Two columns on small screens */
     }
 }
    </style>
 <script>
  let slideIndex = 1;
 
 function showSlides(n) {
     let i;
     let slides = document.getElementsByClassName("mySlides");
     let caption = document.getElementById("caption-text");
 
     if (n > slides.length) { slideIndex = 1 }
     if (n < 1) { slideIndex = slides.length }
     for (i = 0; i < slides.length; i++) {
         slides[i].style.display = "none";
     }
     slides[slideIndex - 1].style.display = "block";
     caption.innerText = slides[slideIndex - 1].getAttribute('data-caption');
 }
 
 function plusSlides(n) {
     showSlides(slideIndex += n);
 }
 
 // Initialize slideshow
 document.addEventListener("DOMContentLoaded", function() {
     showSlides(slideIndex);
 });
 </script>
 
    
 <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
               <h1 class="m-0 text-dark"><span class="fa fa-book"></span> Booking Profile</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">booking Profile</li>
                 </ol> 
              </div>
           </div>
        </div>
    </x-slot>
 
          <div class="row">
             <div class="col-lg-4">
                                                             
			
                         <div class="container">
                            <div class="row justify-content-center mb-2">
                                          
                                </div>
                            <div class="row justify-content-center">
                                              
                            </div>
                        </div>
                                
                @foreach($bookings as $booking)
                <div class="container" style="margin-top:-15px;">
                    <h3 class="m-0 text-dark">
                        <span class="fa fa-home"></span> Room Picture :
                        <p id="caption-text" style="margin-top: -33px;margin-left:230px;"></p></h3>
                    <div class="card-body" style="margin-top:-30px;" data-id="{{ $booking->selected->id }}">
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
                        <div class="slideshow-container">
                            @foreach ($profiles as $profile)
                                @php
                                    $profilePath = $booking->selected->{$profile['profile']};
                                    $captionText = $booking->selected->{$profile['caption']};
                                    $imagePath = storage_path('app/public/' . $profilePath);
                                    $isImageExists = file_exists($imagePath);
                                @endphp
                                @if ($profilePath)
                                    <div class="mySlides" data-caption="{{ $captionText }}">
                                        <img src="{{ $isImageExists ? asset('storage/' . $profilePath) : asset($profilePath) }}" alt="{{ $captionText }}">
                                    </div>
                                @endif
                            @endforeach
                            <!-- Next/previous controls -->
                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>
                        </div>
                    </div>
                </div><br>
         
             </div>
 
             <div class="col-lg-8">
                <div class="card mb-4" style="margin-top: -20px;">
                                         <div class="row">
                           </div>
                                                  <div class="row">
                                                    </div>
			
                     
                   </div>
                                
                <div class="row" style="margin-top:-15px;">
                   <div class="col-md-6">
                   <h3 class="m-0 text-dark"><span class="fa fa-home"></span>Room</h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selected->room_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selected->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Check In</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->check_in}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Check Out</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->check_out}}</p>
                               </div>
                            </div>
                       </div>
                       
                      </div>
                      
                   </div>
		 <div class="col-md-6">

                  <h3 class="m-0 text-dark"><span class="fa fa-bed"></span> Bed </h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selectbed->bed_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $booking->selectbed->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0"> Bed Status</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">
                                     @if ($booking->selectbed->bed_status == 'occupied')
                                     <span class="badge bg-warning">{{ $booking->selectbed->bed_status }}</span>
                                 @elseif ($booking->selectbed->bed_status == 'available')
                                     <span class="badge bg-success">{{ $booking->selectbed->bed_status }}</span>
                                 @endif
                               </p>
                               </div>
                             </div>
                         </div>
                      </div>
                   </div>
                </div>
                @endforeach
             </div>    
          </div><br>
       </div>

     </x-app-layout>

