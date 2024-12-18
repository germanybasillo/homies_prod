<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark"> Update Outlet</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Hub Rental</li>
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
              <form role="form" id="quickForm" action="{{ route('hubrentals.update', $hubrental->id ) }}" method="POST" enctype="multipart/form-data">
	      @csrf
	      @method('PUT')
                <div class="card-body">
		  <div class="row">

                  <div class="col-md-8 offset-md-2" style="display:none;">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div></div>

              
  <div class="col-md-8 offset-md-2">
                <div class="form-group">
                    <label>Address</label>
                    <input id="address" class="form-control" name="address" placeholder="Address Please" value="{{$hubrental->address }}" readonly>
                    @if ($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                </div>
            </div>


                  <div class="col-md-8 offset-md-2">
                    <div class="form-group">
                      <label>Type</label>
                      <input class="form-control" name="type" placeholder="Type of your rental space" value="{{$hubrental->type }}">
                      @if ($errors->has('type'))
                      <span class="text-danger" style="color: red">{{ $errors->first('type') }}</span>
                      @endif 
		    </div></div>

                 <div class="col-md-8 offset-md-2">
                <div class="form-group">
                    <label>Latitude</label>
                    <input id="latitude" type="text" name="lat" class="form-control" value="{{$hubrental->lat}}" readonly>
                </div>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="form-group">
                    <label>Longitude</label>
                    <input id="longitude" type="text" name="lng" class="form-control" value="{{$hubrental->lng }}" readonly>
                </div>
	    </div>

                 <div class="col-md-8 offset-md-2">
                  <div class="form-group">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" value="{{$hubrental->price}}">
	         @if ($errors->has('price'))
                      <span class="text-danger" style="color: red">{{ $errors->first('price') }}</span>
                      @endif
               </div></div>

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
    // Listen for form submission
    document.getElementById('quickForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent immediate submission

        Swal.fire({
            icon: null, // Disable default icon
            html: '<img src="{{ asset('logo.png') }}" alt="Logo" width="50" height="46"><br><h2>Are you sure?</h2>Do you want to update this hubrental?',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                event.target.submit();
            }
        });
    });

    // Display error message if validation fails
    @if ($errors->any())
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
    }).then(() => {
        // Optionally, you can add a redirection here if needed after showing errors
        // For now, the user stays on the same page for error corrections
    });
    @endif

    // Display success message if successful
    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
    }).then(() => {
        // Redirect to the home page after showing success message
        window.location.href = '/'; // Redirect to the home page or desired route
    });
    @endif
</script>


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<div id="mapid" style="height: 500px;"></div>

<script>
    // Default map settings based on the passed initial data
    var defaultLatitude = {{ $hubrental->lat }};
    var defaultLongitude = {{ $hubrental->lng }};
    var defaultAddress = "{{ $hubrental->address }}";
    var mapZoomLevel = {{ config('leaflet.zoom_level', 13) }};

    // Initialize the map
    var map = L.map('mapid').setView([defaultLatitude, defaultLongitude], mapZoomLevel);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add a draggable marker at the default location
    var marker = L.marker([defaultLatitude, defaultLongitude], {
        draggable: true
    }).addTo(map).bindPopup("Your location: " + defaultAddress);

    // Function to update marker position and form inputs
    function updateMarker(lat, lng, address = '') {
        marker
            .setLatLng([lat, lng])
            .bindPopup("Move location: " + address)
            .openPopup();

        // Update form fields with new values
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('address').value = address;
    }

    // Handle map click to reposition marker
    map.on('click', function(e) {
        var latitude = e.latlng.lat.toFixed(6);
        var longitude = e.latlng.lng.toFixed(6);

        // Reverse geocode to get address
        var geocoder = L.Control.Geocoder.nominatim();
        geocoder.reverse(e.latlng, mapZoomLevel, function(results) {
            var address = results[0]?.name || "Unknown location";
            updateMarker(latitude, longitude, address);
        });
    });

    // Update marker when dragging ends
    marker.on('dragend', function(e) {
        var position = e.target.getLatLng();
        var latitude = position.lat.toFixed(6);
        var longitude = position.lng.toFixed(6);

        // Reverse geocode to get address
        var geocoder = L.Control.Geocoder.nominatim();
        geocoder.reverse(position, mapZoomLevel, function(results) {
            var address = results[0]?.name || "Unknown location";
            updateMarker(latitude, longitude, address);
        });
    });

    // Add search functionality
    var geocoderControl = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var lat = e.geocode.center.lat.toFixed(6);
        var lng = e.geocode.center.lng.toFixed(6);
        var address = e.geocode.name; // Address from geocoder result

        // Center map, update marker, and populate form fields
        map.setView([lat, lng], mapZoomLevel);
        updateMarker(lat, lng, address);
    }).addTo(map);
</script>

  </x-app-layout>
