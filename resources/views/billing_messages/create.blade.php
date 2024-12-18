
<!-- resources/views/billing_messages/create.blade.php -->

<h1>Send a Billing Message</h1>

<form action="{{ route('billing_messages.store') }}" method="POST">
    @csrf

    <!-- Recipient selection -->
    <div>
        <label for="receiver_id">Select Recipient:</label>
        <select name="receiver_id" id="receiver_id">
            <option value="" disabled selected>Select a user</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Message content -->
    <div>
        <label for="content">Message Content:</label>
        <textarea name="content" id="content" required></textarea>
    </div>

    <!-- Message name (e.g., service name) -->
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
    </div>

    <!-- Price -->
    <div>
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>
    </div>

    <button type="submit">Send Message</button>
</form>
