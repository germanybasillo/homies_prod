
<!-- resources/views/messages/create.blade.php -->

<h1>Send a Message</h1>

<form action="{{ route('messages.store') }}" method="POST">
    @csrf

    <!-- Recipient selection -->
    <div>
        <label for="receiver_id">Select a recipient:</label>
        <select name="receiver_id" id="receiver_id">
            <option value="" disabled selected>Select a user</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Message content -->
    <div>
        <label for="content">Message:</label>
        <textarea name="content" id="content" placeholder="Write your message..."></textarea>
    </div>

    <button type="submit">Send Message</button>
</form>
