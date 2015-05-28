<?php 
	require_once '../../config/connection.php';
	
	$id_chamado = $_REQUEST['id'];

	function detalhe_chamado($chamado){
		$chamado_mysql = new connect_mysql();
		$chamado_mysql->parametro = "'detalhamento_chamado'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
		$chamado_mysql->parametro_2 = "'".$chamado."'"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
		$chamado_mysql->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO

		$chamado_dados = $chamado_mysql->result_proc;
		//var_dump($chamado_dados);
		$chamado_dados[0]['data'] = date("d/m/Y H:i:s",strtotime($chamado_dados[0]['data']));
		
		return implode('##',$chamado_dados[0]);

	}

	echo detalhe_chamado($id_chamado);

?>