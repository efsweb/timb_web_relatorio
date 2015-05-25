
    var chart = new CanvasJS.Chart("chartContainer",
    {
    backgroundColor: "transparent",
    animationEnabled: false,
    legend : {
		fontColor: "black",
		fontSize: 12,
		fontFamily: "Arial",
	  },
      axisX: {
        valueFormatString: "MMM",
        interval: 1,
        gridColor: "#BBBBBB",
        labelFontSize: 15,
        intervalType: "month"
      },
	 axisY:{
	  	labelFontSize: 12,
	  	gridColor: "#BBBBBB"
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
        { x: new Date(2012, 01, 1), y: 71, indexLabel: "72" }
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
        { x: new Date(2012, 01, 1), y: 71 , indexLabel: "72" }

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
        { x: new Date(2012, 01, 1), y: 71,  indexLabel: "72" }

        ]
      }
      ]
    });

    chart.render();
