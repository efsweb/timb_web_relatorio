<?php 
class connect_mysql{
    
  public $servidor;
  public $banco;
  public $usuario;
  public $senha;
  public $link;   
  public $result_IOS;
  public $result_ANDROID;

  function connect_mysql(){
    
    $conection = $this->prepara_conection();
    
    $this->select_sql($conection);

    $this->connection_procedure($conection);
  }

  function prepara_conection(){
    $this->servidor = 'dbmy0052.whservidor.com';
    $this->banco = 'truckinfom';
    $this->usuario = 'truckinfom';
    $this->senha = 'chap1982';
    $mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->banco);
    return $mysqli;
  }

  function select_sql($mysqli){
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "IOS" ';
    $rs = $mysqli->query($sql);
    $this->result_IOS = mysqli_fetch_row($rs);
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "Android" ';
    $rs = $mysqli->query($sql);
    $this->result_ANDROID = mysqli_fetch_row($rs);
  }



    //PARA REALIZAR A CONEXÃO RECEBE COMO PARAMETRO A CONEXÃO
  public function connection_procedure($mysqli){
    
    // PARAMETROS PARA CHAMAR A FUNCAO QUE EXECUTA PROCEDURE 
    $procedure = 'sp_timb_fe_relatorio'; //NOME DA PROCEDURE
    $parametro = 'acesso'; //PARAMETRO PASSADO PARA A PROCEDURE
    $result_proc = $this->call_procedure($procedure,$parametro, $mysqli); //$result_proc -> RECEBE O RESULTADO DA PROCEDURE

    return $result_proc;

  }
  /**
   * Invoca a procedure a ser utilizada
   * @param  [type] $proc_string String com o nome da SP
   * @param  [type] $params      String com o valor dos parametros da SP separados por ","
   * @param  [type] $mysqli      Conexão do banco      
   * @return [type]              Retorna a resposta da SP do banco
   */
  public function call_procedure($proc_string, $params,$mysqli){
      
      $DBH = $mysqli->stmt_init(); //INICIALIZA UMA DECLARA PARA SER UTILIZADA PELA FUNCAO "prepare()"
      
      if($DBH->prepare("CALL ".$proc_string."('". $params."')")){ //VERIFICA SE A PROCEDURE ESTA CORRETA - @return [true/false]

        $stmt = $mysqli->query("CALL ".$proc_string."('". $params ."')"); //EXECUTA A PROCEDURE
        $result = mysqli_fetch_all($stmt); //RESULTADOS DA QUERY DA PROCEDURE
      } 

      return json_encode($result);
  }
}

?>