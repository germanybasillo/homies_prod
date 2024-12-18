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
                       <th>Billing Name</th>
                       <th>Billing Price</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                    @foreach($billings as $billing)
                    <tr>
                        <td>{{$billing->name}}</td>
                       <td>Php {{$billing->billing}}</td>
                       <td class="text-right">     
                        <a class="btn btn-sm btn-success editBillingBtn" data-id="{{ $billing->id }}" data-name="{{ $billing->name }}" data-billing="{{ $billing->billing }}" href="#">
                            <i class="fa fa-edit"></i>
                        </a>                     
                          <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$billing->id}}" href="#"><i
                                class="fa fa-trash-alt"></i></a>
                       </td>
                    </tr>
                    <div id="deleteModal{{$billing->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <form id="deleteForm{{$billing->id}}" action="{{ route('billings.destroy', $billing->id) }}" method="post">
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


@php
    // Fetch users with tenant user_type
    $users = \App\Models\User::where('user_type', 'tenant')->get();
@endphp

<script>

  document.getElementById('showFormModal').addEventListener('click', function (e) {
    e.preventDefault();

    // Get the users from the Blade template (filtered by 'tenant' user_type)
    const users = @json($users); // Convert the users data to a JavaScript object

    // Create the user options dynamically, filtering for tenants only
    let userOptions = '';
    users.forEach(user => {
        if (user.user_type === 'tenant') {
            userOptions += `<option value="${user.id}">${user.name} (ID: ${user.id})</option>`;
        }
    });

    Swal.fire({
        title: 'Add New Billing',
        html: `
        <form id="billingForm" action="{{ route('billing.store') }}" method="POST">
            @csrf
            <div class="form-group" style="text-align: left;">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group" style="text-align: left;">
                <label for="billing">Billing</label>
                <input type="text" id="billing" name="billing" class="form-control" placeholder="Price" value="{{ old('billing') }}" required>
            </div>
            <div class="form-group" style="text-align: left;">
                <label for="user_id">User</label>
                <select id="user_id" name="user_id" class="form-control" required>
                    <option value="" disabled selected>Select a Tenant</option>
                    ${userOptions} <!-- Inject dynamically created user options -->
                </select>
            </div>
        </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        preConfirm: () => {
            const billingValue = document.getElementById('billing').value;
            const nameValue = document.getElementById('name').value;
            const userIdValue = document.getElementById('user_id').value;

            // Validate billing input - check if it's a number
            if (!nameValue || !billingValue || !userIdValue) {
                Swal.showValidationMessage('Please fill out all fields.');
                return false;
            }

            if (isNaN(billingValue)) {
                // If billing is not a number, show validation error inside SweetAlert
                Swal.showValidationMessage('Billing must be a number.');
                return false;
            }

            // If valid, submit the form
            const form = document.getElementById('billingForm');
            form.submit();
        }
    });
});
</script>   


<script>
            document.addEventListener('DOMContentLoaded', function () {
                // Use event delegation to handle multiple edit buttons
                document.querySelectorAll('.editBillingBtn').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Get data attributes for the clicked button
                        const billingId = this.getAttribute('data-id');
                        const billingName = this.getAttribute('data-name');
                        const billingAmount = this.getAttribute('data-billing');
                        
                        // Initialize doublingPeriod (update this as per your logic if necessary)
                        let doublingPeriod = ""; // Initialize this variable if you have a source to set it
        
                        Swal.fire({
                            title: 'Edit Billing',
                            html: `
                            <form id="editBillingForm" action="/billings/${billingId}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group" style="text-align: left;">
                                  <label for="name">Name</label>
                                  <input type="text" id="name" name="name" class="form-control" value="${billingName}" required>
                                </div>
                                <div class="form-group" style="text-align: left;">
                                  <label for="billing">Billing</label>
                                  <input type="text" id="billing" name="billing" class="form-control" value="${billingAmount}" required>
                                </div>
                            </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            cancelButtonText: 'Cancel',
                            focusConfirm: false,
                            preConfirm: () => {
                                const billingValue = document.getElementById('billing').value;
                                const nameValue = document.getElementById('name').value;
        
                                // Validate fields
                                if (!nameValue || !billingValue) {
                                    Swal.showValidationMessage('Please fill out both fields.');
                                    return false;
                                }
        
                                if (isNaN(billingValue)) {
                                    Swal.showValidationMessage('Billing must be a number.');
                                    return false;
                                }
        
                                // Compare original values with current values
                                if (billingValue === billingAmount && nameValue === billingName) {
                                    Swal.showValidationMessage('No changes were made.');
                                    return false;
                                }
        
                                // Submit the form if validation passes and changes were made
                                const form = document.getElementById('editBillingForm');
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
            
    </x-app-layout>
