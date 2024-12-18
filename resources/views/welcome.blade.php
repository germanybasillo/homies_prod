<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
<title>{{ config('app.name') }}</title>
<meta name="description" content="">
<meta name="author" content="WebThemez">
<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
<link rel="stylesheet" href="landingpage/css/bootstrap.min.css" />
<link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
<link rel="stylesheet" type="text/css" href="landingpage/css/isotope.css" media="screen" />
<link rel="stylesheet" href="landingpage/js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<link href="landingpage/css/animate.css" rel="stylesheet" media="screen">
<!-- Owl Carousel Assets -->
<link href="landingpage/js/owl-carousel/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" href="landingpage/css/styles.css" />
<!-- Font Awesome -->
<link href="landingpage/font/css/font-awesome.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"  
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="  
crossorigin=""/>  
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"  
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="  
crossorigin=""></script>  
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />  
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script> 



<script>
  // Function to check if the browser is offline
  function checkInternetConnection() {
      if (!navigator.onLine) {
          // If no internet connection, show a message
          showNoInternetMessage();
      }
  }

  // Function to show a "No Internet" message using SweetAlert2
  function showNoInternetMessage() {
      Swal.fire({
          title: 'No Internet Connection',
          text: 'Please check your connection and reload the page.',
          icon: 'warning',
          confirmButtonText: 'Reload',
          allowOutsideClick: false, // Prevents closing by clicking outside
          allowEscapeKey: false // Prevents closing by using the escape key
      }).then((result) => {
          if (result.isConfirmed) {
              location.reload(); // Reload the page on confirmation
          }
      });
  }

  // Initial check on page load
  checkInternetConnection();

  // Listen for offline events
  window.addEventListener('offline', showNoInternetMessage);
</script>


</head>

<body>
<header class="header">
  <div class="container">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a href="/" class="navbar-brand scroll-top logo  animated bounceInLeft"><b><i><img src="/logo.png" style="height: 60px;"/></i></b></a> </div>
      <!--/.navbar-header-->
      <div id="main-nav" class="collapse navbar-collapse" style>
        <ul class="nav navbar-nav" id="mainNav">
          <li class="active" id="firstLink"><a href="#home" class="scroll-link">Home</a></li>
          <li><a href="#location" class="scroll-link">Location</a></li>
          <li><a href="#aboutUs" class="scroll-link">About Us</a></li>
          <li><a href="#work" class="scroll-link">Highlights Room</a></li>
          <li><a href="#toptenant" class="scroll-link">Top 5</a></li>
	  <li><a href="#team" class="scroll-link">Team</a></li>
         @if (auth()->user()->user_type === 'tenant' || auth()->user()->user_type === 'rental_owner')
	  <li><a href="#contactUs" class="scroll-link">Contact Us</a></li>
		@endif
		

          @if (Route::has('login'))
	  @auth

       @if (auth()->user()->user_type === 'admin')
    <li><a href="{{ route('contact.form') }}" class="scroll-link">Dashboard</a></li>
@elseif (auth()->user()->user_type === 'tenant')
    <li><a href="{{ url('/dashboard') }}" class="scroll-link">Dashboard</a></li>
@elseif (auth()->user()->user_type === 'rental_owner')
    @php
        $userStatus = auth()->user()->status;
    @endphp
    @if ($userStatus === 'pending')
        <li>
            <a href="#" id="dashboardLink" class="scroll-link">Dashboard</a>
        </li>
    @else
        <li>
            <a href="{{ url('/dashboard') }}" class="scroll-link">Dashboard</a>
        </li>
    @endif
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dashboardLink = document.getElementById('dashboardLink');
        
        if (dashboardLink) {
            dashboardLink.addEventListener('click', function (e) {
                e.preventDefault();
                
                Swal.fire(
                    'Account Pending',
                    'Your account is still pending. Please wait for approval.',
                    'warning'
                );
            });
        }
    });
