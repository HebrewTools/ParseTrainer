@extends('layouts.master')

@section('master-content')
<div class="row">
	<div class="col-md-2 col-xs-4">
		@yield('sidebar')
	</div>
	<div class="col-md-10 col-xs-8">
		@yield('content')
	</div>
</div>
@endsection
