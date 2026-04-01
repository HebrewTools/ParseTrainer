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
	'More languages' => [
		'Biblical Hebrew' => 'https://parse.hebrewtools.org',
		'Geʽez' => 'https://mitanim-parsing-trainer-ethiopic.linguistik.uzh.ch',
	],
];

if (Auth::check()) {
	$menu['Contribute'] = 'contribute';
	$menu['Statistics'] = 'stats';
}

function buildMenu($menu, $activePage, $level = 0) {
	$res = '';
	if ($level == 0)
		$res .= '<nav><ul class="nav nav-pills pull-right">';
	else
		$res .= '<ul class="dropdown-menu">';

	foreach ($menu as $name => $contents) {
		if (is_array($contents)) {
			$res .= '<li role="presentation" class="dropdown">';
			$res .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
			$res .= $name . ' <span class="caret"></span>';
			$res .= '</a>';
			$res .= buildMenu($contents, $activePage, $level + 1);
			$res .= '</li>';
		} else {
			$active = str_starts_with($contents, 'https://') ? Request::schemeAndHttpHost() == $contents : Request::is($contents);
			$res .= '<li role="presentation" class="' . ($active ? 'active' : '') . '">';
			$res .= '<a href="' . url($contents) . '">' . $name . '</a>';
			$res .= '</li>';
		}
	}

	if ($level == 0 && Auth::check()) {
		$res .= '<li role="presentation"><a href="' . url('/logout') . '" onclick="event.preventDefault();document.getElementById(\'logout-form\').submit();">Logout</a></li>';
	}

	$res .= '</ul>';
	if ($level == 0)
		$res .= '</nav>';

	return $res;
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
				{!! buildMenu($menu, $activePage) !!}
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
