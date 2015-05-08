if(!!(window.addEventListener)) window.addEventListener('DOMContentLoaded', main);
else window.attachEvent('onload', main);

// --------- CHAMADA DOS GRÁFICOS ------ //

function main() {
    lineChartIOS();
}

// --------- GRÁFICO DE LINHAS EH CONFIGURE ------ //
function lineChartIOS() {
    var data = {
        labels : ["Jan","Fev","Mar","Abr","Mai","Jun","Jul", "Ago", "Set", "Out", "Dez"],
        datasets : [
            {
            fillColor : "transparent",
			strokeColor : "rgba(66,134,168,1)",
			pointColor : "rgba(66,134,168,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
            data : [65,59,90,81,56,55,40,50,60,30,48],
            label : 'Sugestões'
        },
        {
            fillColor : "transparent",
            strokeColor : "rgba(82,204,82,1)",
            pointColor : "rgba(82,204,82,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(82,204,82,1)",
            data : [3,24,65,3,126,43,15,10,20,15,97],
            label : 'Produto'
        },
        {
            fillColor : "transparent",
            strokeColor : "rgba(92,92,92,1)",
            pointColor : "rgba(92,92,92,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [85,9,5,83,56,42,12,100,60,85,47],
            label : 'Aplicativo'
        }]
    };

    var ctx = document.getElementById("ios-canvas").getContext("2d");
    new Chart(ctx).Line(data);

    legend(document.getElementById("lineLegend"), data);

}

function legend(parent, data) {
    legend(parent, data, null);
}

function legend(parent, data, chart) {
    parent.className = 'legend';
    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

    // remove possible children of the parent
    while(parent.hasChildNodes()) {
        parent.removeChild(parent.lastChild);
    }

    var show = chart ? showTooltip : noop;
    datas.forEach(function(d, i) {
        //span to div: legend appears to all element (color-sample and text-node)
        var title = document.createElement('div');
        title.className = 'title';
        parent.appendChild(title);

        var colorSample = document.createElement('div');
        colorSample.className = 'color-sample';
        colorSample.style.backgroundColor = d.hasOwnProperty('strokeColor') ? d.strokeColor : d.color;
        colorSample.style.borderColor = d.hasOwnProperty('fillColor') ? d.fillColor : d.color;
        title.appendChild(colorSample);

        var text = document.createTextNode(d.label);
        text.className = 'text-node';
        title.appendChild(text);

        show(chart, title, i);
    });
}


// --------- LEGENDA DE GRÁFICO EH ------ //

//add events to legend that show tool tips on chart
function showTooltip(chart, elem, indexChartSegment){
    var helpers = Chart.helpers;

    var segments = chart.segments;
    //Only chart with segments
    if(typeof segments != 'undefined'){
        helpers.addEvent(elem, 'mouseover', function(){
            var segment = segments[indexChartSegment];
            segment.save();
            segment.fillColor = segment.highlightColor;
            chart.showTooltip([segment]);
            segment.restore();
        });

        helpers.addEvent(elem, 'mouseout', function(){
            chart.draw();
        });
    }
}

function noop() {}



