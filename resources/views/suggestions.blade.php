<?php
use HebrewParseTrainer\Verb;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Current suggestions</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover table-condensed suggestions">
			<tr>
				<th>Verb</th>
				<th>Root</th>
				<th>Parsing</th>
				<th>Votes</th>
			</tr>
			@forelse(Verb::where('active', 0)->orderBy('verb')->get() as $verb)
				<tr>
					<td class="large">{{ $verb->verb }}</td>
					<td class="large">{{ $verb->root }}</td>
					<td>{{ $verb->stem }} {{ $verb->tense }} {{ $verb->person }}{{ $verb->gender }}{{ $verb->number }}</td>
					<td>
						<button data-vote="0" data-verb="{{ $verb->id }}" class="vote btn btn-{{ $verb->userVote(Auth::user()) < 0 ? 'danger' : 'default' }}">-</button>
						<span class="vote-count btn">{{ $verb->voteCount() }}</span>
						<button data-vote="1" data-verb="{{ $verb->id }}" class="vote btn btn-{{ $verb->userVote(Auth::user()) > 0 ? 'success' : 'default' }}">+</button>
					</td>
				</tr>
			@empty
				<tr><td colspan="4">There are no active suggestions. Why not add a verb yourself?</td></tr>
			@endforelse
		</table>
	</div>
</div>
