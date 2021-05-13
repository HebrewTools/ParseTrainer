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
<script src="//code.highcharts.com/stock/highstock.js"></script>

<script type="text/javascript">
	$('#random-requests').highcharts('StockChart', {
		chart: {
			type: 'column',
			zoomType: 'x'
		},
		credits: { enabled: false },
		xAxis: { ordinal: false },
		yAxis: [
			{
				min: 0,
				title: { text: 'Requests' },
				opposite: false
			}, {
				min: 0,
				title: { text: 'Unique visitors' },
				opposite: true
			}
		],
		rangeSelector: {
			buttons: [
				{type: 'week',  count: 1, text: '1w'},
				{type: 'month', count: 1, text: '1m'},
				{type: 'month', count: 3, text: '3m'},
				{type: 'year',  count: 1, text: '1y'},
				{type: 'all',             text: 'All'}
			],
			selected: 3
		},
		plotOptions: {
			column: {
				dataGrouping: {
					groupPixelWidth: 80,
					units: [
						['day',   [1]],
						['week',  [1]],
						['month', [1]],
						['month', [3]],
						['year',  [1]]
					]
				},
				pointPadding: 0.02,
				groupPadding: 0.02
			},
			series: {
				dataGrouping: {
					approximation: 'sum'
				}
			}
		},
		tooltip: { pointFormat: '<b>{point.y}</b> requests<br>' },
		series: [
			{
				name: 'Requests',
				data: {{ $stats['requests'] }}
			},
			{
				type: 'spline',
				yAxis: 1,
				name: 'Unique visitors',
				data: {{ $stats['unique-ips'] }},
				tooltip: { pointFormat: '<b>{point.y}</b> unique visitors' },
			}
		]
	});
</script>
@endsection