</script>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="scroll-link">Logout</a></li>
    @else
        <li><a href="{{ route('login') }}" class="scroll-link">Login</a></li>
        @if (Route::has('register'))
            <li><a href="{{ route('register') }}" class="scroll-link">Register</a></li>
        @endif
    @endauth
    @endif    
    </ul>
      </div>
      <!--/.navbar-collapse--> 
    </nav>
    <!--/.navbar--> 
  </div>
  <!--/.container--> 
</header>
<!--/.header-->
<div id="#top"></div>
<section id="home">
  <div class="banner-container"> 
  	<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel" data-slide-to="0" class="active"></li>
    <li data-target="#carousel" data-slide-to="1"></li>
    <li data-target="#carousel" data-slide-to="2"></li>
  </ol>
  <!-- Carousel items -->
  @php
  // Fetch 3 random selected records
  $selecteds = App\Models\Selected::inRandomOrder()->take(3)->get();
  $images = []; // Initialize an empty array to collect images
@endphp

@foreach($selecteds as $selected)
  @php
      // Collect all profile images into the array
      $images = array_merge($images, [
          $selected->profile3,
          $selected->profile1,
          $selected->profile2,
          $selected->profile4,
          $selected->profile5,
          $selected->profile6
      ]);
  @endphp
@endforeach

@php
  // Remove any empty values from the array
  $images = array_filter($images);
  // Limit to a maximum of 3 images
  $images = array_slice($images, 0, 3);
@endphp

<div id="carousel" class="carousel slide" data-ride="carousel"> <!-- Adjust the value as needed -->
  <div class="carousel-inner">
      @if(empty($images))
        <p style="margin: 0; font-size: 30px; color: #333;">No Room Images available.</p> <!-- Message when no images are available -->
      @else
          @foreach($images as $key => $image)
              <div class="item {{ $key === 0 ? 'active' : '' }} fade">
                  <img src="{{ $image }}" alt="banner" style="width: 100%; height: 100%; object-fit: cover;"/>
              </div>
          @endforeach
      @endif
  </div>

  <!-- Carousel controls -->
  <a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
</div>

  <!-- Carousel controls -->
  <a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
</div>
	
  </div>  


@php
$hubrentals = \App\Models\Hubrental::where('user_id', Auth::id())->get();
$hubrentals = \App\Models\Hubrental::all();
$tenantprofiles = \App\Models\Tenantprofile::where('user_id', Auth::id())->get();
@endphp

  <div class="container hero-text2" id="location">
   @if (auth()->user()->user_type === 'rental_owner')
  <h3>Add Your Homies Location</h3>
  @else
<h3>Homies Location</h3>
@endif
  </div>

<style>
/* Custom style for the dropdown container */
.dropdown-container {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%; /* Make sure it takes full width for centering */
}

/* Styling for the dropdown itself */
#hubrental-select-dropdown {
    width: 80%; /* Adjust width of the dropdown */
    max-width: 420px; /* Set a max-width */
    padding: 6px 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    color: #333;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Add space below the dropdown */
    text-overflow: ellipsis; /* Add ellipsis when text overflows */
    white-space: nowrap; /* Prevent the text from wrapping */
    overflow: hidden; /* Hide any overflow text */
}

/* Style for options in the dropdown */
#hubrental-select-dropdown option {
    padding: 10px;
    text-overflow: ellipsis; /* Add ellipsis to long options */
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide any overflow text */
}

/* Style when the dropdown is focused */
#hubrental-select-dropdown:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style> 

<div class="dropdown-container">
    <!-- Dropdown for selecting hub rentals -->
    <select id="hubrental-select-dropdown" class="form-control">
        <option selected disabled>
            @if (auth()->user()->user_type === 'tenant')
                Select a rental hub
            @elseif (auth()->user()->user_type === 'rental_owner')
                Select your rental hub
            @elseif (auth()->user()->user_type === 'admin')
                List of rental hubs
            @endif
        </option>
        @foreach($hubrentals as $hubrental)
            @if($hubrental->status !== 'pending')
                <option value="{{ $hubrental->address }}">
                    {{ Str::limit($hubrental->name, 40) }} - {{ Str::limit($hubrental->address, 40) }}
                </option>
            @endif
        @endforeach
    </select>
</div>

