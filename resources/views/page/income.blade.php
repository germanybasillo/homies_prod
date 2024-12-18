<x-app-layout>

    <x-slot name="header">
        <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0 text-dark"><span class="fa fa-chart-bar"></span> Income Reports</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                     </ol>
                  </div>
               </div>
    </x-slot>
    <div class="container-fluid">
        <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
             <div class="row">
               <div class="col-md-5">
               <div class="form-group">
                 <label>From</label>
                 <input type="month" name="number" class="form-control" placeholder="ex. 6000.00">
               </div></div>
               <div class="col-md-5">
                 <div class="form-group">
                   <label>To</label>
                   <input type="month" name="number" class="form-control" placeholder="ex. 6000.00">
                 </div></div>
                 <div class="col-md-2" style="margin-top: 30px;">
                   <div class="form-group">
                     <button class="btn btn-info">Search</button>
                   </div></div>
                 </div>
              <table id="example1" class="table table-bordered table-hover">
                 <thead class="btn-cancel">
                    <tr>
                       <th>Month</th>
                       <th>Income</th>
                    </tr>
                 </thead>
		 <tbody>
@php
    // Get all users except the currently authenticated user
    $users = \App\Models\User::where('id', '!=', auth()->id())->get();

    // Get all payment messages where the user is either the sender or receiver, grouped by month
    $paymentmessages = \App\Models\PaymentMessage::whereIn('status', ['paid', 'pending'])
        ->where(function ($query) {
            $query->where('receiver_id', auth()->id())
                  ->orWhere('sender_id', auth()->id());
        })
        ->orderBy('created_at', 'asc') // Ensure messages are in chronological order
        ->get()
        ->groupBy(function ($message) {
            return \Carbon\Carbon::parse($message->created_at)->format('F');
        });

    // Check if the first message in the entire list is 'pending'
    $firstMessage = $paymentmessages->flatten()->first();
    $isFirstPending = $firstMessage && $firstMessage->status == 'pending';
@endphp

@if($paymentmessages->isEmpty())
    <tr>
        <td colspan="2" class="text-center">No data</td>
    </tr>
@else
    @if ($isFirstPending) <!-- If the first message is pending, hide the entire payment info and total income -->
        <tr>
            <td colspan="2" class="text-center" style="color:red;">Pending</td>
        </tr>
    @else
        @foreach ($paymentmessages as $month => $monthPaymentmessages)
            <tr>
                <td>{{ $month }}</td> <!-- Display the month name -->
                <td>
                    <!-- Sum 'paid' status amounts -->
                    Php {{ number_format($monthPaymentmessages->where('status', 'paid')->sum(function($paymentmessage) {
                        return is_numeric($paymentmessage->total) ? (float) $paymentmessage->total : 0;
                    }), 2) }}
                </td>
            </tr>
        @endforeach
    @endif
    
    <!-- Total Income Row -->
    @if (!$isFirstPending) <!-- Only show the Total Income if the first message is not pending -->
        <tr>
            <td><b>Total Income</b></td>
            <td><b>
                <!-- Sum the 'paid' status amounts for all payment messages -->
                @php
                    $totalIncome = $paymentmessages->flatten()->where('status', 'paid')->sum(function($paymentmessage) {
                        return is_numeric($paymentmessage->total) ? (float) $paymentmessage->total : 0;
                    });
                @endphp
                Php {{ $totalIncome > 0 ? number_format($totalIncome, 2) : '0.00' }}
            </b></td>
        </tr>
    @endif
    @endif    
    
</tbody>
              </table>
           </div>
        </div>
     </div>
  </section>
</div>
</div>
<div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
     <div class="modal-body text-center">
        <img src="../assets/img/sent.png" alt="" width="50" height="46">
        <h3>Are you sure want to delete this Operator?</h3>
        <div class="m-t-20">
           <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
           <button type="submit" class="btn btn-danger">Delete</button>
        </div>
     </div>
  </div>
</div>
</div>
    </x-app-layout>
