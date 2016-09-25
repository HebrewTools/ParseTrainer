<?php
use HebrewParseTrainer\Root;
use HebrewParseTrainer\Stem;
use HebrewParseTrainer\Tense;
?>

@extends('layouts.with_sidebar')

@section('sidebar')
<form id="hebrewparsetrainer-settings">
	<div class="form-group">
		<h3>Stems</h3>
		@foreach (Stem::all() as $stem)
			<div class="checkbox">
				<label><input class="reload-verb" type="checkbox" name="stem" value="{{{ $stem->name }}}" checked="checked"/> {{{ $stem->name }}}</label>
			</div>
		@endforeach
	</div>

	<div class="form-group">
		<h3>Tenses</h3>
		@foreach (Tense::all() as $tense)
			<div class="checkbox">
				<label><input class="reload-verb" type="checkbox" name="tense" value="{{{ $tense->name }}}" checked="checked"/> {{{ $tense->name }}}</label>
			</div>
		@endforeach
	</div>

	<div class="form-group">
		<h3>Roots</h3>
		<select name="root" class="reload-verb form-control hebrew ltr" multiple="multiple">
		@foreach (Root::orderBy('root_kind_id')->get() as $root)
			@if ($root->verbs()->where('active', 1)->count() > 0)
					<option value="{{{ $root->root }}}" selected="selected">{{{ $root->root }}} ({{{ $root->kind->name }}})</option>
			@endif
		@endforeach
		</select>
	</div>

	<div class="form-group">
		<h3>Settings</h3>
		<div class="checkbox">
			<label><input type="checkbox" id="settings-audio" checked="checked"/> Audio</label>
		</div>
	</div>
</form>
@endsection

@section('content')
<div id="trainer">
	<div id="trainer-input-container">
		<p class="bg-danger" id="trainer-404">There are no verbs matching the criteria in our database.</p>
		<p class="lead"><span class="hebrew hebrew-large" id="trainer-verb"></span><span id="trainer-answer"></span></p>
	</div>
	<div id="trainer-input-fancy"></div>
	<div class="text-muted">
		<div id="trainer-input-help">
			<p>Parse the verb and enter the answer as described below. Press return. If your answer was correct and there are multiple possible parsings, an extra input field will appear. After the first incorrect answer or after entering all possible answers, you can continue to the next verb by pressing return once more.</p>
			<p>
				<strong>Stems</strong>: either use the full name or a significant beginning (i.e. <code>Q</code> for Qal but <code>Pi</code> for Piel rather than <code>P</code>).<br/>
				<strong>Tenses</strong>: use the abbreviations <code>pf</code>, <code>ipf</code>, <code>coh</code>, <code>imp</code>, <code>jus</code>, <code>infcs</code>, <code>infabs</code>, <code>pta</code> and <code>ptp</code>.<br/>
				<strong>Person</strong>: <code>1</code>, <code>2</code>, <code>3</code> or none (infinitives and participles).<br/>
				<strong>Gender</strong>: <code>m</code>, <code>f</code> or none (infinitives).<br/>
				<strong>Number</strong>: <code>s</code>, <code>p</code> or none (infinitives).
			</p>
			<p><strong>Examples</strong>: <code>Q pf 3ms</code>, <code>ni pta fp</code>, <code>pi infabs</code>.</p>
			<p>You can also use the buttons to enter your answer. This is an experimental feature.</p>
		</div>
		<button type="button" class="btn btn-default btn-xs" id="show-hide-help">Show help</button>
	</div>
</div>

<hr/>

<div class="row">
	<div class="col-md-6">
		@include('user.top')
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Contribute!</h3>
			</div>
			<div class="panel-body">
				<p>If this app is useful to you, please consider <a href="{{ url('/contribute') }}">contributing</a> by adding more verbs to the database!</p>
				@if(!Auth::check())
					<a class="btn btn-success" href="{{ url('/register') }}">Sign up</a>
					or <a href="{{ url('/login') }}">login</a>
				@endif
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var reload_on_load = true;
</script>
@endsection