</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<!-- Leaflet Search CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
<!-- Leaflet Search JS -->
<script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
<section class="page-section colord" id="mapid" style="height:450px;">

<script>

// Initialize the map
var map = L.map('mapid').setView([51.505, -0.09], 13); // Default center

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Feature group to store markers
var markersLayer = L.featureGroup().addTo(map);

// Array to store rental hubs
var rentalHubs = [];

// Add markers and populate rental hubs array
@foreach($hubrentals as $hubrental)
    @if($hubrental->status !== 'pending')
        var marker = L.marker([{{ $hubrental->lat }}, {{ $hubrental->lng }}]).addTo(markersLayer)
            .bindPopup(`
                <b>Owner Name: {{ $hubrental->name }}</b><br>
                {{ $hubrental->address }}<br>
                Type: {{ $hubrental->type }}<br>
                Price: P{{ number_format($hubrental->price, 2) }}<br>
                @auth
                    @if (auth()->user()->user_type === 'rental_owner' && auth()->user()->id === $hubrental->user_id)
                        <a href="{{route('hubrentals.show',$hubrental->id)}}" class="btn btn-primary">Edit Location</a>
                        <a href="/selecteds/create" class="btn btn-primary">Add Room</a>
                        <a href="/selecteds" class="btn btn-primary">View RM</a>
                    @elseif (auth()->user()->user_type === 'tenant')
                        @if($tenantprofiles->isEmpty())
                            <a href="/tenantprofiles" class="btn btn-primary">Book Now?</a>
                        @else
                            <a href="/booking-messages/create" class="btn btn-primary">Book Now?</a>
                        @endif
                    @endif
                @endauth
            `);

        rentalHubs.push({
            address: "{{ $hubrental->address }}",
            latlng: [{{ $hubrental->lat }}, {{ $hubrental->lng }}],
            marker: marker
        });
    @endif
@endforeach

// Handle dropdown change event
document.getElementById('hubrental-select-dropdown').addEventListener('change', function (event) {
    var selectedAddress = event.target.value;

    // Find the corresponding marker
    var selectedHub = rentalHubs.find(hub => hub.address === selectedAddress);

    if (selectedHub) {
        map.setView(selectedHub.latlng, 13); // Center the map
        selectedHub.marker.openPopup(); // Open popup
    }
});

// Geolocation function
function getGeolocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;

            map.setView([userLat, userLng], 13);

            @if (auth()->user()->user_type === 'rental_owner')
                L.marker([userLat, userLng]).addTo(map)
                    .bindPopup(`
                        Add Your Rental Space<br>
                        @if ($userStatus === 'pending')
                            <a href="#" id="pending" class="btn btn-primary" style="height:33px;">Add</a>
                        @else
                            <a href="{{route('hubrentals.create')}}" class="btn btn-primary" style="height:33px;">Add</a>
                        @endif
                    `)
                    .openPopup();
            @elseif (auth()->user()->user_type === 'tenant')
                L.marker([userLat, userLng]).addTo(map)
                    .bindPopup(`You are Here!`)
                    .openPopup();
            @endif
        }, function (error) {
            console.error("Geolocation error:", error.message);
            alert("Could not get your location. Using default location.");
        });
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}

// Center map on user's location
getGeolocation();

</script>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pending = document.getElementById('pending');
        
        if (pending) {
            pending.addEventListener('click', function (e) {
                e.preventDefault();
                
                Swal.fire(
                    'Account Pending',
                    'Your account is still pending. Please wait for approval.',
                    'warning'
                );
            });
        }
    });
</script>

<section id="aboutUs">
  <div class="container">
    <div class="heading text-center"> 
      <!-- Heading -->
      <h2>About Us</h2>
      <p>"At Homies, we are dedicated to delivering exceptional experiences. Our journey has been shaped by passion, innovation, and a commitment to excellence. With a focus on quality and customer satisfaction, we continuously strive to meet and exceed expectations."</p>
    </div>
    <div class="row feature design">
      <div class="area1 columns right">
        <h3>Clean and Modern Design.</h3>
        <p>"Our spaces are thoughtfully designed with a modern aesthetic and a focus on simplicity and functionality. Each room features clean lines, minimalist decor, and high-quality materials to create a fresh, inviting atmosphere.  </p>
        <p>Whether you're looking for comfort or style, our design delivers both, ensuring a space that feels both contemporary and timeless."</p>
      </div>
      @php
  // Fetch 3 random selected records
  $selecteds = App\Models\Selected::inRandomOrder()->take(1)->get();
  $images = []; // Initialize an empty array to collect images
