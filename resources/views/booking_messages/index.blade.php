<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Booking</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Bookings</li>
                 </ol>
              </div>
           </div>
        </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
		    <tr>
		       <th>Name</th>
                         <th>Address</th>
			<th>Room</th>
			<th>Description</th>
			<th>Bed</th>
			<th>Status</th>
                  	<th>Start Date</th>
                         <th>Due Date</th> 
			<th>Booking Message Sent</th>
			 <th>Booking Status</th>
			<th>Notification</th>		
                       </tr>
                 </thead>
                 <tbody>
                    @foreach($bookingmessages as $bookingmessage)
		    <tr>
			<td>{{$bookingmessage->receiver->name}}</td>
                        <td>{{ $bookingmessage->selected->hubrental->address }}</td>
		       <td>{{$bookingmessage->selected->room_no}}</td>
		       <td>{{$bookingmessage->selected->description}}</td>
			<td>{{$bookingmessage->selected->bed_no}}</td>
			<td>{{$bookingmessage->selected->bed_status}}</td>
			<td>{{$bookingmessage->start_date}}</td>
			<td>{{$bookingmessage->due_date}}</td>
			<td>{{$bookingmessage->status}}</td>
			<td>{{ $bookingmessage->created_at->format('F j, Y, g:i a') }}</td>
		            <td>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($bookingmessage->due_date);
                                        $today = \Carbon\Carbon::today();
                                        $daysRemaining = $dueDate->diffInDays($today);
                                    @endphp

                                    @if($bookingmessage->status == 'approaved')
                                        @if($dueDate->isToday())
                                            <span class="badge badge-warning">Due Today</span>
                                        @elseif($daysRemaining <= 2)
                                            <span class="badge badge-info">Close to Due Date</span>
                                        @else
                                            <span class="badge badge-success">Not Due</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>    
			    @endforeach    
	    	  </tbody>
                </table>                   
          </div>
      </div>
    </div>
    </div>

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Loop through each row in the table and check the condition for showing pop-ups
        @foreach($bookingmessages as $bookingmessage)
            @php
                $dueDate = \Carbon\Carbon::parse($bookingmessage->due_date);
                $today = \Carbon\Carbon::today();
                $daysRemaining = $dueDate->diffInDays($today);
            @endphp

            @if($bookingmessage->status == 'approaved')
                @if($dueDate->isToday())
                    Swal.fire({
                        title: 'Booking Due Today!',
                        text: 'This booking is due today. Please review it now.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                @elseif($daysRemaining <= 2)
                    Swal.fire({
                        title: 'Booking Due Soon!',
                        text: 'This booking is close to the due date. Please review it soon.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                @endif
            @endif
        @endforeach
    });
</script>

 </x-app-layout>
