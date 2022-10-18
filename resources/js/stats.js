require('highcharts/highstock');

(() => {
let groupPixelWidth = 100;
let units = [
	['day',   [1]],
	['week',  [1]],
	['month', [1, 3]],
	['year',  [1]]
];

window.makeStatsChart = function (requests, visitors) {
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
					groupPixelWidth: groupPixelWidth,
					units: units
				},
				pointPadding: 0.02,
				groupPadding: 0.02
			},
			series: {
				dataGrouping: {
					groupPixelWidth: groupPixelWidth,
					approximation: 'sum',
					units: units
				}
			}
		},
		tooltip: { pointFormat: '<b>{point.y}</b> requests<br>' },
		series: [
			{
				name: 'Requests',
				data: requests
			},
			{
				type: 'spline',
				yAxis: 1,
				name: 'Unique visitors',
				data: visitors,
				tooltip: { pointFormat: '<b>{point.y}</b> unique visitors' },
			}
		]
	});
};
})();
