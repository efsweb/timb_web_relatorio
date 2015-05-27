<?php 
header("Content-Type: text/html; charset=ISO-8859-1",true); //DECODIFICA OS CARACTERES ESPECIAIS VINDOS DO BANCO
class connect_mysql{
   
  //RESULTADO DO GRAFICO DE LINHAS - PRO MES
  public $result_proc;

  //VARIAVEL PARA ARMAZENAR O VALOR DE PARAMETRO DE CADA PAGINA
  public $parametro;

  //METODO CONSTRUTOR -- 
  //NAO INVOCO NADA NESTA FUN��O POIS AINDA N�O RECEBI A VARIAVEL PARAMENTRO DO ARQUIVO QUE POSSUI O GRAFICO
  function connect_mysql(){

  }
  
  //ESTA FUN��O AO SER CHAMADA PELOS ARQUIVOS DE GRAFICO - J� DECLARAM A VARIAVEL paramentro PARA CADA TIPO DE GRAFICO
  //ADMINISTRA A CONEXAO E INVOCA A FUNCAO PARA EXECUCAO DAS QUERYS
  function connection(){
    $conection = $this->prepara_conection();
    $this->execute_mysql($conection);
  }

  //FUNCAO RESPONSAVEL PELA EXECUCAO DAS QUERYS E PROCEDURES
  function execute_mysql($conection){

    $this->connection_procedure($conection);
  }

  //PREPARA OS DADOS PARA A CONEXAO E REALIZA A CONEXAO
  function prepara_conection(){    

    $servidor = 'dbmy0052.whservidor.com';
    $banco = 'truckinfom';
    $usuario = 'truckinfom';
    $senha = 'chap1982';
    $mysqli = mysqli_connect($servidor, $usuario, $senha, $banco);
    return $mysqli;
  }

    //PARA REALIZAR A CONEX�O RECEBE COMO PARAMETRO A CONEX�O
  public function connection_procedure($mysqli){

    // PARAMETROS PARA CHAMAR A FUNCAO QUE EXECUTA PROCEDURE
    $procedure = 'sp_timb_rel_gerencial'; //NOME DA PROCEDURE
    $parametro = $this->parametro;
    $parametro_2 = $this->parametro_2;
    $flag = false;
    $array_true_flag_contato = array("'grafico_linha'","'grafico_total'","'detalhamento_chamado'");
    $array_true_flag_log_acesso = array("'plataforma'","'dispositivo'","'cargo'", "'razao_social'");
    if(in_array($parametro, $array_true_flag_log_acesso)){
      $flag = true;
    }elseif(in_array($parametro, $array_true_flag_contato)){
      $flag = true;
    }
      //$parametro = "'acesso'"; //PARAMETRO PASSADO PARA A PROCEDURE  

    $this->result_proc = $this->call_procedure($procedure,$parametro,$parametro_2, $mysqli, $flag); //$result_proc -> RECEBE O RESULTADO DA PROCEDURE

    return $this->result_proc;

  }
  /**
   * Invoca a procedure a ser utilizada
   * @param  [type] $proc_string String com o nome da SP
   * @param  [type] $params      String com o valor dos parametros da SP separados por ","
   * @param  [type] $mysqli      Conex�o do banco      
   * @param  [boolean] $flag     Para trazer o resultado em MYSQL_ASSOC ou n�o
   * @return [type]              Retorna a resposta da SP do banco
   */
  public function call_procedure($proc_string, $params, $params_2, $mysqli,$flag=false){
        $stmt = mysqli_query($mysqli,("CALL $proc_string($params,$params_2);")) or die($mysqli->error. " <- ERROR" );
        if(!$flag){
          $result= mysqli_fetch_all($stmt); //RESULTADOS DA QUERY DA PROCEDURE  
        }else{
          $result= mysqli_fetch_all($stmt,MYSQL_ASSOC); //RESULTADOS DE FORMA ASSOCIATIVA - QUERY DA PROCEDURE 
        }
        
      return $result;
  }
}

?>