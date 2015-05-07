var conteudo;
 function alimentaTable(id, obj){
    var tblBody = document.getElementById(id);
    obj.forEach(function(entry){
        
        //for
        var row = document.createElement("tr");

        var dataMail = document.createAttribute('data-email');
        dataMail.value = entry['email'];

        var dataTel = document.createAttribute('data-tel');
        dataTel.value = entry['tel'];

        var datamsg = document.createAttribute('data-msg');
        datamsg.value = entry['msg'];

        var datanome = document.createAttribute('data-nome');
        datanome.value = entry['nome'];

        var dataNatureza = document.createAttribute('data-natureza');
        dataNatureza.value = entry['natureza'];

        var dataDia = document.createAttribute('data-dia');
        dataDia.value = entry['dia'];

        var dataDdiaComplet = document.createAttribute('data-diacomplet');
        dataDdiaComplet.value = entry['diacomplet'];


        row.setAttributeNode(dataMail);
        row.setAttributeNode(dataTel);
        row.setAttributeNode(datamsg);
        row.setAttributeNode(datanome);
        row.setAttributeNode(dataNatureza);
        row.setAttributeNode(dataDia);
        row.setAttributeNode(dataDdiaComplet);

        var cell1 = document.createElement("td");
        var shortName = entry['nome'].substr(0, 20);
        var cellText1 = document.createTextNode(shortName);
        cell1.appendChild(cellText1);
        var cell2 = document.createElement("td");
        var cellText2 = document.createTextNode(entry['natureza']);
        cell2.appendChild(cellText2);
        var cell3 = document.createElement("td");
        var cellText3 = document.createTextNode(entry['dia']);
        cell3.appendChild(cellText3);
        
        row.appendChild(cell1);
        row.appendChild(cell2);
        row.appendChild(cell3);

        tblBody.appendChild(row);


    });
}

