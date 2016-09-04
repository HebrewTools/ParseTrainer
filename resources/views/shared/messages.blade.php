@if(isset($messages))
@foreach($messages as $message)
	<div class="alert alert-{{{ $message[0] }}}" role="alert">{{{ $message[1] }}}</div>
@endforeach
@endif
