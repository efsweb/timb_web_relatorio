<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"> 
		<script src="js/Chart.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset='utf-8'>

		<script type="text/javascript">

			<?php 

			$vl_meses = array();
			$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out","Nov", "Dez");

			require_once '../config/connection.php';

			$connect_mysql = new connect_mysql();

			$vl_meses = $connect_mysql->result_proc;	

			?>

		if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
		else window.attachEvent('onload', main);

		// --------- CHAMADA DOS GRÁFICOS ------ //

		function main() {
		    lineChartIOS();
		    lineChartAndroid();
		    lineChartWeb();
		}

		// --------- IOS CONFIGURE ------ //
		function lineChartIOS() {
		    var data = {
		    	//STRING DOS MESES
		        labels : 
		        [
		        	<?php echo '"'.$meses[0].'"'; ?>,
		        	<?php echo '"'.$meses[1].'"'; ?>,
		        	<?php echo '"'.$meses[2].'"'; ?>,
		        	<?php echo '"'.$meses[3].'"'; ?>,
		        	<?php echo '"'.$meses[4].'"'; ?>,
		        	<?php echo '"'.$meses[5].'"'; ?>,
		        	<?php echo '"'.$meses[6].'"'; ?>,
		        	<?php echo '"'.$meses[7].'"'; ?>,
		        	<?php echo '"'.$meses[8].'"'; ?>,
		        	<?php echo '"'.$meses[9].'"'; ?>,
		        	<?php echo '"'.$meses[10].'"'; ?>,
		        	<?php echo '"'.$meses[11].'"'; ?>
		        ],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					//DADOS DO BANCO - PARA PREENCHER O GRAFICO
		            data : 
		            [
		            	<?php echo '"'.$vl_meses[3][2].'"';?>,
		            	<?php echo '"'.$vl_meses[3][3].'"';?>,
		            	<?php echo '"'.$vl_meses[3][4].'"';?>,
		            	<?php echo '"'.$vl_meses[3][5].'"';?>,
		            	<?php echo '"'.$vl_meses[3][6].'"';?>,
		            	<?php echo '"'.$vl_meses[3][7].'"';?>,
		            	<?php echo '"'.$vl_meses[3][8].'"';?>,
		            	<?php echo '"'.$vl_meses[3][9].'"';?>,
		            	<?php echo '"'.$vl_meses[3][10].'"';?>,
		            	<?php echo '"'.$vl_meses[3][11].'"';?>,
		            	<?php echo '"'.$vl_meses[3][12].'"';?>,
		            	<?php echo '"'.$vl_meses[3][13].'"';?>,
		            ],
		            label : 'IOS'
		        }]
		    };

		    var ctx = document.getElementById("ios-canvas").getContext("2d");
		    new Chart(ctx).Line(data, {
		        responsive: true
		    });
		}


		// --------- ANDROID CONFIGURE ------ //

		function lineChartAndroid() {
		    var data = {
		    	//STRING DOS MESES
				labels : 
		        [
		        	<?php echo '"'.$meses[0].'"'; ?>,
		        	<?php echo '"'.$meses[1].'"'; ?>,
		        	<?php echo '"'.$meses[2].'"'; ?>,
		        	<?php echo '"'.$meses[3].'"'; ?>,
		        	<?php echo '"'.$meses[4].'"'; ?>,
		        	<?php echo '"'.$meses[5].'"'; ?>,
		        	<?php echo '"'.$meses[6].'"'; ?>,
		        	<?php echo '"'.$meses[7].'"'; ?>,
		        	<?php echo '"'.$meses[8].'"'; ?>,
		        	<?php echo '"'.$meses[9].'"'; ?>,
		        	<?php echo '"'.$meses[10].'"'; ?>,
		        	<?php echo '"'.$meses[11].'"'; ?>
		        ],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					//DADOS DO BANCO - PARA PREENCHER O GRAFICO
		            data : 
		            [
		            	<?php echo '"'.$vl_meses[1][2].'"';?>,
		            	<?php echo '"'.$vl_meses[1][3].'"';?>,
		            	<?php echo '"'.$vl_meses[1][4].'"';?>,
		            	<?php echo '"'.$vl_meses[1][5].'"';?>,
		            	<?php echo '"'.$vl_meses[1][6].'"';?>,
		            	<?php echo '"'.$vl_meses[1][7].'"';?>,
		            	<?php echo '"'.$vl_meses[1][8].'"';?>,
		            	<?php echo '"'.$vl_meses[1][9].'"';?>,
		            	<?php echo '"'.$vl_meses[1][10].'"';?>,
		            	<?php echo '"'.$vl_meses[1][11].'"';?>,
		            	<?php echo '"'.$vl_meses[1][12].'"';?>,
		            	<?php echo '"'.$vl_meses[1][13].'"';?>,
		            ],
		            label : 'Android'
		        }]
		    };

		    var ctx = document.getElementById("android-canvas").getContext("2d");
		    new Chart(ctx).Line(data, {
		        responsive: true
		    });
		}


		// --------- WEB CONFIGURE ------ //

		function lineChartWeb() {
		    var data = {
		    	//STRING DOS MESES
		        labels : 
		        [
		        	<?php echo '"'.$meses[0].'"'; ?>,
		        	<?php echo '"'.$meses[1].'"'; ?>,
		        	<?php echo '"'.$meses[2].'"'; ?>,
		        	<?php echo '"'.$meses[3].'"'; ?>,
		        	<?php echo '"'.$meses[4].'"'; ?>,
		        	<?php echo '"'.$meses[5].'"'; ?>,
		        	<?php echo '"'.$meses[6].'"'; ?>,
		        	<?php echo '"'.$meses[7].'"'; ?>,
		        	<?php echo '"'.$meses[8].'"'; ?>,
		        	<?php echo '"'.$meses[9].'"'; ?>,
		        	<?php echo '"'.$meses[10].'"'; ?>,
		        	<?php echo '"'.$meses[11].'"'; ?>
		        ],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					//DADOS DO BANCO - PARA PREENCHER O GRAFICO
		            data : 
		            [
		            	<?php echo '"'.$vl_meses[5][2].'"';?>,
		            	<?php echo '"'.$vl_meses[5][3].'"';?>,
		            	<?php echo '"'.$vl_meses[5][4].'"';?>,
		            	<?php echo '"'.$vl_meses[5][5].'"';?>,
		            	<?php echo '"'.$vl_meses[5][6].'"';?>,
		            	<?php echo '"'.$vl_meses[5][7].'"';?>,
		            	<?php echo '"'.$vl_meses[5][8].'"';?>,
		            	<?php echo '"'.$vl_meses[5][9].'"';?>,
		            	<?php echo '"'.$vl_meses[5][10].'"';?>,
		            	<?php echo '"'.$vl_meses[5][11].'"';?>,
		            	<?php echo '"'.$vl_meses[5][12].'"';?>,
		            	<?php echo '"'.$vl_meses[5][13].'"';?>,
		            ],
		            label : 'Android'
		        }]
		    };

		    var ctx = document.getElementById("web-canvas").getContext("2d");
		    new Chart(ctx).Line(data, {
		        responsive: true
		    });
		}
		</script>


	</head>
	<body>



		<section class="graficos">

			<div class="ios">
				<img class="icon-ios" src="images/ios-ico.png" />

				<section class="ios-grafic">
						<canvas class="ios-grafic" id="ios-canvas"></canvas>
				</section>

				<h1>Total: <span><?php echo $vl_meses[3][15];?></span><br/>
				Total no mês: <span><?php echo $vl_meses[3][14];?></span></h1>
			</div>

			<div class="android">
				<img class="icon-android" src="images/android-ico.png" />

				<section class="android-grafic">
						<canvas class="android-grafic" id="android-canvas"></canvas>
				</section>

				<h1>Total: <span><?php echo $vl_meses[1][15];?></span><br/>
				Total no mês: <span><?php echo $vl_meses[1][14];?></span></h1>

			</div>

			<div class="web">
				<img class="icon-web" src="images/web-ico.png" />

				<section class="web-grafic">
						<canvas class="web-grafic" id="web-canvas"></canvas>
				</section>
				<h1>Total: <span><?php echo $vl_meses[2][15];?></span><br/>
				Totalno mês: <span><?php echo $vl_meses[2][14];?></span></h1>
			</div>

		</section>
	</body>
</html>
