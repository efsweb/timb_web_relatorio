if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
else window.attachEvent('onload', main);

// --------- CHAMADA DOS GRÁFICOS ------ //

function main() {
    lineChartIOS();
    lineChartAndroid();
    lineChartWeb();
}

// --------- IOS CONFIGURE ------ //
function lineChartIOS() {
    var data = {
        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [65,59,90,81,56,55,40,50,60,30,48],
            label : 'IOS'
        }]
    };

    var ctx = document.getElementById("ios-canvas").getContext("2d");
    new Chart(ctx).Line(data);
}


// --------- ANDROID CONFIGURE ------ //

function lineChartAndroid() {
    var data = {
        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [65,59,90,81,56,55,40,50,60,30,48],
            label : 'Android'
        }]
    };

    var ctx = document.getElementById("android-canvas").getContext("2d");
    new Chart(ctx).Line(data);
}


// --------- WEB CONFIGURE ------ //

function lineChartWeb() {
    var data = {
        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
        datasets : [
            {
            fillColor : "rgba(66,134,168,0.2)",
            strokeColor : "rgba(66,134,168,1)",
            pointColor : "rgba(66,134,168,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [65,59,90,81,56,55,40,50,60,30,48],
            label : 'Android'
        }]
    };

    var ctx = document.getElementById("web-canvas").getContext("2d");
    new Chart(ctx).Line(data);
}