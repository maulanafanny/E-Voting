<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- LARAVEL CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mycss.css') }}">
    <!--   <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}"> -->
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/vendor/linearicons/style.css')}}">
    <link rel="stylesheet" href="{{ asset('/vendor/chartist/css/chartist-custom.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/css/main.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <!-- DATATABLES -->
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>Hasil Voting</title>
</head>
<body>
    <?php $judul = 'Hasil Voting'; ?>
    <div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">E-Voting | {{ $judul }}</h3>
        <p class="panel-subtitle">Periode : {{ $periode->periode }}</p>
    </div>
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
</div>

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
                    name: "Golongan Putih",
                    y: <?php echo $bl->jumlahbelumvoting; ?>,
                    drilldown: "Token Tidak Dipakai"
                }
                <?php }?>
            ]
        }]

    });
</script>

</body>
</html>
