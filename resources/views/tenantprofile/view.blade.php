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
               <h1 class="m-0 text-dark"><span class="fa fa-user"></span> Your Profile</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                 </ol> 
              </div>
           </div>
        </div>
    </x-slot>
 
          <div class="row">
             <div class="col-lg-4">
                <div class="card mb-4" style="margin-top: -20px;">
                          <div class="card-body text-center" style="height:316px;">
                         <!-- Profile Image -->
                     
			@if($user)

    			<div id="setting" data-id="{{ $user->first()->id }}" data-action="0" class="profile-image"
       			 style="background-image: url('{{ Chatify::getUserWithAvatar(auth()->user())->avatar }}');cursor:pointer;">    			</div>
			@endif


<script>
document.getElementById('setting').addEventListener('click', function() {
    // Open SweetAlert2 modal for avatar update
    Swal.fire({
        title: 'Update Your Avatar',
        html: `
            <div class="profile-image" id="avatar-preview" 
                 style="background-image: url('{{ Chatify::getUserWithAvatar(auth()->user())->avatar }}');"></div>
            <p class="upload-avatar-details">Current Avatar</p>
            <label class="app-btn a-btn-primary update" style="display: block;">
                Upload New
                <input class="upload-avatar chatify-d-none" accept="image/*" name="avatar" type="file" id="avatar-input" />
            </label>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const fileInput = document.getElementById('avatar-input');
            const file = fileInput.files[0];

            if (file) {
                const formData = new FormData();
                formData.append('avatar', file);

                // Send the form data to update the avatar (using Fetch API)
                fetch('{{ route('avatar.update') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(() => {
                    // Once the request is successful, simply reload the page
                    location.reload(); // Reload the page after the avatar update
                })
                .catch(() => {
                    // Handle network errors, but no need to show any error messages
                    location.reload(); // Refresh page even on error (if you prefer no feedback)
                });
            } else {
                // If no file is selected, simply close the modal without doing anything
                Swal.fire('Cancelled', 'No changes made.', 'info');
            }
        }
    });

    // Handle file input change to update the avatar preview before submitting
    document.getElementById('avatar-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Create a new URL for the selected image
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update the avatar preview with the selected image
                document.getElementById('avatar-preview').style.backgroundImage = `url(${e.target.result})`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>               
			

                
 
			<h5>Tenant</h5> 

	@foreach ($tenantprofiles as $tenantprofile) 
                         <div class="container">
                            <div class="row justify-content-center mb-2">
                                <div class="col-auto">
                                  <a class="btn btn-primary mx-1" href="#" id="editButton" 
                                  data-id="{{ $tenantprofile->id }}" 
                                  data-name="{{ $tenantprofile->name }}"
                                  data-address="{{ $tenantprofile->address }}"
                                  data-email="{{ $tenantprofile->email }}"
                                  data-contact="{{ $tenantprofile->contact }}"
                                  data-gender="{{ $tenantprofile->gender }}">
                                <i class="fa fa-user-edit"></i> Edit
                                  </a>
				</div>                  
                            </div>
                        </div>
                      @endforeach
                   </div>
                </div>
       
                @foreach($rooms as $room)
                <div class="container" style="margin-top:-15px;">
                    <h3 class="m-0 text-dark">
                        <span class="fa fa-home"></span> Room Picture :
                        <p id="caption-text" style="margin-top: -33px;margin-left:230px;"></p></h3>
                    <div class="card-body" style="margin-top:-30px;" data-id="{{ $room->selected->id }}">
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
                                    $profilePath = $room->selected->{$profile['profile']};
                                    $captionText = $room->selected->{$profile['caption']};
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
            @endforeach
             </div>
 
             <div class="col-lg-8">
                <div class="card mb-4" style="margin-top: -20px;">
                   <div class="card-body">
                         <div class="row">
                            <div class="col-sm-3">
                               <p class="mb-0">Name</p>
                            </div>
                            <div class="col-sm-9">
                               <p class="text-muted mb-0">{{ auth()->user()->name }}</p>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-sm-3">
                               <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                               <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                         </div>
			 <hr>
                      @if ($tenantprofiles->isEmpty())
		      <div class="col-auto">
                                    <a class="btn btn-primary mx-1" href="#" id="addNewButton">
                                        <i class="fa fa-user"></i> Add Your Information first!
                                     </a> 
                                </div> 
                         @endif

                      @foreach($tenantprofiles as $tenantprofile)
                         <div class="row">
                            <div class="col-sm-3">
                               <p class="mb-0">Mobile</p>
                            </div>
                            <div class="col-sm-9">
                               <p class="text-muted mb-0">{{ $tenantprofile->contact }}</p>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-sm-3">
                               <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-9">
                               <p class="text-muted mb-0">{{ $tenantprofile->address }}</p>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-sm-3">
                               <p class="mb-0">Gender</p>
                            </div>
                            <div class="col-sm-9">
                               <p class="text-muted mb-0">{{ $tenantprofile->gender }}</p>
                            </div>
                         </div>
                      @endforeach
                   </div>
                </div>
                @if (!$tenantprofiles->isEmpty())
                <div class="row" style="margin-top:-15px;">
                   <div class="col-md-6">
                      @foreach($rooms as $room) 
                      <h3 class="m-0 text-dark"><span class="fa fa-home"></span>Room</h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $room->selected->room_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Room Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $room->selected->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Start Date</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $room->start_date}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Due Date</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $room->due_date}}</p>
                               </div>
                            </div>
                         @endforeach
                         </div>
                         @endif
                      </div>
                      
                   </div>
                   @if (!$rooms->isEmpty())
                   <div class="col-md-6">
                      @foreach($beds as $bed)
                      <h3 class="m-0 text-dark"><span class="fa fa-bed"></span> Bed </h3>
                      <div class="card mb-4 mb-md-0" style="margin-top:5px;">
                         <div class="card-body">
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed No</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $bed->selectbed->bed_no}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0">Bed Description</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $bed->selectbed->description}}</p>
                               </div>
                            </div>
                            <hr>
                            <div class="row">
                               <div class="col-sm-3">
                                  <p class="mb-0"> Bed Status</p>
                               </div>
                               <div class="col-sm-9">
                                  <p class="text-muted mb-0">
                                     @if ($bed->selectbed->bed_status == 'occupied')
                                     <span class="badge bg-warning">{{ $bed->selectbed->bed_status }}</span>
                                 @elseif ($bed->selectbed->bed_status == 'available')
                                     <span class="badge bg-success">{{ $bed->selectbed->bed_status }}</span>
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
             @endif
          </div><br>
       </div>

       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif


    {{-- ================================================================================================= tenantprofile add modal =============================================================================== --}}

<script>
document.getElementById('addNewButton').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent default link behavior
  
  Swal.fire({
    title: 'Edit Profile',
    html: `
      <style>
        #quickForm .form-group {
          margin-bottom: 15px; /* Add spacing between form groups */
        }
        #quickForm label {
          font-weight: bold;
          margin-bottom: 5px;
        }
        #quickForm .form-control {
          width: 100%;
          padding: 10px;
          border-radius: 5px;
          border: 1px solid #ccc;
        }
        #quickForm select.form-control {
          height: 42px;
        }
        .swal2-container {
          z-index: 1050; /* Ensure the modal is on top */
        }
        .card-body {
          padding: 20px;
          max-width: 500px;
          margin: 0 auto;
        }
      </style>
      <form id="quickForm">
        @csrf
        <div class="card-body">
          <div class="form-group" style="display:none;">
            <label>First Name</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input class="form-control" name="address" placeholder="ex. Manggahan, Pasig City, Manila">
            <span class="text-danger" id="error-address"></span>
          </div>
          <div class="form-group" style="display:none;">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
          </div>
          <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" placeholder="ex. 09654645341">
            <span class="text-danger" id="error-contact"></span>
          </div>
          <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender">
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
       </div>
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Submit',
    cancelButtonText: 'Cancel',
    preConfirm: () => {
      const formData = new FormData(document.getElementById('quickForm'));
      
      return fetch('{{ route('tenantprofile.store') }}', {
        method: 'POST',
        body: formData,
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(errors => {
            Swal.showValidationMessage(
              Object.values(errors.errors).flat().join('<br>')
            );
            throw new Error('Validation errors');
          });
        }
        return response.json();
      })
      .then(data => {
        Swal.fire(
          'Success!',
          'Tenant profile added successfully!',
          'success'
        ).then(() => {
          location.reload(); // Reload the page to reflect changes
        });
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  });
});

    </script>

