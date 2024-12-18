<x-app-layout>
    <x-slot name="header">
    <div class="content-header">
        <div class="container-fluid">
           <div class="row mb-2">
              <div class="col-sm-6">
                 <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Billing</h1>
              </div>
              <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Billings</li>
                 </ol>
              </div>
              <a class="btn btn-sm elevation-2" id="showFormModal" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;">
                <i class="fa fa-user-plus"></i> Add New
              </a>
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
                       <th>Billing Name</th>
		       <th>Billing Price</th>
			<th>Billing Message</th>
                        <th>Billing Message Sent</th>
                        <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                    @foreach($billingmessages as $billingmessage)
		    <tr>
                        <td>{{$billingmessage->receiver->name}}</td>
                        <td>{{$billingmessage->name}}</td>
		       <td>P{{ number_format($billingmessage->price, 2) }}</td>
		       <td>{{$billingmessage->content}}</td>
                    <td>{{ $billingmessage->created_at->format('F j, Y, g:i a') }}</td>
		    
<td class="text-right">     
                        <a class="btn btn-sm btn-success editBillingBtn" data-id="{{ $billingmessage->id }}" data-name="{{ $billingmessage->name }}" data-price="{{ $billingmessage->price}}"  data-content="{{ $billingmessage->content}}" href="#">
                            <i class="fa fa-edit"></i>
                        </a>                     
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$billingmessage->id}}" href="#"><i
                                class="fa fa-trash-alt"></i></a>
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
                 @endforeach
               </tbody>
            </table>                    
          </div>
      </div>
    </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
    document.getElementById('showFormModal').addEventListener('click', function (e) {
        e.preventDefault();  // Prevent default link behavior

        Swal.fire({
            title: 'Add New Billing Message',
            html: `
                <form id="billingMessageForm" action="{{ route('billing_messages.store') }}" method="POST">
                    @csrf

                    <!-- Recipient selection -->
                    <div style="margin-bottom: 15px;">
                        <label for="receiver_id" style="font-size: 14px; margin-bottom: 5px; color: #333;">Select Recipient:</label>
                        <select name="receiver_id" id="receiver_id" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
			<option value="" disabled selected>Select a user</option>
                
      		 
@php
    $displayedSenders = []; // Array to track displayed sender IDs
@endphp

	@foreach($bookingmessages as $bookingmessage)
      @if($bookingmessage->status == 'approaved')

    @php
        $sender = $bookingmessage->sender;
    @endphp
    
    <!-- Check if this sender's name has already been displayed -->
    @if(!in_array($sender->id, $displayedSenders))
        <!-- Display the sender's name only once -->
        <option value="{{ $sender->id }}">
            {{ $sender->name }}
        </option>

        <!-- Mark this sender as displayed -->
        @php
            $displayedSenders[] = $sender->id;
        @endphp
		@endif
		@endif
  @endforeach





		</select>
                    </div>

                    <!-- Message content -->
                    <div style="margin-bottom: 15px;">
                        <label for="content" style="font-size: 14px; margin-bottom: 5px; color: #333;">Message Content:</label>
                        <textarea name="content" id="content" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required></textarea>
                    </div>

                    <!-- Message name (e.g., service name) -->
                    <div style="margin-bottom: 15px;">
                        <label for="name" style="font-size: 14px; margin-bottom: 5px; color: #333;">Name:</label>
                        <input type="text" name="name" id="name" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>

                    <!-- Price -->
                    <div style="margin-bottom: 15px;">
                        <label for="price" style="font-size: 14px; margin-bottom: 5px; color: #333;">Price:</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>
                </form>
            `,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Submit',
            focusConfirm: false,
            preConfirm: () => {
                // Here you can submit the form
                document.getElementById('billingMessageForm').submit();
            }
        });
    });
</script>

<script>

document.querySelectorAll('.editBillingBtn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default behavior

        // Retrieve data attributes from the clicked button
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const content = this.getAttribute('data-content');
        const price = this.getAttribute('data-price');

        Swal.fire({
            title: 'Edit Billing Message',
            html: `
                <form id="editBillingMessageForm" action="/billing-messages/${id}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Message name -->
                    <div style="margin-bottom: 15px;">
                        <label for="edit_name" style="font-size: 14px; margin-bottom: 5px; color: #333;">Name:</label>
                        <input type="text" name="name" id="edit_name" value="${name}" 
                               style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>
                    
                    <!-- Message content -->
                    <div style="margin-bottom: 15px;">
                        <label for="edit_content" style="font-size: 14px; margin-bottom: 5px; color: #333;">Message Content:</label>
                        <textarea name="content" id="edit_content" 
                                  style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>${content}</textarea>
                    </div>
                    
                    <!-- Price -->
                    <div style="margin-bottom: 15px;">
                        <label for="edit_price" style="font-size: 14px; margin-bottom: 5px; color: #333;">Price:</label>
                        <input type="number" name="price" id="edit_price" value="${price}" step="0.01" min="0" 
                               style="padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                    </div>
                </form>
            `,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Save Changes',
            focusConfirm: false,
            preConfirm: () => {
                // Submit the form
                document.getElementById('editBillingMessageForm').submit();
            }
        });
    });
});
</script>

    </x-app-layout>