@endphp

@foreach($selecteds as $selected)
  @php
      // Collect all profile images into the array
      $images = array_merge($images, [
          $selected->profile4,
          $selected->profile1,
          $selected->profile2,
          $selected->profile5,
          $selected->profile6,
          $selected->profile3,
      ]);
  @endphp
@endforeach

@php
  // Remove any empty values from the array
  $images = array_filter($images);
  // Limit to a maximum of 3 images
  $images = array_slice($images, 0, 1);
@endphp
@if(empty($images))
<div class="col-md-12 text-center">
  <p style="color:greenyellow;font-size:20px;">No images room available</p>
</div>
@else
@foreach($images as $image)
    <div class="area2 columns feature-media left">
        <img src="{{ $image }}" alt="" width="100%">
    </div>
@endforeach
@endif

    </div>
    <div class="row dataTxt">	
						<div class="col-md-4 col-sm-6">
							<h4>What We Do?</h4>
							<p>"At Homies, we specialize in creating comfortable, stylish living spaces that cater to your needs. From providing modern, well-designed rooms to offering a seamless rental experience, we are dedicated to making your stay feel like home.  </p>
                            <p>Our team works hard to ensure every detail is perfect, delivering exceptional service and a welcoming environment."</p>
							<br>
						</div>
						
						<div class="col-md-4 col-sm-6">
							
							<h4>Why Choose Us?</h4>
							<p>"At Homies, we prioritize your comfort, convenience, and satisfaction. </p>
                            <ul class="listArrow">
								<li>With modern designs,</li>
								<li>high-quality amenities,</li>
								<li>and exceptional customer service,</li>
								<li>we create spaces that truly feel like home.</li>
								<li>Our commitment to excellence and attention to detail ensure a seamless experience from start to finish, making us the perfect choice for your living needs."</li>
							</ul>
							<!-- Accordion starts -->
							</div>
              @php
              // Fetch 3 random selected records
              $selecteds = App\Models\Selected::inRandomOrder()->take(1)->get();
              $images = []; // Initialize an empty array to collect images
            @endphp
            
            @foreach($selecteds as $selected)
              @php
                  // Collect all profile images into the array
                  $images = array_merge($images, [
                      $selected->profile5,
                      $selected->profile6,
                      $selected->profile2,
                      $selected->profile4,
                      $selected->profile1,
                      $selected->profile3,
                  ]);
              @endphp
            @endforeach
            
            @php
            // Remove any empty values from the array
            $images = array_filter($images);
            // Limit to a maximum of 1 image
            $images = array_slice($images, 0, 1);
         @endphp
        
        @if(empty($images))
            <div class="col-md-12 text-center">
                <p style="color:greenyellow;font-size:20px;">No images room available</p>
            </div>
        @else
            @foreach($images as $image)
                <div class="col-md-4 col-sm-6">
                    <img src="{{ $image }}" alt="" width="100%">
                </div>
            @endforeach
        @endif
					</div>
  </div>
