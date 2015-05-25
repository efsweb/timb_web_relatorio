 var chart = new CanvasJS.Chart("grafico-cargo",
    {
      backgroundColor: "transparent",
      animationEnabled: false,
      axisX: {
        indexLabelFontColor: "white",
        labelFontSize: 15,
        interval: 1,
      },
      axisY: {
        indexLabelFontColor: "white",
        labelFontSize: 13,
        gridColor: "#BBBBBB",
        interval: 100,
        labelAngle: 90,
      },
      data: [
      {        
        indexLabelFontSize: 16,
        indexLabelPlacement: "outside",
        indexLabelFontColor: "#4A4B4C",
        indexLabelFontWeight: 600,
        indexLabelFontFamily: "roboto",        
        type: "bar",
        color: "#5E98B6",
        dataPoints: [
         { y: 1136, label: "Vendedor", indexLabel: "1136"  },
         { y: 299, label: "Assistente", indexLabel: "299"  },
         { y: 251, label: "Colaborador", indexLabel: "251"  },
         { y: 211, label: "Gerente", indexLabel: "211"  },
         { y: 114, label: "Diretor", indexLabel: "114"  },
         { y: 85, label: "Multiplicador Starclass", indexLabel: "85"  },
         { y: 68, label: "Premiação Starclass", indexLabel: "68"  } 
        ]
      }
      ]
    });

chart.render();