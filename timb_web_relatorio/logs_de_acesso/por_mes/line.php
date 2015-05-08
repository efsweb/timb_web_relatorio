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

			$meses = array();
			require_once '../config/connection.php';

			$connect_mysql = new connect_mysql();

			var_dump($connect_mysql);

			//$meses = explode('"tipo_acesso"', $connect_mysql->result_proc,7);

			$meses = explode(',', $connect_mysql->result_proc);
			var_dump($meses);


			exit;	

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
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
		            data : [65,59,90,81,56,55,40,50,60,30,48],
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
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
		            data : [65,59,90,81,56,55,40,50,60,30,48],
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
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,0.2)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
		            data : [65,59,90,81,56,55,40,50,60,30,48],
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

				<h1>Total do mês: <span>12000</span><br/>
				No mês: <span>12000</span></h1>
			</div>

			<div class="android">
				<img class="icon-android" src="images/android-ico.png" />

				<section class="android-grafic">
						<canvas class="android-grafic" id="android-canvas"></canvas>
				</section>

				<h1>Total do mês: <span>12000</span><br/>
				No mês: <span>12000</span></h1>

			</div>

			<div class="web">
				<img class="icon-web" src="images/web-ico.png" />

				<section class="web-grafic">
						<canvas class="web-grafic" id="web-canvas"></canvas>
				</section>
				<h1>Total do mês: <span>12000</span><br/>
				No mês: <span>12000</span></h1>
			</div>

		</section>
	</body>
</html>
