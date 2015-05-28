<html>
	<head>
		<title>Line Chart</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700|Electrolize' rel='stylesheet' type='text/css' />
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<?php
			require_once '../../config/connection.php';

			$connect_mysql = new connect_mysql();
			$connect_mysql->parametro = "'grafico_total'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql->parametro_2 = "''"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO



			$mes_atual = (intval(date('m')))-1;//VALOR DO MES ATUAL EM NUMERO
			$ano_atual = intval(date('y'));//VALOR DO MES ATUAL EM NUMERO
			$dia_atual = intval(date('d'));//VALOR DO MES ATUAL EM NUMERO			

			$meses = array("Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out","Nov", "Dez");
			/*
				INICIO DA ORDENACAO DOS MESES - PARA SE TORNAR OS 12 MESES ANTERIORES AO MES ATUAL
			*/
			$grafico_total = $connect_mysql->result_proc;

			$soma_resultado = $grafico_total[0]['total'] + $grafico_total[1]['total'] + $grafico_total[2]['total'];

			/*---------DETALHAMENTO CHAMADO---------*/
			$connect_mysql_chamado = new connect_mysql();
			$connect_mysql_chamado->parametro = "'detalhamento_chamado'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql_chamado->parametro_2 = "''"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
			$connect_mysql_chamado->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO

			$chamado = $connect_mysql_chamado->result_proc;

		?>
		<script src="../../js/Chart.min.js"></script>
		<script src="../../js/canvasjs.min.js"></script>
		<script src="../../js/jquery-1.11.2.min.js"></script>
		<script src="../../js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="../js/modal-eh.js" charset="utf-8"></script>
		


		<script>

		// --------- CHAMADA DO JS DA TABLESEARCH ------ //

		$(document).ready(function(){
	    $('#tablefilter').DataTable({
		    "bJQueryUI": true,
	        'iDisplayLength': 5,
	        'bLengthChange': false
	    });
		});


window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      backgroundColor: "#3d3e3f",
      animationEnabled: true,
      legend : {
		fontColor: "#ddd",
		fontSize: 12,
		fontFamily: "Arial",
	  },
      axisX: {
        valueFormatString: "MMM",
        interval: 1,
        gridColor: "#373839",
        labelFontSize: 12,
        intervalType: "month"
      },
	 axisY:{
	  	labelFontSize: 12,
	  	gridColor: "#373839"
	  },
      data: [
      {
      	indexLabelFontSize: 15,
      	indexLabelPlacement: "inside",
      	indexLabelFontColor: "white",
        type: "stackedBar",
        legendText: "Sugestões",
        color: "#4286A8",
        showInLegend: "true",
        dataPoints: [
        { x: new Date(<?php echo '"'.$ano_atual.'","'.$mes_atual.'","'.$dia_atual.'"'; ?>), y: <?php echo $grafico_total[2]['total'];?>, indexLabel: <?php echo '"'.$grafico_total[2]['total'].'"';?> }
        ]
      },
        {
        indexLabelFontSize: 15,
      	indexLabelPlacement: "inside",
      	indexLabelFontColor: "white",
        type: "stackedBar",
        legendText: "Produto",
        color: "#52CC52",
        showInLegend: "true",
        dataPoints: [
        { x: new Date(<?php echo '"'.$ano_atual.'","'.$mes_atual.'","'.$dia_atual.'"'; ?>), y:  <?php echo $grafico_total[1]['total'];?> , indexLabel: <?php echo '"'.$grafico_total[1]['total'].'"';?> }

        ]
      },
        {
        indexLabelFontSize: 15,
      	indexLabelPlacement: "inside",
      	indexLabelFontColor: "white",
        type: "stackedBar",
        legendText: "Aplicativo",
        color: "#5C5C5C",
        showInLegend: "true",
        dataPoints: [
        { x: new Date(<?php echo '"'.$ano_atual.'","'.$mes_atual.'","'.$dia_atual.'"'; ?>), y:  <?php echo $grafico_total[0]['total'];?>,  indexLabel: <?php echo '"'.$grafico_total[0]['total'].'"';?> }

        ]
      }
      ]
    });

    chart.render();
  }
		</script>
	</head>
	<body>

	<!-- SEÇÃO QUE SEGURA TUDO -->

		<section class="grafico">

		<!-- GRÁFICO -->

				<section class="options-grafic">
						<div id="chartContainer" class="eh-grafic" ></div>
						<h1>Total do m&ecirc;s: <span><?php echo $soma_resultado;?></span></h1>
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

  </body>
</html>