</section> 
<section id="work" class="page-section page">
  <div class="container text-center">
    <div class="heading">
      <h2>8 Highlights Room Images</h2>
      <p>"Experience unmatched comfort with a cozy atmosphere and modern decor. This room features a spacious layout, natural lighting, and elegant furnishings, perfect for relaxation and productivity."</p>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="portfolio">
          @php
       // Fetch all selected records and randomly select 8
      $selecteds = App\Models\Selected::inRandomOrder()->take(8)->get();
      @endphp
  <div class="items-container">
  <ul class="items list-unstyled clearfix animated fadeInRight showing" data-animation="fadeInRight">
      @if($selecteds->isEmpty())
          <li class="item branding" style="width: 100%; text-align: center;background-color:greenyellow;">
              <p>No Image Room available.</p> <!-- Message when no items are available -->
          </li>
      @else
      @php
      $images = []; // Initialize an empty array to collect images
  @endphp
  
  @foreach($selecteds as $selected)
      @php
          // Collect all profile images into the array
          $images = array_merge($images, [
              $selected->profile1,
              $selected->profile2,
              $selected->profile3,
              $selected->profile4,
              $selected->profile5,
              $selected->profile6
          ]);
      @endphp
  @endforeach
  
  @php
      // Remove any empty values from the array
      $images = array_filter($images);
      // Limit to a maximum of 8 images
      $images = array_slice($images, 0, 8);
  @endphp
  
  @foreach($images as $image)
      <li class="item branding" style="display: inline-block; width: 25%; box-sizing: border-box; padding: 0;">
          <figure class="effect-bubba" style="margin: 0;">
              <img src="{{ $image }}" alt="Image" style="width: 100%; height: 200px; object-fit: cover;"/>
              <figcaption>
                  <h2>Trends</h2>
                  <a href="{{ $image }}" class="fancybox">View more</a>
              </figcaption>
          </figure>
          </li>
       @endforeach
     @endif
     </ul>
      </div>

        </div>
      </div>
    </div>
  </div>
</section>
<section id="toptenant" class="page-section">
  <div class="container">
    <div class="heading text-center"> 
      <!-- Heading -->
      <h2>The Top 5 Tenant Visitors And Booking</h2>
      <p>Register now  and get access to our top 5 visitors.</p>
      <p>Book now and get access to our top 5 bookings.</p>
    </div>
    <div class="row flat">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      </div>
 @php
    $tenants = App\Models\User::where('user_type', 'tenant')
        ->orderBy('login_count', 'desc') // Sort by login_count in descending order
        ->take(5) // Limit to top 5 tenants
	->get(); // Get top 5 tenants
	$registeredCount = \App\Models\User::count(); // Count all registered users
@endphp
		
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <ul class="plan plan2 featured">

@if (!auth()->check() && $registeredCount < 5)
    <li class="plan-name"><a href="{{ route('register') }}">Register?</a></li>
@elseif (auth()->check())
    @if (auth()->user()->user_type === 'tenant')
        <li class="plan-name">Top Name List</li>
    @elseif(auth()->user()->user_type === 'rental_owner')
        <li class="plan-name">Top Name List</li>
    @else
        <li class="plan-name">Top Name List</li>
    @endif
@else
    @guest
        <li class="plan-name">Top Name List</li>
    @endguest
    @endif


        @if ($tenants->isEmpty())
            <li class="plan-price">No tenants registered yet.</li>
        @else
            @foreach ($tenants as $index => $tenant)
                <li class="plan-price">{{ $index + 1 }}. <strong>{{ $tenant->name }}</strong></li>
                {{-- ({{ $tenant->login_count }}) --}}
            @endforeach
        @endif
        </li>
      </ul>
</div>


@php
$bookingmessages = \App\Models\BookingMessage::selectRaw('sender_id, COUNT(*) as count')
    ->groupBy('sender_id')
    ->orderBy('count', 'desc')
    ->take(5)
    ->get();
@endphp

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <ul class="plan plan2 featured">
        <li class="plan-name">Top Book List</li>
        <!-- Show booking list for all user types (tenant, rental_owner, admin) -->
        @if ($bookingmessages->isEmpty())
            <li class="plan-price">No Booking yet.</li>
        @else
            @foreach ($bookingmessages as $index => $bookingmessage)
                <li class="plan-price">
                    {{ $index + 1 }}. 
                    <strong>{{ $bookingmessage->sender->name }}</strong> ({{ $bookingmessage->count }} bookings)
                </li>
            @endforeach
        @endif
    </ul>
</div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      </div>
    </div>
  </div>
