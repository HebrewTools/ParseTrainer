<?php
use HebrewParseTrainer\Root;
use HebrewParseTrainer\Stem;
use HebrewParseTrainer\Tense;
use HebrewParseTrainer\Verb;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Suggest a new verb</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="suggest">
			<div class="alerts"></div>
			<div class="form-group">
				<label for="suggest-verb" class="col-sm-2 control-label">Verb</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="suggest-verb" name="verb" placeholder="קָטַל"/>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-root" class="col-sm-2 control-label">Root</label>
				<div class="col-sm-10">
					<select id="suggest-root" class="form-control" name="root">
						@foreach(Root::all() as $root)
							<option value="{{ $root->root }}">{{{ $root->root }}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-stem" class="col-sm-2 control-label">Stem</label>
				<div class="col-sm-10">
					<select id="suggest-stem" class="form-control" name="stem">
						@foreach(Stem::orderBy('id')->get() as $stem)
							<option value="{{ $stem->name }}">{{{ $stem->name }}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-tense" class="col-sm-2 control-label">Tense</label>
				<div class="col-sm-10">
					<select id="suggest-tense" class="form-control" name="tense">
						@foreach(Tense::all() as $tense)
							<option value="{{ $tense->name }}">{{{ $tense->abbreviation }}}: {{{ $tense->name }}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-person" class="col-sm-2 control-label">Person</label>
				<div class="col-sm-10">
					<select id="suggest-person" class="form-control" name="person">
						<option value="">(none)</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-gender" class="col-sm-2 control-label">Gender</label>
				<div class="col-sm-10">
					<select id="suggest-gender" class="form-control" name="gender">
						<option value="">(none)</option>
						<option value="m">masculine</option>
						<option value="f">feminine</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="suggest-number" class="col-sm-2 control-label">Number</label>
				<div class="col-sm-10">
					<select id="suggest-number" class="form-control" name="number">
						<option value="">(none)</option>
						<option value="s">singular</option>
						<option value="p">plural</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Suggest</button>
				</div>
			</div>
		</form>
	</div>
</div>
