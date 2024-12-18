<x-app-layout>
    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><span class="fa fa-bed"></span>Tenant Payments</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payments</li>
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
                        <th>Tenant Name</th>
                        <th>Payment Method</th>
                        <th>Owner Name</th>
                        <th>Owner Number</th>
			<th>Billing Name</th>
                        <th>Billing Fee</th>
                        <th>Billing Total</th>
                                               <th>Billing Status</th>
                        <th>Referral Id</th>
                  <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($paymentmessages as $paymentmessage)
                    <tr>
                        <td>{{ $paymentmessage->sender->name}}</td>
                        <td>{{ $paymentmessage->paymentmethod }}</td>
                        <td>{{ $paymentmessage->ownername}}</td>
                        <td>{{ $paymentmessage->number }}</td>
			<td>{{ $paymentmessage->billingname}}</td>
                        <td>{{ $paymentmessage->fee }}</td>
                        <td>{{ $paymentmessage->total }}</td>
                                               <td class="{{ $paymentmessage->status === 'pending' ? 'bg-red' : 'bg-green' }}">                            {{ $paymentmessage->status }}
                        </td>
			<td>{{ $paymentmessage->created_at->setTimezone('Asia/Manila')->format('Y-m-d || h:i:s a') }}</td>
<td class="text-right"> 
		 @if ($paymentmessage->status === 'pending')    
                        <a class="btn btn-sm btn-success editPaymentBtn" data-id="{{ $paymentmessage->id }}" data-name="{{ $paymentmessage->status }}" href="#">
                            <i class="fa fa-edit"></i>
			</a>
			@endif		     
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$paymentmessage->id}}" href="#"><i
                                class="fa fa-trash-alt"></i></a>
                       </td>
                    </tr>
                    <div id="deleteModal{{$paymentmessage->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$paymentmessage->id}}" action="{{ route('payment_messages.destroy', $paymentmessage->id) }}" method="post">
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
$(document).on('click', '.editPaymentBtn', function(e) {
    e.preventDefault(); // Prevent the default anchor click behavior

    // Get data-id and data-status from the clicked button
    var paymentId = $(this).data('id');
    var paymentStatus = $(this).data('status');

    // Show SweetAlert2 modal with form to edit the status
    Swal.fire({
        title: 'Edit Payment Message Status',
        html: `
            <div>
                <label for="status">Select Status:</label>
                <select id="status" class="swal2-input">
                    <option value="pending" ${paymentStatus === 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="paid" ${paymentStatus === 'paid' ? 'selected' : ''}>Paid</option>
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const status = $('#status').val(); // Get the selected status
            return { status: status, paymentId: paymentId };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { status, paymentId } = result.value;

            // Send PUT request to update the status
            $.ajax({
                url: `/payment-messages/${paymentId}`, // The PUT route you defined
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

    

    </x-app-layout>
