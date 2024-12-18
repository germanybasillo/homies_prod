<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Your Billing</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Billings</li>
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
                      <th>Owner Name</th>
                       <th>Billing Name</th>
		       <th>Billing Price</th>
			<th>Billing Message</th>
	                <th>Billing Message Recieved</th>
                        <th>Pay Now</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach($billingmessages as $billingmessage)
		    <tr>
                        <td>{{$billingmessage->sender->name}}</td>
                        <td>{{$billingmessage->name}}</td>
		       <td>P{{ number_format($billingmessage->price, 2) }}</td>
		       <td>{{$billingmessage->content}}</td>
		       <td>{{ $billingmessage->created_at->format('F j, Y, g:i a') }}</td>
	       <td class="text-right">


                    <a href="#" class="btn btn-primary pay-now-cash" data-id="{{ $billingmessage->id }}" data-name="{{ $billingmessage->name }}" data-price="{{ $billingmessage->price }}">G Cash</a>
                    <a href="#" class="btn btn-primary pay-now-cashonhand" data-id="{{ $billingmessage->id }}" data-name="{{ $billingmessage->name }}" data-price="{{ $billingmessage->price }}">Cash on Hand</a>
	
</td>
                    </tr>
                    <div id="deleteModal{{$billingmessage->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$billingmessage->id}}" action="{{ route('billing_messages.destroy', $billingmessage->id) }}" method="post">
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
           </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td><b>Total BP</b></td>
        <td>P{{ number_format($billingmessages->sum('price'), 2) }}</td>
        <td class="text-right">
            <a href="#" class="btn btn-primary pay-now-cash" 
               data-id="all" 
               data-name="Total BP" 
	       data-price="{{ $billingmessages->sum('price') }}">G Cash Pay All</a>

             <a href="#" class="btn btn-primary pay-now-cashonhand" 
               data-id="all" 
               data-name="Total BP" 
               data-price="{{ $billingmessages->sum('price') }}">Cash on Hand Pay All</a>
        </td>
    </tr>
@endforeach
</tfoot> 
</table>	   
          </div>
      </div>
    </div>
    </div>







@php
  $rental_owner = \App\Models\User::where('user_type', 'rental_owner')->first();
    @endphp


<script>

// Attach event listeners to all G Cash buttons
document.querySelectorAll('.pay-now-cash').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const billingmessageId = event.target.getAttribute('data-id');
        const billingmessageName = event.target.getAttribute('data-name');
        const billingmessagePrice = parseFloat(event.target.getAttribute('data-price'));

        // Get users (receiver options) for the select dropdown 
        const rentalOwners = @json(App\Models\User::where('user_type', 'rental_owner')->get());

        // Show SweetAlert2 modal with form
        Swal.fire({
            title: 'Gcash Payment',
            html: `
                <form id="gcashPaymentForm" action="{{ route('payment_messages.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <input type="text" name="paymentmethod" class="form-control" value="Gcash" readonly>
                            </div>
                        </div>
                        @if ($rental_owner)
                        <div class="col-md-8 offset-md-2" id="owner-details">
                            <div class="form-group">
                                <label>Owner Name</label>
                                <input type="text" name="ownername" class="form-control" value="{{ $rental_owner->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Owner Gcash Number</label>
                                <input type="text" name="number" class="form-control" value="{{ $rental_owner->number }}" readonly>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Billing Name</label>
                                <input type="text" name="billingname" class="form-control" value="${billingmessageName}" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Billing Price</label>
                                <input type="text" name="price" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Your Fee</label>
                                <input type="text" name="fee" id="fee" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Total Billing</label>
                                <input type="text" id="total" name="total" class="form-control" readonly>
                            </div>
			    </div>


@php
    $displayedSenders = []; // Array to track displayed sender IDs
@endphp

<div class="col-md-8 offset-md-2">
    <div class="form-group">
        <label>Receiver</label>
        <select name="receiver_id" class="form-control">
            <option value="">Select Receiver</option>
            @foreach($billingmessages as $billingmessage)
                @php
                    $sender = $billingmessage->sender;
                @endphp

                @if(!in_array($sender->id, $displayedSenders))
                    <option value="{{ $sender->id }}">{{ $sender->name }}</option>
                    @php
                        $displayedSenders[] = $sender->id;
                    @endphp
                @endif
            @endforeach
        </select>
    </div>
</div>
	                               <div class="col-md-8 offset-md-2" style="display:none">
                                             <div class="form-group">
                                               <label>Status</label>
                                       <select class="form-control" name="status">
                                                <option value="pending" style="color:red">Pending</option>
                                              <option value="paid" style="color:green">Receive/Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>

	
	
	
		</div>
                </div>
                <button type="submit" class="btn btn-primary">Pay with Gcash</button>
            </form>
            `,
                showConfirmButton: false,
        width: '600px',
        didOpen: () => {
            // Access necessary DOM elements for calculations
            const billingInput = document.getElementById('billing');
            const feeInput = document.getElementById('fee');
            const totalInput = document.getElementById('total');

            // Calculate fee
            let fee = 0;
            if (billingmessagePrice >= 1 && billingmessagePrice <= 500) {
                fee = 5;
            } else {
                // Every 500 increment adds 5 to the fee
                fee = 5 + Math.floor((billingmessagePrice - 501) / 500) * 5;
            }
            feeInput.value = fee;

            // Calculate total (billing amount + fee)
            let total = billingmessagePrice + fee;
            totalInput.value = total;
            }
        });
    });
});

