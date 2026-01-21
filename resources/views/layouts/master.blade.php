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
		<div class="container">
			<div class="alert alert-danger" role="alert">
				<p>
					If you are in the USA, please read up about the effects of the Trump administration on higher education.
					Some places to start:
					<a class="alert-link" href="https://www.nytimes.com/2025/04/14/us/politics/trump-pressure-universities.html" target="_blank">one</a>;
					<a class="alert-link" href="https://www.theguardian.com/commentisfree/2025/mar/17/trump-us-path-educational-authoritarianism" target="_blank">two</a>.
					The USA <a class="alert-link" href="https://theconversation.com/us-swing-toward-autocracy-doesnt-have-to-be-permanent-but-swinging-back-to-democracy-requires-vigilance-stamina-and-elections-250383" target="_blank">is quickly falling into autocracy</a>.
				</p>
			</div>
			<div class="alert alert-{{ Donation::thisMonthAmountEur() >= Donation::DESIRED_AMOUNT ? 'info' : 'warning' }}" role="alert">
				<p>
					This app is being used by more and more people, which is great.
					But server costs are growing due to traffic and price increases.
					I'd like to keep this app available to all.
					If you can, please consider
					<a class="alert-link" href="https://whydonate.com/donate/hebrewtools-donations" target="_blank">donating</a>.
					We need about €{{ Donation::DESIRED_AMOUNT }} per month, and have reached €{{ preg_replace('/\\.0*$/', '', number_format(Donation::thisMonthAmountEur(), 2)) }} this month so far.
				</p>
			</div>
		</div>
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
