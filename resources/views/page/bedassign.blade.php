<x-app-layout>
   <x-slot name="header">
       <div class="content-header">
           <div class="container-fluid">
               <div class="row mb-2">
                   <div class="col-sm-6">
                       <h1 class="m-0 text-dark"><span class="fa fa-bed"></span> Beds Assignment</h1>
                   </div>
                   <div class="col-sm-6">
                       <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="#">Home</a></li>
                           <li class="breadcrumb-item active">Bed Assignment</li>
                       </ol>
                   </div>
               </div>
           </div>
   </x-slot>

   <div class="container-fluid">
       <div class="card card-info elevation-2">
           <br>
           <div class="col-md-12 table-responsive">
      <table id="example1" class="table table-bordered table-hover" style="width: 100%; text-align: center;">
    <thead class="btn-cancel">
        <tr>
            <th>Tenant Name</th>
            <th>Bed No.</th>
            <th>Room No.</th>
            <th>Date Start</th>
            <th>Due Date</th>
        </tr>
    </thead>
    <tbody>
	   @foreach($bookingmessages as $bookingmessage)
           @if($bookingmessage->status == 'approaved')

            <tr>
                <td>{{ $bookingmessage->sender->name }}</td>
                <td>{{ $bookingmessage->selected->room_no }}</td>  
                <td>{{ $bookingmessage->selected->bed_no }}</td>
                <td>{{ $bookingmessage->start_date }}</td>
                <td>{{ $bookingmessage->due_date }}</td>
	    </tr>
	@endif
        @endforeach		
    </tbody>
</table>
           </div>
       </div>
   </div>
</x-app-layout>
