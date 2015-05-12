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
			$ordena_meses_atual = array(); //ARMAZENADA ORDENADAMENTE APARTIR DO MES ATUAL
			$ordena_meses = array(); //ORDENA OS MESES DE ACORDO COM O MES ATUAL - para concatenar todos.
			
			$array_grafico = array();
			$grafico_ios = array();
			$grafico_web = array();

			require_once '../config/connection.php';

			$connect_mysql = new connect_mysql();

			$vl_meses = $connect_mysql->result_proc;
			//COLUNAS DO BANCO DE DADOS	-> VÁ EM CONFIG/CONNECTION.PHP E DE UM VAR_DUMP PARA ENTENDER AS VARIAVEIS QUE PERCORREM O CODIGO.
			//var_dump($vl_meses);
			$mes_atual = intval(date('m'));//VALOR DO MES ATUAL EM NUMERO

			//VALORES RESPECTIVOS AS 12 MESES A SEREM EXIBIDOS NO GRAFICO

			//ANO ATUAL
			$ano_atual['1']	= array(); //ANO ATUAL

			//ANO ANTERIOR 
			$ano_ant['0']	= array(); //ANO ANTERIOR 

			$array_ios = array();
			$result_array_ios = array();
			$i = $mes_atual+1;
			//PERCORRE A DATA ARMAZENANDO APENAS OS MESES QUE SE PASSARAM DO ANO ATUAL (EXEMPLO: JAN - ABR = 1,2,3,4)
			for ($i; $i >= 2; $i--) { 
				array_push($ano_atual['1'],$i);		//ADICIONA OS VALORES A UM ARRAY ($ano_atual)
				array_unshift($ordena_meses_atual,$meses[$i-2]); //REALIZA A ORDENACAO DE ACORDO COM O MES ATUAL

			}

			for ($k = 0; $k <= 5 ; $k++) { //LOOP PARA VALORES DO ANO ATUAL

				if($k == 1){
					for($i = 0 ; $i <= $mes_atual-1; $i++){
						//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_atual['1'][$ano_atual['1'][$i]] =  $vl_meses['1'][$ano_atual['1'][$i]];
							array_unshift($array_grafico ,$vl_meses[$k][$ano_atual['1'][$i]]);
					}					
				}elseif($k ==3){
					for($i = 0 ; $i <= $mes_atual-1; $i++){
						//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_atual['1'][$ano_atual['1'][$i]] =  $vl_meses['1'][$ano_atual['1'][$i]];
							array_unshift($grafico_ios ,$vl_meses[$k][$ano_atual['1'][$i]]);
					}	
				}elseif($k ==5){
					for($i = 0 ; $i <= $mes_atual-1; $i++){
						//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_atual['1'][$ano_atual['1'][$i]] =  $vl_meses['1'][$ano_atual['1'][$i]];
							array_unshift($grafico_web ,$vl_meses[$k][$ano_atual['1'][$i]]);
					}	
				}				
			}
			if($mes_atual != 12){ //VERIFICA SE REALMENTE É NECESSARIO TER CONTAGEM DOS MESES DO ANO ANTERIOR
				
				$j = $mes_atual+2; //ESSA SOMA É PARA SE IGUALAR A MATRIZ DO BANCO PARA A CONTAGEM DOS MESES 

				for ($j ; $j <= 13; $j++) { //LOOP PARA VALORES DO ANO ANTERIOR

					array_push($ano_ant['0'],$j);	//ADICIONA OS VALORES A UM ARRAY ($ano_ant)
					array_push($ordena_meses, $meses[$j-2]); //REALIZA A ORDENACAO DE ACORDO COM O MES ATUAL
				}

				for ($k = 0; $k <= 5 ; $k++) {
					$count = 12 - ($mes_atual+1);
					
					if($k == 0){
						for($j = $count ; $j >= 0; $j--){ //ADICIONA O ARRAY DE COMEÇANDO POR DEZEMBRO

							//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_ant['0'][$ano_ant['0'][$j]] =  $vl_meses['0'][$ano_ant['0'][$j]];
							array_unshift($array_grafico,$vl_meses[$k][$ano_ant['0'][$j]]);

						}				
					}elseif($k == 2){

						for($j = $count ; $j >= 0; $j--){
							//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_ant['0'][$ano_ant['0'][$j]] =  $vl_meses['0'][$ano_ant['0'][$j]];
							array_unshift($grafico_ios,$vl_meses[$k][$ano_ant['0'][$j]]);
						}	
					}elseif($k == 4){

						for($j = $count ; $j >= 0; $j--){
							//CRIO UM ARRAY COM OS VALORES NOS INDICES CORRETOS DE CADA MES E ANO REGISTRADO EM CADA DISPOSITIVO NO BANCO 
							$array_ano_ant['0'][$ano_ant['0'][$j]] =  $vl_meses['0'][$ano_ant['0'][$j]];
							array_unshift($grafico_web,$vl_meses[$k][$ano_ant['0'][$j]]);
						}	
					}
				}
			}			

			$exibe_meses = array_merge($ordena_meses,$ordena_meses_atual);
			
			//$array_grafico = array_merge($array_ano_ant, $array_ano_atual);