// Attach event listeners to all Cash on Hand buttons
document.querySelectorAll('.pay-now-cashonhand').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const billingmessageId = event.target.getAttribute('data-id');
        const billingmessageName = event.target.getAttribute('data-name');
        const billingmessagePrice = parseFloat(event.target.getAttribute('data-price'));

        // Get users (receiver options) for the select dropdown
        const rentalOwners = @json(App\Models\User::where('user_type', 'rental_owner')->get());

        // Show SweetAlert2 modal with form
        Swal.fire({
            title: 'Cash on Hand Payment',
            html: `
                            <form id="cashOnHandPaymentForm" action="{{ route('payment_messages.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <input type="text" name="paymentmethod" class="form-control" value="Cash on Hand" readonly>
                            </div>
                        </div>
                        @if ($rental_owner)
                        <div class="col-md-8 offset-md-2" id="owner-details">
                            <div class="form-group">
                                <label>Owner Name</label>
                                <input type="text" name="ownername" class="form-control" value="{{ $rental_owner->name }}" readonly>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label>Owner Gcash Number</label>
                                <input type="text" name="number" class="form-control" value="N/A" readonly>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Billing Name</label>
                                <input type="text" name="billingname" class="form-control" value="${billingmessageName}" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Billing Price</label>
                                <input type="text" name="total" class="form-control" value="${billingmessagePrice}" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Your Fee</label>
                                <input type="text" name="fee" value="0" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2" style="display:none;">
                            <div class="form-group">
                                <label>Total Billing</label>
                                <input type="text" name="price" value="0" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Receiver Dropdown -->
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group">
                                <label>Receiver</label>
                                <select name="receiver_id" class="form-control">
                                    <option value="">Select Receiver</option>
                                    ${rentalOwners.map(owner => `
                                        <option value="${owner.id}">${owner.name}</option>
                                    `).join('')}
                                </select>
                            </div>
                        </div>

                        <!-- Status Dropdown (Hidden) -->
                        <div class="col-md-8 offset-md-2" style="display:none">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="pending" style="color:red">Pending</option>
                                    <option value="paid" style="color:green">Received/Paid</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Pay Cash on Hand</button>
            </form>            `,
            showConfirmButton: false,
            width: '600px',
        });
    });
});

</script>













































 </x-app-layout>

