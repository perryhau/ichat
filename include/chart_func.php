<?php

function one_line_chart($container, $url, $title, $name, $type, $large, $day){

?>
<script type="text/javascript">

$(function() {
	$.getJSON('<?php echo $url;?>',	function(data) {
	Highcharts.setOptions({
	global: {
		useUTC: false
	}
	});

	window.chart = new Highcharts.StockChart({
        chart : {
                renderTo : '<?php echo $container;?>'
	    },

        rangeSelector : {
                selected : 1,
		        enabled : false
            },
	    loading :{
	    },

	    yAxis: {
		minorTickInterval: 'auto',
		lineColor: '#000',
		lineWidth: 1,
		tickWidth: 1,
		tickColor: '#000',
		labels: {
			style: {
				color: '#000',
				font: '11px Trebuchet MS, Verdana, sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'
			}
		}
	},
        credits: {
            enabled: false
         },

	legend: {
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif',
			color: 'black'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		}
	},
            title : {
                text : '<?php echo $title;?>',
		align: 'left',
		style: {
			color: 'blue',
			fontSize: '12px'
		}
            },
    navigation: {
        buttonOptions: {
            height: 20,
            width: 20
        }
    },
exporting: {
    buttons: {
        popUpBtn: {
            symbol: 'diamond',
            _titleKey: 'popUpBtnTitle',
            x: -65,
            symbolFill: '#B5C9DF',
            hoverSymbolFill: '#779ABF',
            onclick: function () {
		window.open('<?php echo "http://".$_SERVER ["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];?>?p=<?php $ip=explode('<br>',$title);echo $ip[0];?>&ip=<?php $ip=explode('<br>',$title);echo $ip[0];?>&day=<?php echo $day;?>&img_type=large', '_blank', 'toolbar=0,location=0,menubar=0');
            }
        },
    }
},

            series : [{
                name : '<?php echo $name;?>',
                data : data,
                tooltip: {
                    valueDecimals: 2
                }
            }]
        });
    });

});
</script>

<?php
if ($large == 'large'){
echo <<<EOF
<div id="$container" style="height: 410px; min-width: 600px"></div>
EOF;
}
else if ($large == 'small'){
echo <<<EOF
<div class="thumbnail">
<div id="$container" style="height: 200px; width: 310px"></div>
</div>
EOF;
}
else if($large == 'full') {
echo <<<EOF
<div class="thumbnail">
<div id="$container" style="height: 600px; width: 800px"></div>
</div>
EOF;
}

}

function chart($container,$api,$name,$title,$img_size,$day)
{

        one_line_chart($container,$api.$name,$title,$name,$name,$img_size,$day);
}

function chart_multi($container,$api,$name,$title,$img_size)
{

        multi_line_chart($container,$api.$name,$title,$name,$name,$img_size);
}

// Multi Line
function multi_line_chart($container,$url,$names,$title,$large) {
?>

<script type="text/javascript">
$(function() {
	var seriesOptions = [],
		yAxisOptions = [],
		seriesCounter = 0,
		names = [<?php echo $names;?>],
		colors = Highcharts.getOptions().colors;

	$.each(names, function(i, name) {

		$.getJSON('<?php echo $url;?>'+ name , function(data) {

			Highcharts.setOptions({
        			global: {
                			useUTC: false
        			}
        		});
			seriesOptions[i] = {
				name: name,
				data: data
			};

			// As we're loading the data asynchronously, we don't know what order it will arrive. So
			// we keep a counter and create the chart when all the data is loaded.
			seriesCounter++;

			if (seriesCounter == names.length) {
				createChart();
			}
		});
	});



	// create the chart when all data is loaded
	function createChart() {

		chart = new Highcharts.StockChart({
		    chart: {
		        renderTo: '<?php echo $container;?>'
		    },

		    rangeSelector: {
		        selected: 1,
			enabled : false
		    },

		    legend: {
                itemStyle: {
                        font: '9pt Trebuchet MS, Verdana, sans-serif',
                        color: 'black'

                },
                itemHiddenStyle: {
                        color: 'gray'
                }
        },
		title : {
                text : '<?php echo $title;?>'
            },

		    yAxis: {
		    	plotLines: [{
		    		value: 0,
		    		width: 2,
		    		color: 'silver'
		    	}]
		    },
		    
		    //plotOptions: {
		    //	series: {
		    //		compare: 'percent'
		    //	}
		    //},
		    
		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
		    	valueDecimals: 2
		    },
		    
		    series: seriesOptions
		});
	}

});

</script>

<?php

if ($large == 'large'){
echo <<<EOF
<div id="$container" style="height: 410px; min-width: 600px"></div>
EOF;
}
else if ($large == 'small'){
echo <<<EOF
<div class="thumbnail">
<div id="$container" style="height: 200px; width: 280px"></div>
</div>
EOF;
} 
else if($large == 'full') {
echo <<<EOF
<div class="thumbnail">
<div id="$container" style="height: 600px; width: 800px"></div>
</div>
EOF;
}

}
?>
