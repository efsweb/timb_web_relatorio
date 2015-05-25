 window.onload = function () {

  /* ------------------------------------------------*/
  /* ---------->>> PLATAFORMA GRAFICO <<<-----------*/
  /* -----------------------------------------------*/

    var chart = new CanvasJS.Chart("grafico-plataforma",
    {
      backgroundColor: "transparent",
      animationEnabled: false,
      axisY: {
        indexLabelFontColor: "#3D3E3F",
        labelFontSize: 12,
        gridColor: "#BBBBBB",
        interval: 1000,
        labelAngle: 90,
      },
      axisX: {
        labelFontSize: 16
      },
      data: [
      {        
        indexLabelFontSize: 16,
        indexLabelPlacement: "outside",
        indexLabelFontColor: "#3D3E3F",
        indexLabelFontWeight: 600,
        indexLabelFontFamily: "Roboto",        
        type: "bar",
        color: "#5E98B6",
        dataPoints: [
        { y: 2340, label: "Android", indexLabel: "2340" },
        { y: 2000, label: "IOS", indexLabel: "2340"},
        { y: 1500, label: "Web", indexLabel: "2340" }      
        ]
      }
      ]
    });

    chart.render();
}
  /* ------------------------------------------------*/
  /* ---------->>> PLATAFORMA GRAFICO <<<-----------*/
  /* -----------------------------------------------*/

