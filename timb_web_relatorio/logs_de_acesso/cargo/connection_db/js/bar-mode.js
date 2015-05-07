window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",{  
        backgroundColor: "#3d3e3f",
        animationEnabled: true,
        axisY: {
                labelFontSize: 12,
                interval: 500,
            },
        axisX: {
                labelFontSize: 14,
                interval: 1,
                valueFormatString: " ",
                tickLength: null
            },
        data: 
            [
                {        
                    indexLabelFontSize: 20,
                    indexLabelPlacement: "outside",
                    indexLabelFontColor: "#fff",
                    indexLabelFontWeight: "normal",
                    indexLabelFontFamily: "Verdana",        
                    type: "bar",
                    color: "#00AEF0",
                    dataPoints: 
                    [
                        { y: 3320, label: "Assistente", indexLabel: '3320' },
                        { y: 119, label: "Colaborador" , indexLabel: '119' },
                        { y: 332, label: "Diretor", indexLabel: '332' },
                        { y: 435, label: "Entregador Técnico" , indexLabel: '435' },
                        { y: 200, label: "F&I", indexLabel: '200' },
                        { y: 75, label: "Gerente" , indexLabel: '75' },
                        { y: 34, label: "Gerente Geral", indexLabel: '34' },
                        { y: 75, label: "Instrutor de Operações" , indexLabel: '75' },
                        { y: 102, label: "Marketing", indexLabel: '102' },
                        { y: 75, label: "Multiplicador Star Class" , indexLabel: '75' },
                        { y: 102, label: "Premiação Star Class", indexLabel: '102' },
                        { y: 102, label: "Proprietário", indexLabel: '102' },
                        { y: 102, label: "Representante", indexLabel: '102' },
                        { y: 102, label: "Supervisor", indexLabel: '102' },
                        { y: 75, label: "Vendedor" , indexLabel: '75' }
                    ]
                }
            ]
    });

chart.render();
}