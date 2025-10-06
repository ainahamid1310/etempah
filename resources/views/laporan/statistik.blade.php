@extends('layouts.backend_admin')

@section('css')
@endsection

@section('js_themes')
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="/global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
    <script src="/global_assets/js/demo_pages/fullcalendar_basic.js"></script>

    <script>
        var dalam_proses = @json($statusPie['dalam_proses']);
        var lulus = @json($statusPie['lulus']);
        var tolak = @json($statusPie['tolak']);
        var batal = @json($statusPie['batal']);
    </script>

    <script src="/global_assets/js/demo_charts/echarts/light/pies/pie_basic.js"></script>
    <script src="/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>
    <script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="/global_assets/js/plugins/visualization/c3/c3.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>

    {{-- bar charts --}}


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    {{-- <script>
        var nama = @json($data['nama']);
        var jumlah = @json($data['jumlah']);
    </script> --}}

    {{-- <script src="/global_assets/js/demo_charts/c3/c3_bars_pies.js"></script> --}}
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Laporan Statistik</span>

    </div>
@endsection

@section('content')
	<div class="card">

    <div class="text-center">
        <div class="card-header bg-light header-elements-inline">
            <h5 class="card-title">Tempahan {{ now()->year }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="row">

        <div class="col-lg-3">

                <div class="card border-y-2 border-top-green-300 border-bottom-green-600 rounded-0 alpha-success">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0">{{ $status['jumlah'] }}</h2>
                            <div class="list-icons ml-auto">
                                <i class="icon-sigma"></i>
                            </div>
                        </div>

                        <div>
                            Jumlah Permohonan
                            {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                        </div>
                    </div>

                    <div class="chart" id="today-revenue"></div>
                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-y-2 border-top-pink-300 border-bottom-pink-600 rounded-0 alpha-danger">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0">{{ $status['baru'] }}</h2>
                            <div class="list-icons ml-auto">
                                <i class="icon-new"></i>
                            </div>
                        </div>

                        <div>
                            Permohonan Baru
                            {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                        </div>
                    </div>

                    <div class="chart" id="today-revenue"></div>
                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-y-2 border-top-blue-300 border-bottom-blue-600 rounded-0 alpha-primary">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0">{{ $status['dalam_proses'] }}</h2>
                            <div class="list-icons ml-auto">
                                <i class="icon-hour-glass2"></i>
                            </div>
                        </div>

                        <div>
                            Dalam Proses
                            {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                        </div>
                    </div>

                    <div class="chart" id="today-revenue"></div>
                </div>

            </div>

            <div class="col-lg-3">

                <div class="card border-y-3 border-top-orange-300 border-bottom-orange-600 rounded-0 alpha-orange">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0">{{ $status['selesai'] }}</h2>
                            <div class="list-icons ml-auto">
                                <i class="icon-archive"></i>
                            </div>
                        </div>

                        <div>
                            Selesai
                            {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                        </div>
                    </div>

                    <div class="chart" id="today-revenue"></div>
                </div>

            </div>

        </div>
        <!-- /quick stats boxes -->

    </div>

</div>
	    <div class="row">
        <div class="col-md-6">
            <!-- Simple interaction -->
            <div class="card">
                <div class="card-header header-elements-inline alpha-success">
                    <h5 class="card-title">5 Tempahan Bilik Tertinggi</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="chart-container">
                        {{-- <div class="chart" id="c3-bar-chart"></div> --}}
                        <div class="chart" style="height:400px;" id="barchart_material"></div>
                    </div>
                </div>
            </div>
            <!-- /simple interaction -->
        </div>

        <div class="col-md-6">
            <!-- Basic pie -->
            <div class="card">
                <div class="card-header header-elements-inline alpha-success">
                    <h5 class="card-title">Statistik Kelulusan Pemohon</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="pie_basic"></div>

                    </div>

                </div>
                {{-- <input type="text" name="" id="dalam_proses_id" value="{{ $dalam_proses }}"> --}}
            </div>
            {{-- <!-- /basic pie --> @php dd($charts); @endphp --}}
        </div>

    </div>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Nama Bilik', 'Jumlah'],

                @php
                    foreach ($barcharts as $order) {
                        echo "['" . $order->nama . "', " . $order->jumlah . '],';
                    }

                @endphp
            ]);



            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                    is3D: true,


                },

                bars: 'horizontal',
                //colors: ['blue', 'red', 'green', 'yellow', 'brown'],
                legend: 'none',
                // color: color,




            };

            // function getRandomColor() {
            //     var letters = '0123456789ABCDEF'.split('');
            //     var color = '#';
            //     for (var i = 0; i < 6; i++) {
            //         color += letters[Math.floor(Math.random() * 16)];
            //     }
            //     return color;
            // }
            function getRandomColor() {
                // var letters = '0123456789ABCDEF';
                // var color = '#';
                // for (var i = 0; i < 6; i++) {
                //     color += letters[Math.floor(Math.random() * 16)];
                // }
                // return color;
                var x = Math.floor(Math.random() * 256);
                var y = Math.floor(Math.random() * 256);
                var z = Math.floor(Math.random() * 256);
                var color = 'rgb(' + x + ',' + y + ',' + z + ')';
                return color;

            }
            options.series = {};
            for (var i = 0; i < data.getNumberOfRows(); i++) {
                options.series[i] = {
                    color: getRandomColor()
                }
            }

            var chart = new google.visualization.ColumnChart(document.getElementById('barchart_material'));
            //chart.draw(data, google.charts.Bar.convertOptions(options));
            chart.draw(data, options);
        }
    </script>
@endsection