</section>
<section id="team" class="page-section">
  <div class="container">
    <div class="heading text-center"> 
      <!-- Heading -->
      <h2>Team</h2>
      <p>Driven by passion and dedication, our team is here to make a difference in every project we undertake.</p>
    </div>
    <!-- Team Member's Details -->
    <div class="team-content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12"> 
          <!-- Team Member -->
          <div class="team-member pDark"> 
            <!-- Image Hover Block -->
            <div class="member-img"> 
              <!-- Image  --> 
              <img class="img-responsive" src="8.jpg" alt=""  style="height:150px;width:200px"> </div>
            <!-- Member Details -->
            <div class="team-title">
		      	<h4>Mr. Ebrahim Diangca</h4>
            <!-- Designation --> 
            <span class="pos">Our Teacher Adviser</span>
			    </div>
            <div class="team-socials"> <a href="https://www.facebook.com/Miharbe.diangca" target="_blank"><i class="fa fa-facebook"></i><a href="https://github.com/ediangca" target="_blank"><i class="fa fa-github"></i></a> </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12"> 
          <!-- Team Member -->
          <div class="team-member pDark"> 
            <!-- Image Hover Block -->
            <div class="member-img"> 
              <!-- Image  --> 
              <img class="img-responsive" src="9.jpg" alt="" style="height:150px;width:200px"> </div>
            <!-- Member Details -->
            <h4>Germany Lungay</h4>
            <!-- Designation --> 
            <span class="pos">The Programmer / Designer</span>
            <div class="team-socials"> <a href="https://github.com/germanybasillo" target="_blank"><i class="fa fa-github"></i></a></div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12"> 
          <!-- Team Member -->
          <div class="team-member pDark"> 
            <!-- Image Hover Block -->
            <div class="member-img"> 
              <!-- Image  --> 
              <img class="img-responsive" src="11.jpg" alt=""  style="height:150px;width:200px"> </div>
            <!-- Member Details -->
            <h4>Esteve Mark Salamanca Caya</h4>
            <!-- Designation --> 
            <span class="pos">The System Analys</span>
            <div class="team-socials"> <a href="https://www.facebook.com/princejoao.caya" target="_blank"><i class="fa fa-facebook"></i></a></div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12"> 
          <!-- Team Member -->
          <div class="team-member pDark"> 
            <!-- Image Hover Block -->
            <div class="member-img"> 
              <!-- Image  --> 
              <img class="img-responsive" src="10.jpg" alt=""  style="height:150px;width:200px"> </div>
            <!-- Member Details -->
            <h4>Hartjade Franz Gallego </h4>
            <!-- Designation --> 
            <span class="pos">The Documentator</span>
            <div class="team-socials"> <a href="https://www.facebook.com/hartjadefranz.gallego" target="_blank"><i class="fa fa-facebook"></i></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/.container--> 
</section>

@if (auth()->user()->user_type === 'tenant' || auth()->user()->user_type === 'rental_owner')

<section id="contactUs" class="contact-parlex">
  <div class="parlex-back">
    <div class="container">
      <div class="row">
        <div class="heading text-center"> 
          <!-- Heading -->
          <h2>Contact Us</h2>
          <p>"We’re here to help! Reach out to us with any questions, and our team will be happy to assist you. Whether you need more information or have specific requests, feel free to get in touch."</p>
        </div>
      </div>
      <div class="row mrgn30">


        <form method="post" action="{{ route('contact.submit') }}" id="contactfrm" role="form" novalidate>
          @csrf
          <div class="col-sm-12">
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name ?? null }}"   {{ Auth::check() ? 'readonly' : '' }}  required minlength="2" placeholder="Enter name" title="Please enter your name (at least 2 characters)">
              </div>
              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email ?? null }}"   {{ Auth::check() ? 'readonly' : '' }}  required  placeholder="Enter Email" title="Please enter a valid email address">
              </div>
              <div class="form-group">
                  <label for="comments">Comments</label>
                  <textarea name="comment" class="form-control" id="comments" cols="3" rows="5" placeholder="Enter your message…" required minlength="10" title="Please enter your message (at least 10 characters)" required></textarea>
              </div>
              <button name="submit" type="submit" class="btn btn-lg btn-primary">Submit</button>
              <div class="result mt-3"></div>
          </div>
      </form>


