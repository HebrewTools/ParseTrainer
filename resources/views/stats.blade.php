<?php
use \HebrewParseTrainer\RandomLog;

$db_stats = RandomLog
	::select(DB::raw('COUNT(*) as count'), 'created_at')
	->groupBy(DB::raw('DATE(created_at)'))
	->orderBy('created_at')
	->get();

$stats = [];
foreach ($db_stats as $stat) {
	$stats[] = "[Date.UTC" . date("(Y,n-1,j)", strtotime($stat->created_at)) . "," . $stat->count . "]";
}
$stats = "[" . implode(",", $stats) . "]";
?>

@extends('layouts.master')

@section('master-content')
<div class="row">
	<div class="col-md-12">
		<div id="statistics" style="height:400px;"></div>
	</div>
</div>

<script src="{{ url("/vendor/components/jquery/jquery.min.js") }}"></script>
<script src="{{ url("/vendor/twbs/bootstrap/dist/js/bootstrap.min.js") }}"></script>
<script src="//code.highcharts.com/stock/highstock.js"></script>
<script src="{{ url("/public/js/hebrewparsetrainer.js") }}"></script>

<script type="text/javascript">
	$('#statistics').highcharts('StockChart', {
		chart: {
			type: 'column',
			zoomType: 'x'
		},
		credits: { enabled: false },
		title: { text: 'Random verb requests' },
		xAxis: { ordinal: false },
		yAxis: {
			min: 0,
			title: { text: 'Requests' },
			opposite: false
		},
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
		plotOptions: { column: {
			dataGrouping: {
				groupPixelWidth: 100,
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
		} },
		tooltip: { pointFormat: '<b>{point.y}</b> requests' },
		series: [
			{
				name: 'Requests',
				data: {{ $stats }}
			}
		]
	});
</script>
@endsection
