@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i><span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
		    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
        <div class="avatar av-l header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px; width: 50px; height: 50px;"> 
	</div>
<a href="#" class="user-name">{{ config('chatify.name') }}</a>    
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    @if (auth()->user()->user_type === 'tenant')
                    <a href="#" class="billing-message-link"><i class="fas fa-user-tie"></i></a>
                    <a href="/tenantprofiles"><i class="fas fa-home"></i></a>
                    @elseif (auth()->user()->user_type === 'rental_owner')
		    <a href="#" class="booking-message-link"><i class="fas fa-user"></i></a>
		    <a href="#" class="contact-link admin-link"><i class="fas fa-user-shield"></i></a>
		    <a href="/dashboard"><i class="fas fa-home"></i></a>
		    @elseif (auth()->user()->user_type === 'admin')
		    <a href="#" class="contact-link owner-link"><i class="fas fa-user-tie"></i></a>
                    <a href="#" class="contact-link user-link"><i class="fas fa-user"></i></a>
                    <a href="{{ route('contact.form') }}"><i class="fas fa-home"></i></a>
                    @endif
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el">
                    @if (auth()->user()->user_type === 'tenant')
                    <span> If you have a suggestion, important notice or important business please contact the Rental_Owner.Then Also
                        Discussing about the billing.Please search to start messaging.click icon user at the top</span>
                    @elseif (auth()->user()->user_type === 'rental_owner')
                    <span>Please search to start messaging in the Tenant click this the icon user at the top</span>
                @endif
                </p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>Users Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
    // Fetch users based on the user type directly in the Blade template
    $rentalOwners = \App\Models\User::where('user_type', 'rental_owner')->get();
    $users = \App\Models\User::where('user_type', 'tenant')->get();
    $admins = \App\Models\User::where('user_type', 'admin')->get();
    $currentUserName = Auth::user()->name; // Get the current user's name (if needed)
@endphp

@php
$bookingmessages = App\Models\BookingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->where('status', 'approaved')
				  ->get();

$billingmessages = App\Models\BillingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch billing message senders from PHP
        const billingMessageSenders = @json($billingmessages->map(function ($message) {
            return $message->sender->name ?? 'Unknown'; // Use 'Unknown' as fallback
        }));

        // Create table rows for billing message senders
        const senderRows = billingMessageSenders
            .map(senderName => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${senderName}</td></tr>`)
            .join('');

        // Generate the billing message senders table
        const senderTableHTML = `
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Rental Name</th>
                    </tr>
                </thead>
                <tbody>
                    ${senderRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">Empty.</td></tr>'}
                </tbody>
            </table>`;

        // Add click event listener for the billing message link
        const billingMessageLink = document.querySelector('.billing-message-link');
        if (billingMessageLink) {
            billingMessageLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior
                Swal.fire({
                    html: senderTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-user" style="font-size: 3rem; color: #000;"></i>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch booking message senders from PHP
        const bookingMessageSenders = @json($bookingmessages->filter(function ($message) {
            return $message->status == 'approaved'; // Filter only approved messages
        })->map(function ($message) {
            return $message->sender->name ?? 'Unknown'; // Use 'Unknown' as fallback
        }));

        // Create table rows for booking message senders
        const senderRows = bookingMessageSenders
            .map(senderName => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${senderName}</td></tr>`)
            .join('');

        // Generate the booking message senders table
        const senderTableHTML = `
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Tenant Name</th>
                    </tr>
                </thead>
                <tbody>
                    ${senderRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No tenants available.</td></tr>'}
                </tbody>
            </table>`;

        // Add click event listener for the booking message link
        const bookingMessageLink = document.querySelector('.booking-message-link');
        if (bookingMessageLink) {
            bookingMessageLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior
                Swal.fire({
                    html: senderTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-user" style="font-size: 3rem; color: #000;"></i>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Convert PHP data to JavaScript arrays
        const rentalOwners = @json($rentalOwners->pluck('name')->toArray());
        const users = @json($users->pluck('name')->toArray());
        const admins = @json($admins->pluck('name')->toArray());
        const currentUserName = @json($currentUserName);

        // Create table rows for rental owners, excluding the current user
        const rentalOwnerRows = rentalOwners
            .filter(owner => owner !== currentUserName) // Exclude current user if needed
            .map(owner => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${owner}</td></tr>`)
            .join('');

        // Create table rows for users (tenants), excluding the current user
        const userRows = users
            .filter(user => user !== currentUserName) // Exclude current user if needed
            .map(user => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${user}</td></tr>`)
            .join('');

        // Create table rows for admins
        const adminRows = admins
            .map(admin => `<tr><td style="border: 1px solid #ddd; padding: 8px;">${admin}</td></tr>`)
            .join('');

        // Create a table for rental owners
        const rentalOwnerTableHTML = `
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Contact Owner?</th>
                    </tr>
                </thead>
                <tbody>
                    ${rentalOwnerRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No rental owners available.</td></tr>'}
                </tbody>
            </table>`;

        // Create a table for tenants (users)
        const userTableHTML = `
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Contact Tenant?</th>
                    </tr>
                </thead>
                <tbody>
                    ${userRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No tenants available.</td></tr>'}
                </tbody>
            </table>`;

        // Create a table for admins
        const adminTableHTML = `
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Contact Admin?</th>
                    </tr>
                </thead>
                <tbody>
                    ${adminRows || '<tr><td style="border: 1px solid #ddd; padding: 8px;">No admins available.</td></tr>'}
                </tbody>
		</table>`;


  // Check if .all-user exists and add click event listener
        const allUserLink = document.querySelector('.all-user');
        if (allUserLink) {
            allUserLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                
                Swal.fire({
                    html: userTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-address-book" style="font-size: 3rem; color: #000;"></i>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }

        // Show rental owners when clicking on the owner link
        const ownerLink = document.querySelector('.owner-link');
        if (ownerLink) {
            ownerLink.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    html: rentalOwnerTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-address-book" style="font-size: 3rem; color: #000;"></i>
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1rem; color: #000;">Nick Intie</span>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }

        // Show tenants when clicking on the tenant link
        const userLink = document.querySelector('.user-link');
        if (userLink) {
            userLink.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    html: userTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-address-book" style="font-size: 3rem; color: #000;"></i>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }

        // Show admins when clicking on the admin link
        const adminLink = document.querySelector('.admin-link');
        if (adminLink) {
            adminLink.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    html: adminTableHTML,
                    iconHtml: `
                        <div style="position: relative; display: inline-block;">
                            <i class="fas fa-user-shield" style="font-size: 3rem; color: #000;"></i>
                        </div>`,
                    confirmButtonText: 'OK'
                });
            });
        }
    });
</script>


<script>
    // Function to check if the browser is offline
    function checkInternetConnection() {
        if (!navigator.onLine) {
            // If no internet connection, show a message
            showNoInternetMessage();
        }
    }

    // Function to show a "No Internet" message using SweetAlert2
    function showNoInternetMessage() {
        Swal.fire({
            title: 'No Internet Connection',
            text: 'Please check your connection and reload the page.',
            icon: 'warning',
            confirmButtonText: 'Reload',
            allowOutsideClick: false, // Prevents closing by clicking outside
            allowEscapeKey: false // Prevents closing by using the escape key
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Reload the page on confirmation
            }
        });
    }

    // Initial check on page load
    checkInternetConnection();

    // Listen for offline events
    window.addEventListener('offline', showNoInternetMessage);
</script>

