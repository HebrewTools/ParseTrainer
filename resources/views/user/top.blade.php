<?php
use HebrewParseTrainer\User;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Top users</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Points</th>
				</tr>
			</thead>
			<tbody>
			@foreach(User::orderBy('points', 'desc')->take(10)->get() as $user)
				<tr>
					<td><img src="https://gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}?s=40"/></td>
					<td>{{{ $user->name }}}</td>
					<td>{{{ $user->points }}}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
