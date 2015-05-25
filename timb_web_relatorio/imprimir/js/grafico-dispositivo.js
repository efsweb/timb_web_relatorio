
  /* ------------------------------------------------*/
  /* -------->>> POR DISPOSITIVO GRAFICO <<<---------*/
  /* -----------------------------------------------*/

    var chart = new CanvasJS.Chart("grafico-pordispositivo",
    {
      backgroundColor: "transparent",
      animationEnabled: false,
      axisY: {
        indexLabelFontColor: "black",
        labelFontSize: 12,
        interval: 500,
        gridColor: "#BBBBBB",
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
        { y: 2340, label: "Android", indexLabel: "2340"  },
        {  y: 2030, label: "iOS", indexLabel: "2030"  }      
        ]
      }
      ]
    });

chart.render();