{{-- ================================================================================================= tenantprofile edit modal =============================================================================== --}}

<script>
document.getElementById('editButton').addEventListener('click', function(event) {
    event.preventDefault();

    // Get tenant profile data from the button's data attributes
    const tenantId = this.getAttribute('data-id');
    const name = this.getAttribute('data-name');
    const address = this.getAttribute('data-address');
    const email = this.getAttribute('data-email');
    const contact = this.getAttribute('data-contact');
    const gender = this.getAttribute('data-gender');

    Swal.fire({
        title: 'Update Profile',
        html: `
            <style>
                #quickForm .form-group {
                    margin-bottom: 15px;
                }
                #quickForm label {
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                #quickForm .form-control {
                    width: 100%;
                    padding: 10px;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                }
                #quickForm select.form-control {
                    height: 42px;
                }
                .swal2-container {
                    z-index: 1050;
                }
                .card-body {
                    padding: 20px;
                    max-width: 500px;
                    margin: 0 auto;
                }
            </style>
            <form id="quickForm">
                <div class="card-body">
                    <div class="form-group" style="display:none;">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="${name}" placeholder="Name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="${address}" placeholder="Address">
                        <span class="text-danger" id="error-address"></span>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="${email}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" value="${contact}" placeholder="Contact">
                        <span class="text-danger" id="error-contact"></span>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="male" ${gender === 'male' ? 'selected' : ''}>Male</option>
                            <option value="female" ${gender === 'female' ? 'selected' : ''}>Female</option>
                        </select>
                    </div>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const formData = new FormData(document.getElementById('quickForm'));

            // Collect the updated values
            const updatedData = {
                name: formData.get('name'),
                address: formData.get('address'),
                contact: formData.get('contact'),
                gender: formData.get('gender'),
            };

            // Check if any data has changed
            const hasChanges = (
                updatedData.name !== name ||
                updatedData.address !== address ||
                updatedData.contact !== contact ||
                updatedData.gender !== gender
            );

            if (!hasChanges) {
                Swal.showValidationMessage('You haven\'t made any changes.');
                return false; // Prevent form submission
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken); // Append the CSRF token
            formData.append('_method', 'PUT'); // Use PUT method for update

            return fetch(`{{ route('tenantprofiles.update', ':id') }}`.replace(':id', tenantId), {
                method: 'POST', // Use POST but override with PUT using _method field
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errors => {
                        Swal.showValidationMessage(
                            Object.values(errors.errors).flat().join('<br>')
                        );
                        throw new Error('Validation errors');
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire('Success!', 'Profile updated successfully!', 'success')
                    .then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});

// Function to check if the file exists in the given path
function fileExists(url) {
    const xhr = new XMLHttpRequest();
    xhr.open('HEAD', url, false);
    xhr.send();
    return xhr.status !== 404;
}

</script>
{{-- ================================================================================================= add room modal =============================================================================== --}}

 </x-app-layout>
 
 
