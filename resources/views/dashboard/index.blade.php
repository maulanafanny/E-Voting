@extends('dashboard.dashboard')
@section('judul_halaman', 'Dashboard')
@section('konten')
    <?php $judul = 'Dashboard'; ?>
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">E-Voting | Dashboard</h3>
            <p class="panel-subtitle">Periode : {{ $periode->periode }}</p>
        </div>
        <div class="col-md-12" style="margin-left: 10px;">
            <a href="{{ route('admin.buka') }}" class="btn btn-success mb-5">
                <i class="fa fa-fw fa-play"></i>
                <span> Buka Voting</span>
            </a>
            <a href="{{ route('admin.tutup') }}" class="btn btn-danger mb-5">
                <i class="fa fa-fw fa-ban"></i>
                <span> Tutup Voting</span>
            </a>
            <a href="{{ route('admin.kandidat.export_excel') }}" class="btn btn-info my-3" target="_blank">
                <i class="fa fa-fw fa-file"></i>
                <span> Export Excel</span>
            </a>
        </div>
        <br><br>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <p>
                            <span class="number">
                                @foreach ($jumlahkandidat as $jumlah)
                                    {{ $jumlah->jumlah }}
                                @endforeach
                            </span>
                            <span class="title">Kandidat</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-volume-up"></i></span>
                        <p>
                            <span class="number">
                                @foreach ($jumlahhaksuara as $jumlah)
                                    {{ $jumlah->jumlah }}
                                @endforeach
                            </span>
                            <span class="title">Hak Suara</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-database"></i></span>
                        <p>
                            <span class="number">
                                @foreach ($suaramasuk as $jumlah)
                                    {{ $jumlah->suaramasuk }}
                                @endforeach
                            </span>
                            <span class="title">Suara Masuk</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <a href=""><span class="icon"><i class="fa fa-refresh"></i></span></a>
                        <p>
                            <span class="number">Refresh</span>
                            <span class="title">Manual</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="width:100%;">
                    <div id="chartHasil"></div>
                </div>
            </div>
        </div>
        <!-- END OVERVIEW -->
    </div>
    </div>

@endsection('konten')
@section('js')
    <script src="{{ asset('/js/chart.js') }}"></script>
    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('chartHasil', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Perolehan Suara.'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total suara yang di dapat'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Suara<br/>'
            },

            series: [{
                name: "Total",
                colorByPoint: true,
                data: [
                    <?php foreach($jumlahsuara as $nk){?> {
                        name: "<?php echo $nk->nama; ?>",
                        y: <?php echo $nk->jumlahsuara; ?>,
                        drilldown: "<?php echo $nk->nama; ?>"
                    },
                    <?php }?>
                    <?php foreach($belumvoting as $bl){?> {
                        name: "Belum Voting",
                        y: <?php echo $bl->jumlahbelumvoting; ?>,
                        drilldown: "Token Tidak Dipakai"
                    }
                    <?php }?>
                ]
            }]

        });
    </script>

@endsection('js')
