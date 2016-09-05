@extends('layouts.master')

@section('master-content')
<p class="lead">
	Thank you for wanting to help out! To expand our database, we are looking for volunteers to enter more verbs.
</p>

@if(!Auth::check())
	<a class="btn btn-lg btn-primary" href="{{ env('APP_URL') }}contribute?login=yes">Login</a>
	<a class="btn btn-lg btn-success" href="{{ env('APP_URL') }}user/create">Sign up</a>
@endif

<h3>Here's how it works:</h3>

<ul>
	<li>Any user can <em>suggest new verbs</em>.</li>
	<li>These have to be <em>peer-reviewed</em> by other contributors.</li>
	<li>It has to get <em>five</em> votes to be accepted.</li>
	<li>Contributors <em>earn points</em> for all accepted verbs they suggested.</li>
	<li>The <em>vote weight</em> is dependent on the number of points a user has.</li>
</ul>

@if(Auth::check())
	<hr/>
	<div class="row">
		<div class="col-lg-6">
			@include('suggestions')
		</div>
		<div class="col-lg-6">
			@include('suggest')
		</div>
		<div class="col-lg-6">
			@include('add_root')
		</div>
	</div>
@endif

@endsection
