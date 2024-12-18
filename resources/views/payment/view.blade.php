
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
                  {{-- <a class="btn btn-sm elevation-2" href="/payments/create" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;"><i
                        class="fa fa-user-plus"></i>
                     Add New</a> --}}
               </div>
            </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
            @php
           $payments = \App\Models\Payment::all();
            @endphp
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                        <th>Tenant Name</th>
                        <th>Payment Method</th>
                        <th>Owner Name</th>
                        <th>Owner Number</th>
                        <th>Billing Name/Bill</th>
                        <th>Billing Fee</th>
                        <th>Billing Total</th>
                                               <th>Billing Status</th>
                        <th>Referral Id</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->name}}</td>
                        <td>{{ $payment->paymentmethod }}</td>
                        <td>{{ $payment->ownername}}</td>
                        <td>{{ $payment->number }}</td>
                        <td>{{ $payment->billingnameprice}}</td> 
                        <td>{{ $payment->fee }}</td>
                        <td>{{ $payment->total }}</td>
                                               <td class="{{ $payment->status === 'pending' ? 'bg-red' : 'bg-green' }}">                            {{ $payment->status }}
                        </td>
                        <td>{{ $payment->created_at->setTimezone('Asia/Manila')->format('Y-m-d || h:i:s a') }}</td>
                       <td class="text-right">
                        @if ($payment->status === 'paid')
                        <span class="badge badge-success">Already Paid</span>
                                       @else
                        <a class="btn btn-sm btn-success" href="#" onclick="showEditModal('{{ $payment->id }}', '{{ $payment->status }}', {{ $payment->balance }})">
                            <i class="fa fa-edit"></i>
                        </a>
                    @endif
                        {{-- <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$payment->id}}"><i
                              class="fa fa-trash-alt"></i></a> --}}
                     </td>
                  </tr>
                  <div id="deleteModal{{$payment->id}}" class="modal animated rubberBand delete-modal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="deleteForm{{$payment->id}}" action="{{ route('payments.destroy', $payment->id) }}" method="post">
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

    <script>
   function showEditModal(paymentId, currentStatus, balance) {
    const options = `
        <option value="pending" class="bg-red" ${currentStatus === 'pending' ? 'selected' : ''}>Pending</option>
        <option value="paid" class="bg-green" ${currentStatus === 'paid' ? 'selected' : ''}>Paid</option>
    `;

    const formHtml = `
        <form role="form" id="quickForm" action="{{ url('payments') }}/${paymentId}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" onchange="changeSelectColor(this)">
                                ${options}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    `;

    Swal.fire({
        title: 'Edit Payment Status',
        html: formHtml,
        showCancelButton: true,
        confirmButtonText: 'Update',
        preConfirm: () => {
            const selectedStatus = document.querySelector('select[name="status"]').value;
            
            // Check balance before submitting the form
            if ((selectedStatus === 'paid' || selectedStatus === 'received') && balance > 0) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'The payment is not fully paid. Please check the balance.',
                    icon: 'error'
                });
                return false;  // Prevent form submission
            }

            
            const form = document.getElementById('quickForm');
            if (form) {
                return new Promise((resolve, reject) => {
                    form.submit();
                });
            }
        },
        onClose: () => {
            document.getElementById('quickForm').reset();
        }
    });

    // Set initial background color based on current status
    changeSelectColor(document.querySelector('select[name="status"]'));
}

// Function to change background color of select element based on selected option
function changeSelectColor(select) {
    const selectedValue = select.options[select.selectedIndex].value;

    // Reset background color
    select.classList.remove('bg-red', 'bg-yellow', 'bg-green');

    // Add new background color class based on selected value
    if (selectedValue === 'pending') {
        select.classList.add('bg-red');
        } else if (selectedValue === 'paid') {
        select.classList.add('bg-green');
    }
}
    </script>
    

    </x-app-layout>
