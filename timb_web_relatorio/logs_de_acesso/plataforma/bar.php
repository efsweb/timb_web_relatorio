<!DOCTYPE HTML>
<html>
<head>  
  <?php 
    require_once '../config/connection.php';

    $connect_mysql = new connect_mysql();
  
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
        interval: 300,
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
        { y: <?php echo $connect_mysql->result_IOS[0]; ?>, label: "IOS", indexLabel: <?php echo '"'.$connect_mysql->result_IOS[0].'"'; ?> },
        { y: <?php echo $connect_mysql->result_ANDROID[0]; ?>, label: "Android" , indexLabel: <?php echo '"'.$connect_mysql->result_ANDROID[0].'"'; ?> }      
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