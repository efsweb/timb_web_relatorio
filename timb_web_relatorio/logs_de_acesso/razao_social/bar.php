<!DOCTYPE HTML>
<html>
<head>  
<meta charset='utf-8'>
  <?php 
    require_once '../config/connection.php';

    $connect_mysql = new connect_mysql();
    $connect_mysql->parametro = "'razao_social'";
    $connect_mysql->connection();

    $contador = count($connect_mysql->result_proc); //contador de elementos do array
    

  ?>

  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/style.scss">


  <script type="text/javascript" src="../../js/canvasjs.min.js"></script>

  <script type="text/javascript">
    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      backgroundColor: "#3d3e3f",
      animationEnabled: true,
      axisX: {
        indexLabelFontColor: "white",
        labelFontSize: 11,
        interval: 1,
      },
      axisY: {
        indexLabelFontColor: "white",
        labelFontSize: 12,
        gridColor: "#373839",
        interval: 50,
        labelAngle: 90,
      },
      data: [
      {        
        indexLabelFontSize: 18,
        indexLabelPlacement: "outside",
        indexLabelFontColor: "white",
        indexLabelFontWeight: 600,
        indexLabelFontFamily: "Verdana",        
        type: "bar",
        color: "#00AEF0",
        dataPoints: [
        <?php 
        //REALIZA A LEITURA DOS DADOS DO BANCO
          for ($i = $contador-1; $i >= 0; $i--) {
            //VERIFICA SE A RAZAO SOCIAL POSSUI MUITOS CARACTERES (SE FOR MAIOR QUE 45 ELE DELIMITA A STRING)
            if(strlen($connect_mysql->result_proc[$i]['razao_social']) >= 45){
              $razao_social = substr($connect_mysql->result_proc[$i]['razao_social'], 0, 45)." ...";
            }else{
              $razao_social = $connect_mysql->result_proc[$i]['razao_social'];
            }            
            //MONTA O JAVASCRIPT DE ACORDO COM O CONTEUDO
            echo '{ y: '.$connect_mysql->result_proc[$i]['qtde'].', 
            label: "'.$razao_social.'", indexLabel: "'.$connect_mysql->result_proc[$i]['qtde'].'" },' ;
          }

        ?>
        ]
      }
      ]
    });

chart.render();
}
</script>
</head>

<body>
<div class="graficos">
      <div id="chartContainer" style="height: 1200px; width: 760px; margin: 0 auto;">
</div>
</body>

</html>