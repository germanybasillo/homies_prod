
<!-- resources/views/messages/index.blade.php -->

<h1>Your Messages</h1>

@foreach($messages as $message)
    <div>
        <strong>{{ $message->sender->name }}:</strong>
        <p>{{ $message->content }}</p>
        <small>{{ $message->created_at->diffForHumans() }}</small>
    </div>
@endforeach
