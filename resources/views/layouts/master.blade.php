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
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ParseTrainer</title>
		<link rel="stylesheet" href="{{ env('APP_URL') }}vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ env('APP_URL') }}public/css/hebrewparsetrainer.css">
	</head>
	<body role="application">
		<div class="container" role="main">
			<div class="page-header">
				<h1>ParseTrainer</h1>
			</div>

			@yield('master-content')
		</div>

		<script src="{{ env('APP_URL') }}vendor/components/jquery/jquery.min.js"></script>
		<script src="{{ env('APP_URL') }}vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="{{ env('APP_URL') }}public/js/hebrewparsetrainer.js"></script>
	</body>
</html>
