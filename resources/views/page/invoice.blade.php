<x-app-layout>
    <x-slot name="header">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-dark"><span class="nav-icon fa fa-file-invoice"></span> Invoice</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                  </ol>
                </div>
              </div>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i>Homies: Rental-Management-System
                    <small class="float-right">Date: <span id="current-date-time"></span></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Homies.</strong><br>
                    Philippines Davao Del Norte<br>
                    Tagum City Area<br>
                    Phone: (+63) 9944398759<br>
                    Email: admin@homies.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address><div class="form-group">
                    <label>Tenant name</label>
                    <select name="tenant_id" class="form-control">
                        <option value="" disabled selected>Select a tenant</option>
                        @foreach($user as $tenant)
                            <option value="{{ $tenant->id }}">{{ $tenant->email }}</option>
                        @endforeach
                    </select>
                  </div></address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b><div class="form-group">
                    <label>Invoice</label>
                    <input type="text" name="invoice" class="form-control" placeholder="ex. #007612">
                  </div></b>
                  <b><div class="form-group">
                    <label>Due Date</label>
                    {{-- <input type="date" name="date" class="form-control"> --}}
                    <select name="due_date" class="form-control">
                        <option value="" disabled selected>Select a due_date</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->due_date }}</option>
                        @endforeach
                    </select>
                  </div></b><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Description</th>
                      <th>Month</th>
                      <th>Year</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>Monthly Rent</td>
                      <td>
                        <select class="bords" style="width: 23%">
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                        </select>
                      </td>
                      <td>
                        <select class="bords" id="yearSelect"></select>
                      </td>
                      <td>Php 5,000.00</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <select class="form-select" name="paymentMethod" id="paymentMethod">
                    <option value="" disabled selected>Select a Payment Method</option>
                    <option value="gcash" data-image="../assets/img/credit/gcash.png">GCash</option>
                    <option value="cashOnHand" data-image="../assets/img/credit/cash_on_hand.png">Cash on Hand</option>
                </select>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due:</p>
                  <div class="table-responsive">    
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Php 3000.00</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>Php 10.34</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>php 3190.00</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="javascript:void(0);" onclick="window.print();" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <script>
        // Function to format the date and time as MM/DD/YYYY HH:MM:SS AM/PM
        function formatDateTime(date) {
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const year = date.getFullYear();
            let hours = date.getHours();
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            hours = hours.toString().padStart(2, '0');
            return `${month}/${day}/${year} ${hours}:${minutes}:${seconds} ${ampm}`;
        }
     
         // Get the current date and time
         function updateDateTime() {
                 const now = new Date();
                 const formattedDateTime = formatDateTime(now);
                 // Update the HTML element with the current date and time
                 document.getElementById('current-date-time').textContent = formattedDateTime;
             }
     
             // Update the date and time every second
             setInterval(updateDateTime, 1000);
     
             // Initialize with the current date and time immediately
             updateDateTime();
         </script>
    <script>
        // Get the current year
        var currentYear = new Date().getFullYear();
        
        // Select the dropdown element
        var select = document.getElementById("yearSelect");
        
        // Generate options from current year to 2030
        for (var year = currentYear; year <= 3000; year++) {
            var option = document.createElement("option");
            option.text = year;
            select.appendChild(option);
        }
    </script>
    <style>
        /* Style for custom select */
        .bords {
            border: none;
            background-color: transparent;
            padding: 0;
            outline: none;
            cursor: pointer;
        }
    </style>
    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image');
            // You can use this imageUrl to update an image preview if needed
            console.log('Selected image URL:', imageUrl);
        });
    </script>
</x-app-layout>
