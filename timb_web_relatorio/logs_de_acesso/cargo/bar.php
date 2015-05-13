<!DOCTYPE HTML>
<html>
<head>  
  <?php 
    require_once '../config/connection.php';

    $connect_mysql = new connect_mysql();
    $connect_mysql->parametro = "'cargo'";
    $connect_mysql->connection();

    $contador = count($connect_mysql->result_proc); //contador de elementos do array
    //var_dump($x);
  ?>

  <script type="text/javascript">
    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      backgroundColor: "#3d3e3f",
      animationEnabled: true,
      axisY: {
        indexLabelFontColor: "white",
        labelFontSize: 12,
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
          for ($i = $contador-1; $i >= 0; $i--) {
            echo '{ y: '.$connect_mysql->result_proc[$i]['qtde'].', label: "'.$connect_mysql->result_proc[$i]['cargo'].'", indexLabel: "'.$connect_mysql->result_proc[$i]['qtde'].'" },' ;
          }

        ?>
        ]
      }
      ]
    });

chart.render();
}
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="../../js/canvasjs.min.js"></script></head>

<body>
      <div id="chartContainer" style="height: 460px; width: 760px; margin: 0 auto;">

</body>

</html>