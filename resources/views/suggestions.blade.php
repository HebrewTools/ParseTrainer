<?php
use HebrewParseTrainer\Verb;

$suggestions = Verb::where('active', 0)
	->orderBy('root')
	->orderBy('tense', 'desc')
	->orderBy('number')
	->orderBy('person', 'desc')
	->orderBy('gender')
	->get();
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Current suggestions</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover table-condensed suggestions">
			<thead>
				<tr>
					<th>Verb</th>
					<th>Root</th>
					<th>Parsing</th>
					<th colspan="3">Votes</th>
				</tr>
			</thead>
			<tbody>
			@forelse($suggestions as $verb)
				<tr>
					<td class="large hebrew text-center">{{ $verb->verb }}</td>
					<td class="large hebrew text-center">{{ $verb->root }}</td>
					<td>{{ $verb->stem }} {{ $verb->tense }} {{ $verb->person }}{{ $verb->gender }}{{ $verb->number }}</td>
					<td class="vote-cell"><button data-vote="0" data-verb="{{ $verb->id }}" class="vote btn btn-{{ $verb->userVote(Auth::user()) < 0 ? 'danger' : 'default' }}">-</button></td>
					<td class="vote-cell"><span class="vote-count btn">{{ $verb->voteCount() }}</span></td>
					<td class="vote-cell"><button data-vote="1" data-verb="{{ $verb->id }}" class="vote btn btn-{{ $verb->userVote(Auth::user()) > 0 ? 'success' : 'default' }}">+</button></td>
				</tr>
			@empty
				<tr><td colspan="4">There are no active suggestions. Why not add a verb yourself?</td></tr>
			@endforelse
			</tbody>
		</table>
	</div>
</div>
