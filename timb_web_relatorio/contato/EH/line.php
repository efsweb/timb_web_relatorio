<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700|Electrolize' rel='stylesheet' type='text/css' />
		<meta charset='utf-8'>
		<?php
			require_once '../../config/connection.php';

			$connect_mysql = new connect_mysql();
			$connect_mysql->parametro = "'grafico_linha'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql->parametro_2 = "''"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO

			/*
				INICIO DA ORDENACAO DOS MESES - PARA SE TORNAR OS 12 MESES ANTERIORES AO MES ATUAL
			*/
			$vl_mes = $connect_mysql->result_proc;

			/*---------DETALHAMENTO CHAMADO---------*/
			$connect_mysql_chamado = new connect_mysql();
			$connect_mysql_chamado->parametro = "'detalhamento_chamado'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql_chamado->parametro_2 = "''"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql_chamado->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO

			$chamado = $connect_mysql_chamado->result_proc;

			//----- INICIO ORDENACAO DOS MESES -----

			$mes_atual = intval(date('m'));//VALOR DO MES ATUAL EM NUMERO			

			$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out","Nov", "Dez");

			//var_dump($vl_mes); //[mes_ano] - [qtde_conteudo] - [qtde_aplicativo] - [qtde_sugestao]

			//VALORES RESPECTIVOS AS 12 MESES A SEREM EXIBIDOS NO GRAFICO

			$ano = array();

			$ordena_meses_atual = array(); //ORDENA OS MESES DO ANO ATUAL
			$ordena_meses = array(); //ORDENA OS MESES DO ANO ANTERIOR

			$ano_atual = array();
			$ano_ant = array();			

			for ($i=0; $i < count($vl_mes); $i++) { 
				array_push($ano,substr($vl_mes[$i]['mes_ano'],3));//substr("05/2015",3) = "2015"
				if($ano[$i] == 2015){
					array_push($ano_atual,$i);
				}
			}

			$i = $mes_atual+1;
			//PERCORRE A DATA ARMAZENANDO APENAS OS MESES QUE SE PASSARAM DO ANO ATUAL (EXEMPLO: JAN - ABR = 1,2,3,4)
			for ($i; $i >= 2; $i--) { 
				array_push($ano_atual,$i);	//ADICIONA OS VALORES A UM ARRAY ($ano_atual)
				array_unshift($ordena_meses_atual,$meses[$i-2]); //REALIZA A ORDENACAO DE ACORDO COM O MES ATUAL
			}

			$j = $mes_atual+2; //ESSA SOMA É PARA SE IGUALAR A MATRIZ DO BANCO PARA A CONTAGEM DOS MESES 

			for ($j ; $j <= 13; $j++) { //LOOP PARA VALORES DO ANO ANTERIOR
				array_push($ordena_meses, $meses[$j-2]); //REALIZA A ORDENACAO DE ACORDO COM O MES ATUAL
			}

			$exibe_meses = array_merge($ordena_meses,$ordena_meses_atual);

			//-----ENCERRA ORDENACAO DOS MESES-----

			//-----INICIO VALORES DO GRAFICO-----

			$conteudo_array = array(); // PRODUTO
			$aplicativo_array = array();
			$sugestao_array = array();
			

			for ($j = $mes_atual; $j < 12; $j++ ){
					$vl_mes[$j]['qtde_conteudo'] = !empty($vl_mes[$j]['qtde_conteudo'])?$vl_mes[$j]['qtde_conteudo']:'0';
					$vl_mes[$j]['qtde_aplicativo'] = !empty($vl_mes[$j]['qtde_aplicativo'])?$vl_mes[$j]['qtde_aplicativo']:'0';
					$vl_mes[$j]['qtde_sugestao'] = !empty($vl_mes[$j]['qtde_sugestao'])?$vl_mes[$j]['qtde_sugestao']:'0';
					array_push($conteudo_array,$vl_mes[$j]['qtde_conteudo']);
					array_push($aplicativo_array,$vl_mes[$j]['qtde_aplicativo']);
					array_push($sugestao_array,$vl_mes[$j]['qtde_sugestao']);

			}
			
			for ($i= 0; $i <= $mes_atual-1; $i++) { //PERCORRER OS 12 MESES
					array_push($conteudo_array,$vl_mes[$i]['qtde_conteudo']);
					array_push($aplicativo_array,$vl_mes[$i]['qtde_aplicativo']);
					array_push($sugestao_array,$vl_mes[$i]['qtde_sugestao']);		
			}			

		?>
	</head>
	<body>

	<!-- SEÇÃO QUE SEGURA TUDO -->

		<section class="grafico">

		<!-- GRÁFICO -->

				<section class="eh-grafic">
						<canvas class="eh-grafic" id="ios-canvas"></canvas>
						<div id="lineLegend"></div>
				</section>

				<!-- TABELA PRINCIPAL DE DADOS -->

				<table id="tablefilter" class="table-eh">
					<thead>
						<tr>
							<th class="th-cor">Cor</th>
							<th class="th-nome">Nome</th>
							<th>Natureza</th>
							<th>Dia</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="tBody-example">
						<?php
						for ($i=0; $i < count($chamado); $i++) { 

							$natureza = strtoupper($chamado[$i]['natureza']);

							if($natureza == 'APLICATIVO'){
								$class = 'cinza';
							}elseif ($natureza == 'CONTEúDO') {
								$class = 'verde';
							}elseif ($natureza == 'SUGESTãO') {
								$class = 'azul';
							}else{
								$class='';
							}
							echo ("<tr id='".$chamado[$i]['data']."' class='button dialog-open'>");
							//echo("<th>".$chamado[$i]['cor']."</th>");
							echo("<th class=".$class.">  </th>");
							echo("<th>".$chamado[$i]['nome']."</th>");
							echo("<th>".$chamado[$i]['natureza']."</th>");
							echo("<th>".date("d/m/Y",strtotime(substr($chamado[$i]['data'],0,10)))."</th>");
							echo("<th>".$chamado[$i]['status']."</th>");
							echo("</tr>");
						}
						?>
					</tbody>
				</table>


				<!-- MODAL -->

			  	<div id="overlay">
			    	<div id="screen"></div>
			      	<div id='dialog-' class="dialog">
			        	<div class="body-dialog">

			        	<!-- TABELA COM TELEFONES E COMENTÁRIOS -->
				          <table class="content-eh">
				          	<tr>
				          		<td class="title-head">Data:</td>
				          		<td id="data"></td>
				          		<td class="title-head">Natureza:</td>
				          		<td id="natureza"></td>
				          	</tr>
				          	<tr>
				          		<td class="title-head">Nome:</td>
				          		<td colspan="3" id="nome"></td>
				          	</tr>

				          	 <tr>
				          		<td class="title-head">Email:</td>
				          		<td colspan="3" id="email"></td>
				          	</tr>
				          	<tr>
				          		<td class="title-head">Tel:</td>
				          		<td colspan="3" id="telefone"></td>
				          	</tr>
				          	<tr class="assunto">
				          		<td class="title-head">Assunto:</td>
				          		<td colspan="3">
				          			<div class="scroll" id="mensagem">
				          		Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue n

				          			</div>
				          		</td>
				          		
				          	</tr>
				          </table>
						</div>
			        	<div class="x-dialog">x</div>
			      	</div>
			    </div>
			</div>

		<script src="../../js/Chart.min.js"></script>
		<script src="../../js/jquery-1.11.2.min.js"></script>
		<script src="../../js/jquery.dataTables.js"></script>
		<script src="../js/modal-eh.js"></script>

		<script>

		// --------- CHAMADA Do SEARCH TABLE ------ //

		$(document).ready(function(){
	    $('#tablefilter').DataTable({
		    "bJQueryUI": true,
	        'iDisplayLength': 5,
	        'bLengthChange': false
	    });
		});



		if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
		else window.attachEvent('onload', main);

		// --------- CHAMADA DOS GRÁFICOS ------ //

		function main() {
		    lineChartIOS();
		}

		// --------- GRÁFICO DE LINHAS EH CONFIGURE ------ //
		function lineChartIOS() {
		    var data = {
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
		            fillColor : "transparent",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
		            data : 
				        [
				        	<?php echo '"'.$sugestao_array[0].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[1].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[2].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[3].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[4].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[5].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[6].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[7].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[8].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[9].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[10].'"'; ?>,
				        	<?php echo '"'.$sugestao_array[11].'"'; ?>,
				        ],
		            label : 'Sugestões'
		        },
		        {
		            fillColor : "transparent",
		            strokeColor : "rgba(82,204,82,1)",
		            pointColor : "rgba(82,204,82,1)",
		            pointStrokeColor : "#fff",
		            pointHighlightFill : "#fff",
		            pointHighlightStroke : "rgba(82,204,82,1)",
		            data : 
				        [
				        	<?php echo '"'.$conteudo_array[0].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[1].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[2].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[3].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[4].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[5].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[6].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[7].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[8].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[9].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[10].'"'; ?>,
				        	<?php echo '"'.$conteudo_array[11].'"'; ?>,
				        ],
		            label : 'Produto'
		        },
		        {
		            fillColor : "transparent",
		            strokeColor : "rgba(92,92,92,1)",
		            pointColor : "rgba(92,92,92,1)",
		            pointStrokeColor : "#fff",
		            pointHighlightFill : "#fff",
		            pointHighlightStroke : "rgba(151,187,205,1)",
		            data : 
				        [
				        	<?php echo '"'.$aplicativo_array[0].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[1].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[2].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[3].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[4].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[5].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[6].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[7].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[8].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[9].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[10].'"'; ?>,
				        	<?php echo '"'.$aplicativo_array[11].'"'; ?>,
				        ],
		            label : 'Aplicativo'
		        }]
		    };

		    var ctx = document.getElementById("ios-canvas").getContext("2d");
		    new Chart(ctx).Line(data);

		    legend(document.getElementById("lineLegend"), data);

		}

		function legend(parent, data) {
		    legend(parent, data, null);
		}

		function legend(parent, data, chart) {
		    parent.className = 'legend';
		    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

		    // remove possible children of the parent
		    while(parent.hasChildNodes()) {
		        parent.removeChild(parent.lastChild);
		    }

		    var show = chart ? showTooltip : noop;
		    datas.forEach(function(d, i) {
		        //span to div: legend appears to all element (color-sample and text-node)
		        var title = document.createElement('div');
		        title.className = 'title';
		        parent.appendChild(title);

		        var colorSample = document.createElement('div');
		        colorSample.className = 'color-sample';
		        colorSample.style.backgroundColor = d.hasOwnProperty('strokeColor') ? d.strokeColor : d.color;
		        colorSample.style.borderColor = d.hasOwnProperty('fillColor') ? d.fillColor : d.color;
		        title.appendChild(colorSample);

		        var text = document.createTextNode(d.label);
		        text.className = 'text-node';
		        title.appendChild(text);

		        show(chart, title, i);
		    });
		}


		// --------- LEGENDA DE GRÁFICO EH ------ //

		//add events to legend that show tool tips on chart
		function showTooltip(chart, elem, indexChartSegment){
		    var helpers = Chart.helpers;

		    var segments = chart.segments;
		    //Only chart with segments
		    if(typeof segments != 'undefined'){
		        helpers.addEvent(elem, 'mouseover', function(){
		            var segment = segments[indexChartSegment];
		            segment.save();
		            segment.fillColor = segment.highlightColor;
		            chart.showTooltip([segment]);
		            segment.restore();
		        });

		        helpers.addEvent(elem, 'mouseout', function(){
		            chart.draw();
		        });
		    }
		}

		function noop() {}

		</script>

  </body>
</html>
