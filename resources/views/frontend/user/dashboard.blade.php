@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
    <h2>Dashboard</h2>
    <p>Total Users: {{ $userCount }}</p>
    <p>User Types</p>
    <!--pie chart-->
    <html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'User Type');
                data.addColumn('number', 'Count');

                // fill data array with user types and values
                var userCountByType = {!! json_encode($userCountByType) !!};
                for (var userType in userCountByType) {
                    data.addRow([userType, userCountByType[userType]]);
                }
                var options = {
                    title: 'User Types'
                };

                // Instantiate and draw the pie chart
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </body>
    </html>
    <p>User Count by Type</p>
    <ul>
        @foreach($userCountByType as $type => $count)
            <li>{{ $type }}: {{ $count }}</li>
        @endforeach
    </ul>
    <!--bar chart-->
    <html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Date', 'Count'],
                    @foreach($usersByDate as $date => $count)
                        ['{{ $date }}', {{ $count }}],
                    @endforeach
                ]);

                var options = {
                    chart: {
                        title: 'Users Registered by Date',
                        subtitle: 'Number of users registered on each date',
                    },
                    bars: 'horizontal' // Required for Material Bar Charts.
                };

                var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
    </head>
    <body>
        <div id="barchart_material" style="width: 900px; height: 500px;"></div>
    </body>
    </html>




            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
