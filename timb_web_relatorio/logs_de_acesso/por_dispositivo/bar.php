<!DOCTYPE HTML>
<html>
<head>  
  <?php 
    require_once '../../config/connection.php';

    $connect_mysql = new connect_mysql();
    $connect_mysql->parametro = "'dispositivo'";
    $connect_mysql->parametro_2 = "''";
    $connect_mysql->connection();
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
        gridColor: "#373839",
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
        { y: <?php echo $connect_mysql->result_proc[1]['qtde']; ?>, label: <?php echo '"'.$connect_mysql->result_proc[1]['dispositivo'].'"'; ?>, indexLabel: <?php echo '"'.$connect_mysql->result_proc[0]['qtde'].'"'; ?> },
        { y: <?php echo $connect_mysql->result_proc[0]['qtde']; ?>, label: <?php echo '"'.$connect_mysql->result_proc[0]['dispositivo'].'"'; ?> , indexLabel: <?php echo '"'.$connect_mysql->result_proc[1]['qtde'].'"'; ?> }      
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