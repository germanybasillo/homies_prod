
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
                        <th>Billing Bill</th>
                        <th>Billing Fee</th>
                        <th>Billing Total</th>
                                               <th>Billing Status</th>
                        <th>Referral Id</th>
                  
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
                       <td>{{ $paymentmessage->price}}</td> 
                        <td>{{ $paymentmessage->fee }}</td>
                        <td>{{ $paymentmessage->total }}</td>
                                               <td class="{{ $paymentmessage->status === 'pending' ? 'bg-red' : 'bg-green' }}">                            {{ $paymentmessage->status }}
                        </td>
                        <td>{{ $paymentmessage->created_at->setTimezone('Asia/Manila')->format('Y-m-d || h:i:s a') }}</td>
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
