<?php
use \HebrewParseTrainer\RandomLog;

$db_stats = RandomLog
	::select(
		DB::raw('COUNT(*) as count'),
		DB::raw('DATE(created_at) as created_at'))
	->groupBy(DB::raw('DATE(created_at)'))
	->orderBy('created_at')
	->get();

$stats['requests'] = [];
$last_date = null;
foreach ($db_stats as $stat) {
	$date = strtotime($stat->created_at);
	while ($last_date != null && $last_date + 86400 < $date) {
		$last_date += 86400;
		$stats['requests'][] = "[Date.UTC" . date("(Y,n-1,j)", $last_date) . ",0]";
	}
	$stats['requests'][] = "[Date.UTC" . date("(Y,n-1,j)", $date) . "," . $stat->count . "]";
	$last_date = $date;
}
$stats['requests'] = "[" . implode(",", $stats['requests']) . "]";

$db_stats = RandomLog
	::select(
		DB::raw('COUNT(DISTINCT `ip`) as count'),
		DB::raw('DATE(created_at) as created_at'))
	->groupBy(DB::raw('DATE(created_at)'))
	->orderBy('created_at')
	->get();

$stats['unique-ips'] = [];
$last_date = null;
foreach ($db_stats as $stat) {
	$date = strtotime($stat->created_at);
	while ($last_date != null && $last_date + 86400 < $date) {
		$last_date += 86400;
		$stats['unique-ips'][] = "[Date.UTC" . date("(Y,n-1,j)", $last_date) . ",0]";
	}
	$stats['unique-ips'][] = "[Date.UTC" . date("(Y,n-1,j)", $date) . "," . $stat->count . "]";
	$last_date = $date;
}
$stats['unique-ips'] = "[" . implode(",", $stats['unique-ips']) . "]";
?>

@extends('layouts.master')

@section('master-content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Random verb requests</h3>
			</div>
			<div class="panel-body">
				<div id="random-requests" style="height:400px;"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('master-scripts')
<script src="{{ asset('js/stats.js') }}"></script>

<script>
	makeStatsChart({{ $stats['requests'] }}, {{ $stats['unique-ips'] }});
</script>
@endsection