$(document).ready(function () {
	/*$("#printBTN").on('click', function(e){
       console.log("print");
      //  window.print();
    }); */

document.getElementById("tab-1").checked=true;
document.getElementById("tab-6").checked=true;
	$.get('http://www.truckinfomb.com.br/timb_web_relatorio/feed.php', function(result){
        //$.get('http://www.thiagocarpi.com.br/timb_web_relatorio/feed.php', function(result){
		//console.log("print do php" + result);
        obj = JSON && JSON.parse(result) || $.parseJSON(result);
		//console.log(obj.so)
        var eh = new Morris.Line({
          element: 'eh',
          data: obj.eh,
          xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            labels: ['sugestoes', 'aplicativo', 'produto']
        });
        var ehTotal2 = new Morris.Bar({
          element: 'total',
          data: obj.ehTotal,
          xkey: 'y',
            ykeys: ['a'],
            labels: ['Quantidade'],
            barColors: function (row, series, type) {
                if (type === 'bar') {
                   // console.log(row.label);
                    switch(row.label){
                        case 'aplicativo':
                            return '#7a92a3';
                            break
                        case 'conteúdo':
                            return '#4da74d';
                            break
                        case 'sugestão':
                            return '#0b62a4';
                            break
                        default:
                            break;
                    }
                  return '#000';
                }
                else {
                  return '#000';
                }
          }
        });
//console.log(obj.ehTable);
       alimentaTable('tBody-example', obj.ehTable);
       alimentaTable('tBody-example-total', obj.ehTable);
        $('#example').dataTable({
            "iDisplayLength": 20,
            "columnDefs": [ 
                {
                    "targets": [ 2 ],
                    "visible": true,
                    "searchable": true
                }
            ],
            "sDom" : "<'dataTables_header clearfix'<'col-md-6'><'col-md-6'>r>t<'dataTables_footer clearfix'<'col-md-5'f><'col-md-7'p>>",
            "oLanguage": {
                "sLengthMenu": "Mostrando _MENU_ registros por página",
                "sZeroRecords": "Nenhum resultado encontrado",
                "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                'sSearch' : '',
                "oPaginate": {"sPrevious": "", "sNext": ""}
            },
            "bAutoWidth": false,
            "columns" :[{"sWidth":"50%"},{"sWidth":"30%"},{"sWidth":"20%"}],
            "paging":   true,
            "ordering": true,
            "info":     false,
            "lengthMenu": [ 4 ],
            "pageLength": 4,
            fnDrawCallback : function() {
                 var o = $(this).closest(".dataTables_wrapper").find("div[id$=_filter] input")
                   if(o.parent().hasClass("input-group"))
                    return;
            
                o.addClass("form-control filterSearch1");
                o.closest('.col-md-6').prev().css('padding-left', '0');
                o.closest('.col-md-6').css('padding-right', '0');
                 o.closest('.col-md-6').css('padding-top', '5');
                 o.closest('.col-md-6').css('padding-bottom', '5');
                o.attr('placeholder', 'Filtro');
                o.wrap('<div class="input-group"></div>');
                o.parent().prepend('<span class="input-group-addon"><i class="icon-search"></i></span>');
            }, 
            "stripeClasses":[],
            fnInitComplete: function ( oSettings )
            {
                //console.log(oSettings.aoData.length);
                for ( var i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
                {
                    //console.log(oSettings.aoData[i]._aData[1]);

                    switch(oSettings.aoData[i]._aData[1]){
                        case 'aplicativo':
                            oSettings.aoData[i].nTr.className += " aplicativo";
                            break
                        case 'conteúdo':
                            oSettings.aoData[i].nTr.className += " conteudo";
                            break
                        case 'sugestão':
                            oSettings.aoData[i].nTr.className += " sugestao";
                            break
                        default:
                            break;
                    }
                    //oSettings.aoData[i].nTr.className += " "+oSettings.aoData[i]._aData[1];
                }
            }
        } );
        $('#example > tbody').on('click', 'tr', function(e){
            ///console.log($(this).data('nome'));
            $('#panel-nome').html($(this).data('nome'));
            //console.log($(this).data('email'));
            $('#panel-mail').html($(this).data('email'));
            //console.log($(this).data('tel'));
            $('#panel-tel').html($(this).data('tel'));

            $('#panel-dataComplet').html($(this).data('diacomplet'));            
            //console.log($(this).data('msg'));
            $('#panel-msg').html($(this).data('msg'));
           // console.log($(this).data('natureza'));
           $('#panel-natureza').removeClass($('#panel-natureza').attr('class'));
           $('#panel-natureza').addClass('col-md-4 border natureza');
           switch($(this).data('natureza')){
                        case 'aplicativo':
                            $('#panel-natureza').addClass('aplicativo');
                            break
                        case 'conteúdo':
                            $('#panel-natureza').addClass('conteudo');
                            break
                        case 'sugestão':
                            $('#panel-natureza').addClass('sugestao');
                            break
                        default:
                            break;
                    }
            //$('#panel-natureza').addClass($(this).data('natureza'));
            //console.log($('#panel-natureza').attr('class') );
        });
       
       var tableTotal = $('#example-total').dataTable({
        "iDisplayLength": 20,
        "columnDefs": [ 
                {
                    "targets": [ 2 ],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [0],
                    "width": "20%"
                }
            ],
            "sDom" : "<'dataTables_header clearfix'<'col-md-6'><'col-md-6'>r>t<'dataTables_footer clearfix'<'col-md-5'f><'col-md-7'p>>",
            "oLanguage": {
                "sLengthMenu": "Mostrando _MENU_ registros por página",
                "sZeroRecords": "Nenhum resultado encontrado",
                "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                'sSearch' : '',
                "oPaginate": {"sPrevious": "", "sNext": ""}
            },
            "bAutoWidth": false,
            "columns" :[{"sWidth":"50%"},{"sWidth":"30%"},{"sWidth":"20%"}],
            "paging":   true,
            "ordering": true,
            "info":     false,
            "lengthMenu": [ 4 ],
            "pageLength": 4,
            fnDrawCallback : function() {
                 var o = $(this).closest(".dataTables_wrapper").find("div[id$=_filter] input")
                   if(o.parent().hasClass("input-group"))
                    return;
            
                o.addClass("form-control filterSearch");
                o.closest('.col-md-6').prev().css('padding-left', '0');
                o.closest('.col-md-6').css('padding-right', '0');
                 o.closest('.col-md-6').css('padding-top', '5');
                 o.closest('.col-md-6').css('padding-bottom', '5');
                o.attr('placeholder', 'Filtro');
                o.wrap('<div class="input-group"></div>');
                o.parent().prepend('<span class="input-group-addon"><i class="icon-search"></i></span>');
                
            }, 
            "stripeClasses":[],
            fnInitComplete: function ( oSettings )
            {
                //console.log(oSettings.aoData.length);
                for ( var i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
                {
                   switch(oSettings.aoData[i]._aData[1]){
                        case 'aplicativo':
                            oSettings.aoData[i].nTr.className += " aplicativo";
                            break
                        case 'conteúdo':
                            oSettings.aoData[i].nTr.className += " conteudo";
                            break
                        case 'sugestão':
                            oSettings.aoData[i].nTr.className += " sugestao";
                            break
                        default:
                            break;
                    }
                }
            }
        } );
       

        $('#example-total > tbody').on('click', 'tr', function(e){
            //console.log($(this).data('nome'));
            $('#panel-total-nome').html($(this).data('nome'));
            //console.log($(this).data('email'));
            $('#panel-total-mail').html($(this).data('email'));
            //console.log($(this).data('tel'));
            $('#panel-total-tel').html($(this).data('tel'));
            //console.log($(this).data('diacomplet'));
            $('#panel-total-dataComplet').html($(this).data('diacomplet'));   
            //console.log($(this).data('msg'));
            $('#panel-total-msg').html($(this).data('msg'));
            //console.log($(this).data('natureza'));
           $('#panel-total-natureza').removeClass($('#panel-total-natureza').attr('class'));
           $('#panel-total-natureza').addClass('col-md-4 border natureza');
           switch($(this).data('natureza')){
                        case 'aplicativo':
                            $('#panel-total-natureza').addClass('aplicativo');
                            break
                        case 'conteúdo':
                            $('#panel-total-natureza').addClass('conteudo');
                            break
                        case 'sugestão':
                            $('#panel-total-natureza').addClass('sugestao');
                            break
                        default:
                            break;
                    }
           // console.log($('#panel-natureza').attr('class') );
        });

        
        

        $("svg rect").on('click', function(e){
            switch($(this).attr('fill')){
                case '#7a92a3':
                    $('#example-total').dataTable().fnFilter('aplicativo');
                    $('.filterSearch').val('aplicativo');
                    break;
                case '#4da74d':
                    $('#example-total').dataTable().fnFilter('conteúdo');
                    $('.filterSearch').val('conteúdo');
                    break;
                case '#0b62a4':
                    $('#example-total').dataTable().fnFilter('sugestão');
                    $('.filterSearch').val('sugestão');
                    break;
            }
        });

        $("svg tspan").on('click', function(e){
            //console.log($(this).html());
            var str = $(this).html();
            //console.log((str.indexOf("/") > -1) ? 'tem' : 'nao');
            if(str.indexOf("/") > -1){
                //console.log('oi');
                $('#example').dataTable().fnFilter(str);
                $('.filterSearch1').val(str);
            }
        });

        //$('#eh SVG').height(225);
        /*var gb = new Morris.Bar({
		  element: 'graph-bar',
		   data:obj.cargo,
		  xkey: 'x',
		  ykeys: 'v',
		  xLabelAngle: 55,
		  labels: ['valor']
    		}).on('click', function(i, row){
    		  console.log(i, row);
    		});*/
		/*var evot = new Morris.Line({
		  element: 'evoT',
		  data: obj.evoT,
		  xkey: 'ano',
		  ykeys: ['v'],
		  labels: ['valor']
		});*/
		/*$('.graph-bar SVG').height(420);
		var evotd = new Morris.Line({
		  element: 'evoTD',
		  data: obj.evoTD,
		  xkey: 'period',
		  ykeys: ['Android','ipad','Web'],
		  labels: ['ANDROID','IPAD','WEB'],
		  xLabelAngle: 0,
		   xLabelFormat: function(d) { return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
		  xLabels: 'day'
		});*/

        

		/*$('div#my-treemap').treemap(obj.razao, {
			nodeClass: function(node, box){
				return 'major';
			},
			mouseenter: function (node, box) {
				//$('#data-box').html('<p>Label: ' + node.label + '</p><p>Data:' + node.data + '</p><p>Value:' + node.value + '</p>');
                 //console.log(box.currentTarget.style.top+ " | "+ box.currentTarget.style.left+ " | "+$('#'+box.currentTarget.id).parent().width());
                 //console.log(($('#'+box.currentTarget.id).parent().width()/2) + " | " + box.currentTarget.style.left);
                 var pos =  'left';
                 var w = parseInt($('#'+box.currentTarget.id).parent().width()/2);
                 var l = parseInt(box.currentTarget.style.left);
                 if( l < w){
                   //console.log('if');
                    pos = 'right';
                 }
                 //console.log(w+ ' | '+ l + ' | '+pos);

                 var str = node.data;
                 var myArray = str.split('|');
                 var data = "";
                // display the result in myDiv
                for(var i=0;i<myArray.length-1;i++){
                    data += ("<div class='size12 "+ ((i<myArray.length-2) ? "dashed" : "" )+ "'>"+myArray[i]+"</div>");
                }
                 $($('#'+box.currentTarget.id)).tooltip({
                    html: true,
                    title : '<p>' + data + '</p>',
                    placement: pos               
                  })
            },
			itemMargin: 2
		});*/


		//var rawData = [[1582.3, 0], [28.95, 1],[1603, 2],[774, 3],[1245, 4], [85, 5],[1025, 6]];
		var rawData = new Array();
        //var ticks = [[0, "Gold"], [1, "Silver"], [2, "Platinum"], [3, "Palldium"], [4, "Rhodium"], [5, "Ruthenium"], [6, "Iridium"]];
        var ticks = new Array();
 		var maxW = 0;
 		for (var i = obj.so.length - 1; i >= 0; i--) {
 			//console.log(obj.so[i].value);
 			rawData[i] = new Array(obj.so[i].value, i);
 			maxW =  maxW + obj.so[i].value;
 			ticks[i] = new Array(i, obj.so[i].data);
 		};
 		//console.log(rawData);
 		//console.log(ticks);
 		maxW = maxW;
 		var colorBars = ["#00ff00", "#00FF00"];
 		var dataSet = [{ label: "", data: rawData, color: colorBars }];
        var options = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: "center",
                barWidth: 0.5,
                horizontal: true,
                fillColor: { colors: colorBars },
                lineWidth: 1
            },
            xaxis: {
                axisLabel: "Usuarios",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                max: maxW,
                tickColor: "#5E5E5E",
                tickFormatter: function (v, axis) {
                    return $.formatNumber(v, { format: "#,###", locale: "us" });
                },
                color: "black"
            },
            yaxis: {
                axisLabel: "Devices",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                tickColor: "#5E5E5E",
                ticks: ticks,
                color: "black"
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#858585",
                position: "ne"
            },
            grid: {
                hoverable: true,
                borderWidth: 2,
                backgroundColor: { colors: ["#FFFFFF", "#FFFFFF"] }
            }
        };
 
        $(document).ready(function () {
            //$.plot($("#device"), dataSet, options);
        });
 
        var previousPoint = null, previousLabel = null;
 
        $.fn.UseTooltip = function () {
            $(this).bind("plothover", function (event, pos, item) {
                if (item) {
                    if ((previousLabel != item.series.label) ||
                 (previousPoint != item.dataIndex)) {
                        previousPoint = item.dataIndex;
                        previousLabel = item.series.label;
                        $("#tooltip").remove();
 
                        var x = item.datapoint[0];
                        var y = item.datapoint[1];
 
                        var color = item.series.color;
                        //alert(color)
                        //console.log(item.series.xaxis.ticks[x].label);               
 
                        showTooltip(item.pageX,
                        item.pageY,
                        color,
                        "<strong>" + item.series.label + "</strong><br>" + item.series.yaxis.ticks[y].label +
                        " : <strong>" + $.formatNumber(x, { format: "#,###", locale: "us" }) + "</strong> USD/oz");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        };
 
        function showTooltip(x, y, color, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 10,
                left: x + 10,
                border: '2px solid ' + color,
                padding: '3px',
                'font-size': '9px',
                'border-radius': '5px',
                'background-color': '#fff',
                'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                opacity: 0.9
            }).appendTo("body").fadeIn(200);
        }
	});	

});