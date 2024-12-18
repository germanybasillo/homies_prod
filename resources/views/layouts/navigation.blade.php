    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
            <a class="nav-link" data-widget="fullscreen" href="route('logout')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
               <i class="fas fa-sign-out-alt">Logout</i>
            </a>
        </form>
         </li>
        </ul>
      </nav>
      <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/logo.png" alt="Logo" width="230" height="100" style="margin-bottom:-180px;margin-top:-127px"
        style="opacity: .8">
</a><br><br><br>

    <!-- Sidebar -->
    <div class="sidebar">   
      <!-- Sidebar Menu -->
      <nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	@if (auth()->user()->user_type === 'rental_owner')
          <li class="nav-item">
            <a href="/dashboard" class="nav-link">
              <i class="nav-icon fa fa-tachometer-alt"></i>
              <p>
               Dashboard
	      </p>
            </a>
	  </li>

	@elseif (auth()->user()->user_type === 'tenant')
    	<li class="nav-item">
            <a href="/dashboard" class="nav-link">
              <i class="nav-icon fa fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
	  </li>
	  @elseif (auth()->user()->user_type === 'admin')
		<li class="nav-item">
            <a href="{{ route('contact.form') }}" class="nav-link">
              <i class="nav-icon fa fa-envelope"></i>
              <p>
               Contact
              </p>
            </a>
	  </li>
	<li class="nav-item">
            <a href="{{ route('pendingacc') }}" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
               Pending Acc
              </p>
            </a>
	  </li>

	<li class="nav-item">
            <a href="/chatify" class="nav-link" id="messengerButton">
              <i class="nav-icon fa fa-comments"></i>
              <p>
               Homies Messenger
              </p>
            </a>
            <script>
              // Check if the user has already acknowledged the reminder
              let hasShownAlert = false;
          
              document.getElementById('messengerButton').addEventListener('mouseover', function() {
                  // Only show the alert if it hasn't been shown yet
                  if (!hasShownAlert) {
                      Swal.fire({
                          title: 'Reminder',
                          text: 'Check this messenger every time you log in!',
                          icon: 'info',
                          confirmButtonText: 'OK',
                          allowOutsideClick: true
                      }).then(() => {
                          // Set the flag to true after the alert is acknowledged
                          hasShownAlert = true;
                      });
                  }
              });
          </script>
	  </li>
          <li class="nav-header">Hub Map</li>
          <li class="nav-item">
            <a href="{{route('hubrentals.index')}}" class="nav-link">
              <i class="nav-icon fa fa-chart-bar"></i>
              <p>
              Hub Rental
              </p>
            </a>
          </li>

	@endif
          @if (auth()->user()->user_type === 'tenant')
          <li class="nav-item">
            <a href="/tenantprofiles" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
              Tenant Profile
              </p>
            </a>
	  </li>
           <li class="nav-item">
            <a href="/booking-messages" class="nav-link">
              <i class="nav-icon fa fa-book"></i>
	      <p>
		@php
                $userId = auth()->id(); 
                $senderMessagesCount = \App\Models\BookingMessage::where('sender_id', $userId)->count();
            	@endphp
            	Booking History ({{$senderMessagesCount}})
             </p>
            </a>
	  </li>

         <li class="nav-item">
        <a href="/billing-messages/show" class="nav-link">
        <i class="nav-icon fa fa-file-invoice-dollar"></i>
        <p>
            @php
                $userId = auth()->id(); 
                $receivedMessagesCount = \App\Models\BillingMessage::where('receiver_id', $userId)->count();
            @endphp
             Your Billing   ({{$receivedMessagesCount}})
        </p>
          </a>
         </li>

         <li class="nav-item">
        <a href="/payment-messages" class="nav-link">
        <i class="nav-icon fa fa-file"></i>
	<p>
           @php
                $userId = auth()->id(); 
                $senderMessagesCount = \App\Models\PaymentMessage::where('sender_id', $userId)->count();
            @endphp
             Payment History   ({{$senderMessagesCount}})
        </p>
        </a>
     </li>
	<li class="nav-item">
            <a href="/chatify" class="nav-link" id="messengerButton">
              <i class="nav-icon fa fa-comments"></i>
              <p>
               Homies Messenger
              </p>
            </a>
            <script>
              // Check if the user has already acknowledged the reminder
              let hasShownAlert = false;
          
              document.getElementById('messengerButton').addEventListener('mouseover', function() {
                  // Only show the alert if it hasn't been shown yet
                  if (!hasShownAlert) {
                      Swal.fire({
                          title: 'Reminder',
                          text: 'Check this messenger every time you log in!',
                          icon: 'info',
                          confirmButtonText: 'OK',
                          allowOutsideClick: true
                      }).then(() => {
                          // Set the flag to true after the alert is acknowledged
                          hasShownAlert = true;
                      });
                  }
              });
          </script>
	  </li>

	  @elseif (auth()->user()->user_type === 'rental_owner')
 
	  <li class="nav-item">
            <a href="{{route('bedassign')}}" class="nav-link">
              <i class="nav-icon fa fa-bed"></i>
              <p>
              Bed Assignment
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/selecteds" class="nav-link">
              <i class="nav-icon fa fa-home"></i>
              <p>
                 @php
               $selectedsCount = \App\Models\Selected::where('user_id', Auth::id())->count();
              @endphp
            Room Selected  ({{ $selectedsCount }})              
           </p>
            </a>
          </li>
         <li class="nav-item">
            <a href="/chatify" class="nav-link" id="messengerButton">
              <i class="nav-icon fa fa-comments"></i>
              <p>
               Homies Messenger
              </p>
            </a>
            <script>
              // Check if the user has already acknowledged the reminder
              let hasShownAlert = false;
          
              document.getElementById('messengerButton').addEventListener('mouseover', function() {
                  // Only show the alert if it hasn't been shown yet
                  if (!hasShownAlert) {
                      Swal.fire({
                          title: 'Reminder',
                          text: 'Check this messenger every time you log in!',
                          icon: 'info',
                          confirmButtonText: 'OK',
                          allowOutsideClick: true
                      }).then(() => {
                          // Set the flag to true after the alert is acknowledged
                          hasShownAlert = true;
                      });
                  }
              });
          </script>
	  </li>

          <li class="nav-item">
            <a href="/billing-messages" class="nav-link">
              <i class="nav-icon fa fa-file-invoice-dollar"></i>
	      <p>
                @php
                $userId = auth()->id(); 
                $sentMessagesCount = \App\Models\BillingMessage::where('sender_id', $userId)->count();
            @endphp
              Billings   ({{$sentMessagesCount}})
              </p>
            </a>
	  </li>

          <li class="nav-item">
            <a href="/payment-messages/show" class="nav-link">
              <i class="nav-icon fa fa-file-invoice"></i> 
	      <p>
                  @php
                $userId = auth()->id(); 
                $receivedMessagesCount = \App\Models\PaymentMessage::where('receiver_id', $userId)->count();
            @endphp
             Tenant Payment  ({{$receivedMessagesCount}})
              </p>
            </a>
	  </li>
           <li class="nav-header">BOOKINGS</li>
          <li class="nav-item">
            <a href="/booking-messages/show" class="nav-link">
              <i class="nav-icon fa fa-book"></i>
	      <p>
		@php
                $userId = auth()->id(); 
                $receivedMessagesCount = \App\Models\BookingMessage::where('receiver_id', $userId)->count();
            	@endphp
                Tenant Booking ({{$receivedMessagesCount}})

              </p>
            </a>
          </li>
          <li class="nav-header">REPORTS</li>
          <li class="nav-item">
            <a href="{{route('income')}}" class="nav-link">
              <i class="nav-icon fa fa-chart-bar"></i>
              <p>
                Income Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('collectibles')}}" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
              Collectibles
              </p>
            </a>
          </li>
	  @endif
	
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  </div>
 
<!-- ./wrapper -->
