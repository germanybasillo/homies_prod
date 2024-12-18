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
                        <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach($bookingmessages as $bookingmessage)
		    <tr>
			<td>{{$bookingmessage->sender->name}}</td>
		        <td>{{$bookingmessage->selected->hubrental->address}}</td>
		       <td>{{$bookingmessage->selected->room_no}}</td>
		       <td>{{$bookingmessage->selected->description}}</td>
			<td>{{$bookingmessage->selected->bed_no}}</td>
			<td>{{$bookingmessage->selected->bed_status}}</td>
			<td>{{$bookingmessage->start_date}}</td>
			<td>{{$bookingmessage->due_date}}</td>
			<td>{{$bookingmessage->status}}</td>
                    <td>{{ $bookingmessage->created_at->format('F j, Y, g:i a') }}</td>
		    
<td class="text-right">     
                        <a class="btn btn-sm btn-success editBillingBtn" data-id="{{$bookingmessage->id}}" data-status="$bookingmessage->status}}"  href="#">
                            <i class="fa fa-edit"></i>
                        </a>                     
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$bookingmessage->id}}" href="#"><i
                                class="fa fa-trash-alt"></i></a>
                       </td>
                    </tr>
                    <div id="deleteModal{{$bookingmessage->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$bookingmessage->id}}" action="{{ route('booking_messages.destroy', $bookingmessage->id) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-body text-center">
                                      <img src="{{asset('logo.png')}}" alt="Logo" width="50" height="46">
                                      <h3>Are you sure you want to delete this Operator?</h3>
                                      <div class="m-t-20">
                                          <button type="button" class="btn btn-white" data-dismiss="modal" style="background-color: blue;color:white;border-color:blue;">Close</button>
                                          <button type="submit" class="btn btn-danger">Delete</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 @endforeach
               </tbody>
            </table>                    
          </div>
      </div>
    </div>
    </div>



<script>
$(document).on('click', '.editBillingBtn', function(e) {
    e.preventDefault(); // Prevent the default anchor click behavior

    // Get data-id and data-status from the clicked button
    var bookingId = $(this).data('id');
    var bookingStatus = $(this).data('status');

    // Show SweetAlert2 modal with form to edit the status
    Swal.fire({
        title: 'Edit Billing Message Status',
        html: `
            <div>
                <label for="status">Select Status:</label>
                <select id="status" class="swal2-input">
                    <option value="pending" ${bookingStatus === 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="approaved" ${bookingStatus === 'approaved' ? 'selected' : ''}>Approved</option>
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const status = $('#status').val(); // Get the selected status
            return { status: status, bookingId: bookingId };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { status, bookingId } = result.value;

            // Send PUT request to update the status
            $.ajax({
                url: `/booking-messages/${bookingId}`, // The PUT route you defined
                method: 'PUT',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}', // Add CSRF token if needed
                },
                success: function(response) {
                    // Show success animation with SweetAlert2
                    Swal.fire({
                        title: 'Success!',
                        text: 'Status updated successfully.',
                        icon: 'success',
                        showConfirmButton: false, // Hide the confirm button
                        timer: 1500, // Auto close after 1.5 seconds
                        timerProgressBar: true, // Add progress bar
                        didOpen: () => {
                            Swal.showLoading(); // Optional: Show a loading spinner if needed
                        },
                        willClose: () => {
                            // Optional: You can reload the page if desired
                            location.reload(); // Reload the page after the success message closes
                        }
                    });
                },
                error: function() {
                    Swal.fire('Error!', 'There was an issue updating the status.', 'error');
                }
            });
        }
    });
});
</script>




    </x-app-layout>
