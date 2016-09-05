<?php
use HebrewParseTrainer\RootKind;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Add a new root</h3>
	</div>
	<div class="panel-body">
		<form id="add-root">
			<div class="alerts"></div>
			<div class="form-group">
				<label for="add-root-root">Root</label>
				<input type="text" class="form-control" id="add-root-root" name="root" placeholder="קטל"/>
			</div>
			<div class="form-group">
				<label for="add-root-kind">Kind</label>
				<select id="add-root-kind" class="form-control" name="root_kind_id">
					@foreach(RootKind::all() as $kind)
						<option value="{{ $kind->id }}">{{{ $kind->name }}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Add</button>
			</div>
		</form>
	</div>
</div>
