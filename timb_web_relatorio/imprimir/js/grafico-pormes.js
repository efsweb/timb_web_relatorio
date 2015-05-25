if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
else window.attachEvent('onload', main);

  /* -------------------------------------------------*/
  /* ---------->>> CHAMADA DOS GRÁFICOS <<<----------*/
  /* -----------------------------------------------*/

function main() {
    lineChartIOS();
    lineChartAndroid();
    lineChartWeb();
}

  /* ------------------------------------------------*/
  /* ---------->>> GRÁFICO IOS <<<-------------------*/
  /* -----------------------------------------------*/
function lineChartIOS() {
    var data = {
        labels : 
        ["January", "February", "March", "April", "May", "June", "July"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 86, 27, 90],
            label : 'IOS'
        }]
    }

    var options = 
    {   
        animation : false,
        tooltipTemplate: "<%= value %>",
        
        showTooltips: true,
        
        onAnimationComplete: function()
        {    
            this.showTooltip(this.datasets[0].points, true);          
        },
        tooltipEvents: []
    };

    var ctx = document.getElementById("pormes-ios").getContext("2d");
    new Chart(ctx).Line(data, options);
}


  /* ------------------------------------------------*/
  /* ------------->>> GRÁFICO ANDROID <<<-----------*/
  /* -----------------------------------------------*/

function lineChartAndroid() {
    var data = {
        //STRING DOS MESES
        labels : 
        ["January", "February", "March", "April", "May", "June", "July"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            //DADOS DO BANCO - PARA PREENCHER O GRAFICO
            data : 
            [65, 59, 80, 81, 56, 55, 40],
            label : 'Android'
        }]
    }

    var options = 
    {
        animation : false,
        tooltipTemplate: "<%= value %>",
        
        showTooltips: true,
        
        onAnimationComplete: function()
        {    
            this.showTooltip(this.datasets[0].points, true);          
        },
        tooltipEvents: []
    };

    var ctx = document.getElementById("pormes-android").getContext("2d");
    new Chart(ctx).Line(data, options);
}

  /* ------------------------------------------------*/
  /* ------------->>> GRÁFICO WEB <<<----------------*/
  /* -----------------------------------------------*/

function lineChartWeb() {
    var data = {
        //STRING DOS MESES
        labels : 
        ["January", "February", "March", "April", "May", "June", "July"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            //DADOS DO BANCO - PARA PREENCHER O GRAFICO
            data : 
            [65, 59, 80, 81, 56, 55, 40],
            label : 'IOS'
        }]
    }

    var options = 
    {
        animation : false,
        tooltipTemplate: "<%= value %>",
        
        showTooltips: true,
        
        onAnimationComplete: function()
        {    
            this.showTooltip(this.datasets[0].points, true);          
        },
        tooltipEvents: []
    };

    var ctx = document.getElementById("pormes-web").getContext("2d");
    new Chart(ctx).Line(data, options);
}