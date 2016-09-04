@extends('layouts.master')

@section('master-content')
<div class="row">
	<div class="col-md-2 col-xs-4">
		@yield('sidebar')

		<h3>About</h3>
		<p>&copy; 2015-16 <a href="https://camilstaps.nl">Camil Staps</a>. Licensed under <a href="http://www.gnu.org/licenses/gpl-3.0.en.html">GPL 3.0</a>. Source is on <a href="https://github.com/HebrewTools/ParseTrainer">GitHub</a>.</p>
		<p>Please report any mistakes to <a href="mailto:info@camilstaps.nl">info@camilstaps.nl</a>.</p>
	</div>
	<div class="col-md-10 col-xs-8">
		@yield('content')
	</div>
</div>
@endsection
