@extends('layouts.app')

@section('title', 'Reporte de Ventas por Mes')

@section('content')
<div class="container py-4">

    <div class="card shadow-lg border-0" style="border-radius: 18px;">
        <div class="card-body">

            <h2 class="text-center mb-4 bebas-neue-regular">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                Reporte de Ventas por Mes
            </h2>

            <div id="grafica" style="width: 100%; height: 420px;"></div>

        </div>
    </div>

</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable(
        {!! $chartData !!}
    );

    var options = {
        titleTextStyle: {
            fontSize: 20,
            bold: true,
            fontName: 'Outfit'
        },
        legend: {
            position: 'bottom',
            textStyle: {fontName: 'Outfit'}
        },
        hAxis: {
            title: 'Mes',
            textStyle: {fontName: 'Outfit'},
            titleTextStyle: {fontWeight: 600}
        },
        vAxis: {
            title: 'Monto ($)',
            textStyle: {fontName: 'Outfit'},
            titleTextStyle: {fontWeight: 600}
        },
        colors: ['#2563eb'], // tu color primario
        chartArea: {
            width: '80%',
            height: '65%'
        },
        bar: {
            groupWidth: '55%'
        }
    };

    var chart = new google.visualization.ColumnChart(
        document.getElementById('grafica')
    );

    chart.draw(data, options);
}
</script>
@endsection
