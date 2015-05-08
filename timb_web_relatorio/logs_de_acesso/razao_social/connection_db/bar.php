<!doctype html>
<html>
	<head>
		<title>Bar Chart</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"> 
		<meta charset="UTF-8">
	</head>
	<body>

	<script>
	window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",{  
        backgroundColor: "#3d3e3f",
        animationEnabled: true,
        axisY: {
                labelFontSize: 14,
                interval: 500,
                labelAngle: 90,
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
                        { y: 2700, label: "Campo Grande e Administração LTDA.", indexLabel: '2560' },
                        { y: 1705, label: "Com. e Repr. de Automóveis Inter Car LTDA." , indexLabel: '30' },
                        { y: 2983, label: "Rio de Janeiro Comércio de Veículos LTDA.", indexLabel: '252' },
                        { y: 2230, label: "Jabur-Car Imp. e Com. de Veículos LTDA." , indexLabel: '20' },
                        { y: 2380, label: "Vitória Motors LTDA.", indexLabel: '2' },
                        { y: 275, label: "Ago Comercio de Veículos LTDA." , indexLabel: '75' },
                        { y: 34, label: "Rodobens Automóveis Rio Preto LTDA.", indexLabel: '34' },
                        { y: 75, label: "Assis Diesel de Veículos LTDA." , indexLabel: '75' },
                        { y: 102, label: "Jaguardiesel - Jaguaribe Diesel LTDA.", indexLabel: '102' },
                        { y: 75, label: "Consoline Veículos LTDA." , indexLabel: '75' },
                        { y: 102, label: "Comercial de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Gaúcho Diesel S.A.", indexLabel: '102' },
                        { y: 102, label: "Sadive S/A Distribuidora de Veículos", indexLabel: '102' },
                        { y: 102, label: "Araguari Diesel LTDA.", indexLabel: '102' },
                        { y: 102, label: "Comercial Sambaíba de Viaturas LTDA.", indexLabel: '102' },
                        { y: 102, label: "Savarsul Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Sedan Comércio e Importação de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Star Motors Com. de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Stecar Comercial de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Rodobens Caminhões Rondônia LTDA.", indexLabel: '102' },
                        { y: 75, label: "Calisto Diesel de Veículos LTDA." , indexLabel: '75' }, // TERMINA AQUI
                        { y: 102, label: "Sadive S/A Distribuidora de Veículos", indexLabel: '102' },
                        { y: 102, label: "Araguari Diesel LTDA.", indexLabel: '102' },
                        { y: 102, label: "Comercial Sambaíba de Viaturas LTDA.", indexLabel: '102' },
                        { y: 102, label: "Savarsul Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Sedan Comércio e Importação de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Star Motors Com. de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Stecar Comercial de Veículos LTDA.", indexLabel: '102' },
                        { y: 102, label: "Rodobens Caminhões Rondônia LTDA.", indexLabel: '102' },
                        { y: 75, label: "Calisto Diesel de Veículos LTDA." , indexLabel: '75' }
                    ]
                }
            ]
	    });

	chart.render();
	}

	</script>

		<div class="graficos">
			<div id="chartContainer" style="height: 800px; width: 700px;">
		</div>


		<script src="js/canvasjs.min.js"></script>

	</body>
</html>
