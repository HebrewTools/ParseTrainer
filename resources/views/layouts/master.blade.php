<!DOCTYPE html>
<!--
HebrewParseTrainer - practice Hebrew verbs
Copyright (C) 2015  Camil Staps <info@camilstaps.nl>

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

$activePage = isset($activePage) ? $activePage : '';
$menu = [
	'Train' => ['/', ''],
	'Contribute' => ['contribute', 'contribute'],
];

if (Auth::check()) {
	$menu['Statistics'] = ['stats', 'stats'];
	$menu['Logout'] = ['logout', 'logout'];
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ParseTrainer</title>
		<link rel="stylesheet" href="{{ env('APP_URL') }}vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}public/css/hebrewparsetrainer.css">

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
							<li role="presentation" class="{{ Request::is($link[0]) ? 'active' : '' }}"><a href="{{ env('APP_URL') }}{{ $link[1] }}">{{ $name }}</a></li>
						@endforeach
					</ul>
				</nav>
				<h2 class="text-muted"><a href="{{ env('APP_URL') }}">ParseTrainer</a></h2>
			</div>

			@yield('master-content')
		</div>

		<script src="{{ env('APP_URL') }}vendor/components/jquery/jquery.min.js"></script>
		<script src="{{ env('APP_URL') }}vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="{{ env('APP_URL') }}public/js/alerts.js"></script>
		<script src="{{ env('APP_URL') }}public/js/hebrewparsetrainer.js"></script>
		@if(Auth::check())
			<script src="{{ env('APP_URL') }}public/js/moderators.js"></script>
		@endif
	</body>
</html>
