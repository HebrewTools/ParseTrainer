<?php
use HebrewParseTrainer\RootKind;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Add a new root</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="add-root">
			<div class="alerts"></div>
			<div class="form-group">
				<label for="add-root-root" class="col-sm-2 control-label">Root</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="add-root-root" name="root" placeholder="קטל"/>
				</div>
			</div>
			<div class="form-group">
				<label for="add-root-kind" class="col-sm-2 control-label">Kind</label>
				<div class="col-sm-10">
					<select id="add-root-kind" class="form-control" name="root_kind_id">
						@foreach(RootKind::all() as $kind)
							<option value="{{ $kind->id }}">{{{ $kind->name }}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</div>
		</form>
	</div>
</div>
