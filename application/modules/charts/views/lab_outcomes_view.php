<div id="outcomes">

</div>

<script type="text/javascript">
    $(function () {
                $('#outcomes').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: "<?php echo $trends['title'];?>"
                    },
                    xAxis: {
                        categories: <?php echo json_encode($trends['categories']);?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Tests'
                        },
                        stackLabels: {
                            rotation: -75,
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            },
                            y:-20
                        }
                    },
                    legend: {
                        align: 'right',
                        x: -30,
                        verticalAlign: 'top',
                        y: 25,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: true
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>% contribution: {point.percentage:.1f}%'
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: false,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                style: {
                                    textShadow: '0 0 3px black'
                                }
                            }
                        }
                    },colors: [
                        '#F2784B',
                        '#1BA39C',
                        '#913D88'
                    ],
                    series: <?php echo json_encode($trends['outcomes']);?>
                });
            });
</script>