@extends('layouts.master')

@section('master-content')

@if(Auth::check())
	@include('shared.already_logged_in')
@else
	@include('shared.messages')

	<form method="post">
		<div class="form-group">
			<label for="create-user-email">Email address</label>
			<input type="email" class="form-control" id="create-user-email" placeholder="Email" name="email" value="{{{ $form['email'] }}}"/>
		</div>
		<div class="form-group">
			<label for="create-user-name">Username</label>
			<input type="text" class="form-control" id="create-user-name" placeholder="Username" name="name" value="{{{ $form['name'] }}}"/>
		</div>
		<div class="form-group">
			<label for="create-user-pw1">Password</label>
			<input type="password" class="form-control" id="create-user-pw1" placeholder="Password" name="password"/>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" id="create-user-pw2" placeholder="Password (confirmation)" name="password_confirmation"/>
		</div>
		<button type="submit" class="btn btn-primary">Create account</button>
	</form>
@endif

@endsection
