<?php 
	require_once '../../config/connection.php';
	
	$id_chamado = $_REQUEST['id'];

	$chamado_mysql = new connect_mysql();
	$chamado_mysql->parametro = "'detalhamento_chamado'"; //PARAMETRO DETERMINADO PARA CADA GRAFICO
	$chamado_mysql->parametro_2 = "'".$id_chamado."'"; //SEGUNDO PARAMETRO DETERMINADO PARA CADA GRAFICO
	$chamado_mysql->connection(); //FUNCAO QUE TRAZ TODOS OS DADOS DO GRAFICO

	$chamado_dados = $chamado_mysql->result_proc;

	 echo json_encode($chamado_dados);

?>