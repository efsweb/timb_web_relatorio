	
		if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
		else window.attachEvent('onload', main);

	function main() {
		    lineEHSugestoes();
		    lineEHProduto();
		    lineEHAplicativo();
		}

		// --------- GRÁFICO DE LINHAS EH CONFIGURE ~Sugestoes ------ //
		function lineEHSugestoes() {
		    var data = {
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		            {
		            fillColor : "rgba(66,134,168,1)",
					strokeColor : "rgba(66,134,168,1)",
					pointColor : "rgba(66,134,168,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
		            data : [65,59,90,81,56,55,40,50,60,30,48],
		            label : 'Sugestões'
		        }]
		    };


			var options = 
			    {
			    	animation : false,
			        tooltipTemplate: "<%= value %>",
			        
			        showTooltips: true,
			        
			        onAnimationComplete: function()
			        {   
			            this.showTooltip(this.datasets[0].bars, true);
			        },
			        tooltipEvents: []
			    }


		    var ctx = document.getElementById("eh-grafic-sugestoes").getContext("2d");
		    new Chart(ctx).Bar(data, options);

		}

		// --------- GRÁFICO DE LINHAS EH CONFIGURE ~Produto ------ //
		function lineEHProduto() {
		    var data = {
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		        {
		            fillColor : "rgba(82,204,82,1)",
		            strokeColor : "rgba(82,204,82,1)",
		            pointColor : "rgba(82,204,82,1)",
		            pointStrokeColor : "#fff",
		            pointHighlightFill : "#fff",
		            pointHighlightStroke : "rgba(82,204,82,1)",
		            data : [3,24,65,3,126,43,15,10,20,15,97],
		            label : 'Produto'
		        }]
		    };


			var options = 
			    {
			    	animation : false,
			        tooltipTemplate: "<%= value %>",
			        
			        showTooltips: true,
			        
			        onAnimationComplete: function()
			        {   
			            this.showTooltip(this.datasets[0].bars, true);
			        },
			        tooltipEvents: []
			    }


		    var ctx = document.getElementById("eh-grafic-produto").getContext("2d");
		    new Chart(ctx).Bar(data, options);

		}

		// --------- GRÁFICO DE LINHAS EH CONFIGURE ~Aplicativo ------ //
		function lineEHAplicativo() {
		    var data = {
		        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
		        datasets : [
		        {
		            fillColor : "rgba(92,92,92,1)",
		            strokeColor : "rgba(92,92,92,1)",
		            pointColor : "rgba(92,92,92,1)",
		            pointStrokeColor : "#fff",
		            pointHighlightFill : "#fff",
		            pointHighlightStroke : "rgba(151,187,205,1)",
		            data : [85,9,5,83,56,42,12,100,60,85,47],
		            label : 'Aplicativo'
		        }]
		    };


			var options = 
			    {
			    	animation : false,
			        tooltipTemplate: "<%= value %>",
			        
			        showTooltips: true,
			        
			        onAnimationComplete: function()
			        {   
			            this.showTooltip(this.datasets[0].bars, true);
			        },
			        tooltipEvents: []
			    }


		    var ctx = document.getElementById("eh-grafic-aplicativo").getContext("2d");
		    new Chart(ctx).Bar(data, options);

		}



