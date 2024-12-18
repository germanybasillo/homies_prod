<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS</title>
</head>
<body>
    <h1>Send SMS</h1>

    @if (session('status'))
        <div style="color: green;">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

  

<form action="{{ route('send.sms') }}" method="POST" onsubmit="formatPhoneNumber()">
    @csrf
    <div>
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        
        @error('phone')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="message">Message</label>
        <textarea id="message" name="message">{{ old('message') }}</textarea>
        
        @error('message')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Send SMS</button>
</form>

<script>
    function formatPhoneNumber() {
        var phoneInput = document.getElementById('phone');
        var phoneValue = phoneInput.value.trim();

        // Check if the phone number starts with 09 (local format)
        if (phoneValue.startsWith('09') && phoneValue.length === 11) {
            phoneInput.value = '+63' + phoneValue.substring(1); // Replace the 0 with +63
        }
    }
</script>




</body>
</html>

