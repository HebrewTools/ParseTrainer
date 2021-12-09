<?php
use HebrewParseTrainer\Root;
use HebrewParseTrainer\Stem;
use HebrewParseTrainer\Tense;
?>

@extends('layouts.with_sidebar')

@section('sidebar')
<form id="hebrewparsetrainer-settings">
	<input type="hidden" id="csrf" value="{{ csrf_token() }}"/>

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
		@foreach (Root::orderBy('root_kind_id')->orderBy('root')->get() as $root)
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
		<div> <!--  id="trainer-input-help" -->
			<p>Parse the verb and enter the answer as described below or using the buttons. Press return. If your answer was correct and there are multiple possible parsings, an extra input field will appear. After the first incorrect answer or after entering all possible answers, you can continue to the next verb by pressing return once more.</p>
			<p>
				<strong>Stems</strong>: either use the full name or a significant beginning (i.e. <code>Q</code> for Qal and <code>N</code>, <code>Pi</code>, <code>Pu</code>, <code>Hit</code>, <code>Hip</code>, and <code>Hop</code> for the derived stems).<br/>
				<strong>Tenses</strong>: use the abbreviations <code>pf</code>, <code>ipf</code>, <code>coh</code>, <code>imp</code>, <code>jus</code>, <code>infcs</code>, <code>infabs</code>, <code>ptc</code> and <code>ptcp</code>.<br/>
				<strong>Person</strong>: <code>1</code>, <code>2</code>, <code>3</code> or none (infinitives and participles).<br/>
				<strong>Gender</strong>: <code>m</code>, <code>f</code> or none (infinitives).<br/>
				<strong>Number</strong>: <code>s</code>, <code>p</code> or none (infinitives).
			</p>
			<p>Examples: <code>Q pf 3ms</code>, <code>ni ptc fp</code>, <code>pi infabs</code>.</p>
			<h5>Notes:</h5>
			<ul>
				<li>There is no 'common' gender. Instead, enter the masculine and feminine forms separately. The <code>N/A</code> option is for infinitives.</li>
				<li>The <code>ptcp</code> option is only for the passive participle of the qal. All other participles should be entered with <code>ptc</code> (including participles of the passive stems).</li>
			</ul>
		</div>
		<button type="button" class="btn btn-default btn-xs" id="show-hide-help">Show help</button>
	</div>
</div>

<hr/>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">About</h3>
			</div>
			<div class="panel-body">
				<p>&copy; 2015&ndash;{!! date('y') !!} <a href="https://camilstaps.nl">Camil Staps</a>. Licensed under <a href="http://www.gnu.org/licenses/gpl-3.0.en.html">GPL 3.0</a>. Source is on <a href="https://github.com/HebrewTools/ParseTrainer">GitHub</a>.</p>
				<p>Please report any mistakes to <a href="mailto:info@camilstaps.nl">info@camilstaps.nl</a>.</p>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var reload_on_load = true;
</script>
@endsection