//			var_dump($exibe_meses);
//			var_dump($array_grafico);

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
		        	<?php echo '"'.$exibe_meses[0].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[1].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[2].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[3].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[4].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[5].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[6].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[7].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[8].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[9].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[10].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[11].'"'; ?>,
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
		        	<?php echo '"'.$grafico_ios[0].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[1].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[2].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[3].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[4].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[5].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[6].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[7].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[8].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[9].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[10].'"'; ?>,
		        	<?php echo '"'.$grafico_ios[11].'"'; ?>,
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
		    	//STRING DOS meses
				labels : 
		        [
		        	<?php echo '"'.$exibe_meses[0].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[1].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[2].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[3].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[4].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[5].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[6].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[7].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[8].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[9].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[10].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[11].'"'; ?>,
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
		            	<?php echo '"'.$array_grafico[0].'"';?>,
		            	<?php echo '"'.$array_grafico[1].'"';?>,
		            	<?php echo '"'.$array_grafico[2].'"';?>,
		            	<?php echo '"'.$array_grafico[3].'"';?>,
		            	<?php echo '"'.$array_grafico[4].'"';?>,
		            	<?php echo '"'.$array_grafico[5].'"';?>,
		            	<?php echo '"'.$array_grafico[6].'"';?>,
		            	<?php echo '"'.$array_grafico[7].'"';?>,
		            	<?php echo '"'.$array_grafico[8].'"';?>,
		            	<?php echo '"'.$array_grafico[9].'"';?>,
		            	<?php echo '"'.$array_grafico[10].'"';?>,
		            	<?php echo '"'.$array_grafico[11].'"';?>,
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
		        	<?php echo '"'.$exibe_meses[0].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[1].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[2].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[3].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[4].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[5].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[6].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[7].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[8].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[9].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[10].'"'; ?>,
		        	<?php echo '"'.$exibe_meses[11].'"'; ?>,
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
		            	<?php echo '"'.$grafico_web[0].'"';?>,
		            	<?php echo '"'.$grafico_web[1].'"';?>,
		            	<?php echo '"'.$grafico_web[2].'"';?>,
		            	<?php echo '"'.$grafico_web[3].'"';?>,
		            	<?php echo '"'.$grafico_web[4].'"';?>,
		            	<?php echo '"'.$grafico_web[5].'"';?>,
		            	<?php echo '"'.$grafico_web[6].'"';?>,
		            	<?php echo '"'.$grafico_web[7].'"';?>,
		            	<?php echo '"'.$grafico_web[8].'"';?>,
		            	<?php echo '"'.$grafico_web[9].'"';?>,
		            	<?php echo '"'.$grafico_web[10].'"';?>,
		            	<?php echo '"'.$grafico_web[11].'"';?>,
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
				Mês Atual: <span><?php echo $vl_meses[3][14];?></span></h1>
			</div>

			<div class="android">
				<img class="icon-android" src="images/android-ico.png" />

				<section class="android-grafic">
						<canvas class="android-grafic" id="android-canvas"></canvas>
				</section>

				<h1>Total: <span><?php echo $vl_meses[1][15];?></span><br/>
				Mês Atual: <span><?php echo $vl_meses[1][14];?></span></h1>

			</div>

			<div class="web">
				<img class="icon-web" src="images/web-ico.png" />

				<section class="web-grafic">
						<canvas class="web-grafic" id="web-canvas"></canvas>
				</section>
				<h1>Total: <span><?php echo $vl_meses[5][15];?></span><br/>
				Mês Atual: <span><?php echo $vl_meses[5][14];?></span></h1>
			</div>

		</section>
	</body>
</html>
