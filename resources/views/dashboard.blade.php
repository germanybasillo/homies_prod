<x-app-layout>
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"  
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="  
  crossorigin=""/>  
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"  
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="  
  crossorigin=""></script>  
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />  
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>  

      <x-slot name="header">
          <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    
                    @if (auth()->user()->user_type === 'tenant')
                    <h1 class="m-0 text-dark">Tenant Dashboard</h1>
                    @elseif (auth()->user()->user_type === 'rental_owner')
                    <h1 class="m-0 text-dark">Rental_Owner Dashboard</h1>
                    @endif

                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
      </x-slot>

      <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            @if (auth()->user()->user_type === 'tenant')
                        <div class="col-lg-6 col-12">
              <!-- small box -->
              <div class="small-box bg-success">
		<div class="inner">
            <h3>Php {{ number_format($paymentmessages->sum('total'), 2) }}<sup style="font-size: 20px"></sup></h3>                  <p>Payment History</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
		<a href="#" class="small-box-footer payment-history">More info <i class="fas fa-arrow-circle-right"></i></a>
	
<script>
    $(document).ready(function () {
        // When the link is clicked
        $('.payment-history').on('click', function (e) {
            e.preventDefault();

            // Show the SweetAlert2 modal
            Swal.fire({
                title: 'Payment Info',
                html: '<table id="tenant-table" class="table table-bordered table-hover" style="width: 100%; text-align: center;">' +
                        '<thead class="btn-cancel">' +
                            '<tr>' +
                                '<th>Tenant Name</th>' +
				'<th>Billing</th>' +
                                 '<th>Refference Id</th>' +
                            '</tr>' +
                        '</thead>' +
			'<tbody>' +
				
                            '@foreach($paymentmessages as $paymentmessage)' +
                                '<tr>' +
                                    '<td>{{ $paymentmessage->sender->name }}</td>' +
				    '<td>{{ $paymentmessage->total}}</td>' +
                                     '<td>{{ $paymentmessage->created_at->setTimezone('Asia/Manila')->format('Y-m-d || h:i:s a') }}</td>'+

                                '</tr>' +
				'@endforeach' +
			                        '</tbody>' +
                    '</table>',
                width: '50%', // Set smaller width
                padding: '1em', // Reduce padding
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                onOpen: function () {
                    // Initialize DataTable inside SweetAlert2 modal
                    $('#tenant-table').DataTable({
                        "paging": true,
                        "pageLength": 5,  // Set page length to 5
                    });
                }
            });
        });
    });
</script>




















              </div>
            </div>
            @elseif (auth()->user()->user_type === 'rental_owner')
            <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{$bookingmessages->count()}}</h3>
    
                    <p>Number of Tenants</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer tenant-info">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{$bookingmessages->count()}}<sup style="font-size: 20px"></sup></h3>
                    <p>Number of Rooms</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer room-info">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{$bookingmessages->count()}}</h3>
    
                    <p>Number of Beds</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer bed-info">
                      More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
<script>
    $(document).ready(function () {
        // When the link is clicked
        $('.tenant-info').on('click', function (e) {
            e.preventDefault();

            // Show the SweetAlert2 modal
            Swal.fire({
                title: 'Tenant Info',
                html: '<table id="tenant-table" class="table table-bordered table-hover" style="width: 100%; text-align: center;">' +
                        '<thead class="btn-cancel">' +
                            '<tr>' +
                                '<th>Tenant Name</th>' +
                                '<th>Address</th>' +
                            '</tr>' +
                        '</thead>' +
			'<tbody>' +
				'@foreach($bookingmessages as $bookingmessage)' +
				'@if($bookingmessage->status == 'approaved')'+

                                '<tr>' +
                                    '<td>{{ $bookingmessage->sender->name }}</td>' +
                                    '<td>{{ $bookingmessage->address }}</td>' +
                                '</tr>' +
				'@endif'+
				'@endforeach'+
                        '</tbody>' +
                    '</table>',
                width: '50%', // Set smaller width
                padding: '1em', // Reduce padding
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                onOpen: function () {
                    // Initialize DataTable inside SweetAlert2 modal
                    $('#tenant-table').DataTable({
                        "paging": true,
                        "pageLength": 5,  // Set page length to 5
                    });
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function () {
        // When the link is clicked
        $('.room-info').on('click', function (e) {
            e.preventDefault();

            // Show the SweetAlert2 modal
            Swal.fire({
                title: 'Room Info',
                html: '<table id="tenant-table" class="table table-bordered table-hover" style="width: 100%; text-align: center;">' +
                        '<thead class="btn-cancel">' +
                            '<tr>' +
                                '<th>Room No</th>' + 
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
			'@foreach($bookingmessages as $bookingmessage)' +
                        '@if($bookingmessage->status == 'approaved')'+

                                '<tr>' +
                                    '<td>{{ $bookingmessage->selected->room_no }}</td>' +
				    '</tr>' +
				    '@endif'+
                            '@endforeach' +
                        '</tbody>' +
                    '</table>',
                width: '50%', // Set smaller width
                padding: '1em', // Reduce padding
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                onOpen: function () {
                    // Initialize DataTable inside SweetAlert2 modal
                    $('#tenant-table').DataTable({
                        "paging": true,
                        "pageLength": 5,  // Set page length to 5
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // When the link is clicked
        $('.bed-info').on('click', function (e) {
            e.preventDefault();

            // Show the SweetAlert2 modal
            Swal.fire({
                title: 'Bed Info',
                html: '<table id="tenant-table" class="table table-bordered table-hover" style="width: 100%; text-align: center;">' +
                        '<thead class="btn-cancel">' +
                            '<tr>' +
                                '<th>Bed No</th>' + 
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
			'@foreach($bookingmessages as $bookingmessage)' +
                           '@if($bookingmessage->status == 'approaved')'+
                                '<tr>' +
                                    '<td>{{ $bookingmessage->selected->bed_no }}</td>' +
				    '</tr>' +
				'@endif'+
                            '@endforeach' +
                        '</tbody>' +
                    '</table>',
                width: '50%', // Set smaller width
                padding: '1em', // Reduce padding
                showCloseButton: true,
                showConfirmButton: false,
                focusConfirm: false,
                onOpen: function () {
                    // Initialize DataTable inside SweetAlert2 modal
                    $('#tenant-table').DataTable({
                        "paging": true,
                        "pageLength": 5,  // Set page length to 5
                    });
                }
            });
        });
    });
</script>

       <h1 style="text-align: center">Search here the location of the tenant... <i class="fas fa-info-circle" id="infoButton"></i></h1>
          <script>
            document.getElementById('infoButton').addEventListener('click', function() {
    Swal.fire({
        title: 'More Info',
        text: 'Please click the number of the tenant to copy the address and paste it in the search to locate on the map. if the location not found please click the homies messenger to contact the tenant. ',
        icon: 'info',
        confirmButtonText: 'Ok'  // Only the Ok button is displayed
    });
});
        </script>
           @include('page.map')

           @endif
              <!-- ./col -->
          </div>
        </div><!-- /.container-fluid -->
        
  </x-app-layout>
  
