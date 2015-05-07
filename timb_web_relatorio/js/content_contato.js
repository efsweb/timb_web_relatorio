var conteudo;
$(document).ready(function () {
	
	//$.get('feed_contato.php', function(result){
    $.get('feed_contato.php', function(result){
		obj = JSON && JSON.parse(result) || $.parseJSON(result);
		
		new Morris.Line({
		  element: 'eh',
		  data: obj.evoTD,
		  xkey: 'period',
		  ykeys: ['Android','ipad','Web'],
		  labels: ['ANDROID','IPAD','WEB'],
		  xLabelAngle: 0,
		   xLabelFormat: function(d) { return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear(); },
		  xLabels: 'day'
		});
});