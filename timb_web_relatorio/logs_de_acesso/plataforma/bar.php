<!DOCTYPE HTML>
<html>
<head>  
  <?php 
    require_once '../config/connection.php';

    $connect_mysql = new connect_mysql();
    $connect_mysql->parametro = "'plataforma'";
    $connect_mysql->connection();

  ?>

<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>


<div id="loading">
<div id="loading-center">
<div id="loading-center-absolute">
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
<div class="object"></div>
</div>
</div>
 
</div>

      <div id="chartContainer" style="height: 460px; width: 760px; margin: 0 auto;">

<script type="text/javascript" src="../../js/canvasjs.min.js"></script>
<script src="../../js/jquery-1.11.2.min.js"></script>


<script language="javascript" type="text/javascript">
  $(window).load(function() {
    $("#loading").delay(1500).fadeOut(500);
  })

    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      backgroundColor: "#3d3e3f",
      animationEnabled: true,
      axisY: {
        indexLabelFontColor: "white",
        labelFontSize: 12,
        gridColor: "#373839",
        interval: 1000,
        labelAngle: 90,
      },
      data: [
      {        
        indexLabelFontSize: 26,
        indexLabelPlacement: "outside",
        indexLabelFontColor: "white",
        indexLabelFontWeight: 600,
        indexLabelFontFamily: "Verdana",        
        type: "bar",
        color: "#00AEF0",
        dataPoints: [
        { y: <?php echo $connect_mysql->result_proc[2]["qtde"] ?>, label: <?php echo '"'.$connect_mysql->result_proc[2]["tipo_acesso"].'"'; ?>, indexLabel: <?php echo '"'.$connect_mysql->result_proc[2]["qtde"].'"'; ?> },
        { y: <?php echo $connect_mysql->result_proc[1]["qtde"] ?>, label: <?php echo '"'.$connect_mysql->result_proc[1]["tipo_acesso"].'"'; ?>, indexLabel: <?php echo '"'.$connect_mysql->result_proc[1]["qtde"].'"'; ?> },
        { y: <?php echo $connect_mysql->result_proc[0]["qtde"]; ?>, label: <?php echo '"'.$connect_mysql->result_proc[0]["tipo_acesso"].'"'; ?> , indexLabel: <?php echo '"'.$connect_mysql->result_proc[0]["qtde"].'"'; ?> }      
        ]
      }
      ]
    });

  chart.render();
  }
  </script>

</body>

</html>