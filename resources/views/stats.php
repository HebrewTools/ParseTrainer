<!DOCTYPE html>
<!--
HebrewParseTrainer - practice Hebrew verbs
Copyright (C) 2015  Camil Staps <info@camilstaps.nl>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HebrewParseTrainer statistics</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="public/css/hebrewparsetrainer.css">
</head>
<body role="application">
<div class="container" role="main">
    <div class="page-header">
        <h1>HebrewParseTrainer statistics</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="statistics" style="height:400px;"></div>
        </div>
    </div>
</div>

<?php
use \HebrewParseTrainer\RandomLog;

$db_stats = RandomLog
    ::select(DB::raw('COUNT(*) as count'), 'created_at')
    ->groupBy(DB::raw('DAY(created_at)'))
    ->orderBy('created_at')
    ->get();

$stats = [];
foreach ($db_stats as $stat) {
    $stats[] = "[Date.UTC" . date("(Y,n-1,d)", strtotime($stat->created_at)) . "," . $stat->count . "]";
}
$stats = "[" . implode(",", $stats) . "]";
?>

<script src="vendor/components/jquery/jquery.min.js"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="public/js/hebrewparsetrainer.js"></script>

<script type="text/javascript">
    $('#statistics').highcharts({
        chart: { type: 'column', zoomType: 'x' },
        title: { text: 'Requests per day' },
        xAxis: { type: 'datetime' },
        yAxis: {
            min: 0,
            title: { text: 'Requests' }
        },
        tooltip: { pointFormat: '<b>{point.y}</b> requests' },
        series: [
            {
                name: 'Requests',
                data: <?=$stats?>
            }
        ]
    });
</script>
</body>
</html>