<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Listen for the form submission
    document.getElementById('contactfrm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        const userId = {{ Auth::check() ? Auth::id() : 'null' }}; 

        // Check if the user is logged in
        if (!userId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'You need to be logged in to submit the form.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Check the last submission time for the specific user in localStorage
        const lastSubmissionTime = localStorage.getItem('lastSubmissionTime_' + userId);
        const currentTime = new Date().getTime();

        // If the last submission was within the last 24 hours
        if (lastSubmissionTime && (currentTime - lastSubmissionTime < 24 * 60 * 60 * 1000)) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'You can only submit the form once every 24 hours.',
                confirmButtonText: 'OK'
            });
            return; // Stop the form from submitting
        }

        // Create a FormData object to handle the form data
        var formData = new FormData(this);

        // Use AJAX to submit the form
        fetch("{{ route('contact.submit') }}", {
            method: "POST",
            body: formData
        })
        .then(response => response.json()) // Assuming your controller returns JSON
        .then(data => {
            if (data.success) {
                // Show SweetAlert2 on success
                Swal.fire({
                    icon: 'success',
                    title: 'Thank you!',
                    text: data.message || 'Your message has been successfully submitted. Wait for the admin to contact you!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Save the current time in localStorage to prevent another submission in the next 24 hours
                    localStorage.setItem('lastSubmissionTime_' + userId, currentTime);
                    // Optionally, reset the form
                    document.getElementById('contactfrm').reset();
                });
            } else {
                // Show error message if not successful
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message || 'Something went wrong, please try again.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while sending your message.',
                confirmButtonText: 'OK'
            });
        });
    });
</script>









    </div>
    </div>
    <!--/.container--> 
  </div>
</section>
@endif
<!--/.page-section-->
<section class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center" id="copyright"></div>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          const year = new Date().getFullYear();
          document.getElementById('copyright').innerHTML = `Copyright ${year} | All Rights Reserved -- Homies - Capstone2`;
        });
      </script>
    </div>
    <!-- / .row --> 
  </div>
</section>
<a href="#top" class="topHome"><i class="fa fa-chevron-up fa-2x"></i></a> 

<!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]--> 
<script src="landingpage/js/modernizr-latest.js"></script> 
<script src="landingpage/js/jquery-1.8.2.min.js" type="text/javascript"></script> 
<script src="landingpage/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="landingpage/js/jquery.isotope.min.js" type="text/javascript"></script> 
<script src="landingpage/js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script> 
<script src="landingpage/js/jquery.nav.js" type="text/javascript"></script> 
<script src="landingpage/js/jquery.fittext.js"></script> 
<script src="landingpage/js/waypoints.js"></script> 
<script src="landingpage/js/custom.js" type="text/javascript"></script> 
<script src="landingpage/js/owl-carousel/owl.carousel.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      @if (session('swal:register'))
          Swal.fire({
              icon: 'success',
              title: 'Success',
              text: '{{ session('swal:register') }}',
          });
      @elseif (session('swal:login'))
          Swal.fire({
              icon: 'success',
              title: 'Success',
              text: '{{ session('swal:login') }}',
          });
      @endif
  });
  </script>

<script>
  // Function to check if the browser is offline
  function checkInternetConnection() {
      if (!navigator.onLine) {
          // If no internet connection, show a message
          showNoInternetMessage();
      }
  }

  // Function to show a "No Internet" message using SweetAlert2
  function showNoInternetMessage() {
      Swal.fire({
          title: 'No Internet Connection',
          text: 'Please check your connection and reload the page.',
          icon: 'warning',
          confirmButtonText: 'Reload',
          allowOutsideClick: false, // Prevents closing by clicking outside
          allowEscapeKey: false // Prevents closing by using the escape key
      }).then((result) => {
          if (result.isConfirmed) {
              location.reload(); // Reload the page on confirmation
          }
      });
  }

  // Initial check on page load
  checkInternetConnection();

  // Listen for offline events
  window.addEventListener('offline', showNoInternetMessage);
</script>

</body>
</html>
