<!DOCTYPE html>
<!--
HebrewParseTrainer - practice Hebrew verbs
Copyright (C) 2015-2026  Camil Staps <info@camilstaps.nl>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 -->
<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use HebrewParseTrainer\Donation;

$activePage = isset($activePage) ? $activePage : '';
$menu = [
	'Train' => ['/', ''],
];

if (Auth::check()) {
	$menu['Contribute'] = ['contribute', 'contribute'];
	$menu['Statistics'] = ['stats', 'stats'];
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="csrf-token" content="{{ csrf_token() }}"/>

		<title>ParseTrainer</title>

		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>
		<link rel="stylesheet" href="{{ asset('css/hebrewparsetrainer.css') }}"/>

		<script type="text/javascript">
			var app_url = '{{ env('APP_URL') }}';
		</script>
	</head>
	<body role="application">
		<div class="container" role="main">
			<div class="header clearfix">
				<nav>
					<ul class="nav nav-pills pull-right">
						@foreach($menu as $name => $link)
							<li role="presentation" class="{{ Request::is($link[0]) ? 'active' : '' }}"><a href="{{ url($link[1]) }}">{{ $name }}</a></li>
						@endforeach
						@if(Auth::check())
							<li role="presentation"><a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
						@endif
					</ul>
				</nav>
				<h2 class="text-muted"><a href="{{ url('/') }}">ParseTrainer</a></h2>
			</div>

			@yield('master-content')
		</div>

		<script src="{{ asset('js/app.js') }}"></script>
		@if(Auth::check())
			<script src="{{ asset('js/moderators.js') }}"></script>

			<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display:none;">
				{{ csrf_field() }}
			</form>
		@endif

		@yield('master-scripts')
	</body>
</html>
