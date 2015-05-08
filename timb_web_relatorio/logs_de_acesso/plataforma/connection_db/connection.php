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
    $this->prepara_conection();
    $this->select_sql();
  }

  function prepara_conection(){
    $this->servidor = 'dbmy0052.whservidor.com';
    $this->banco = 'truckinfom';
    $this->usuario = 'truckinfom';
    $this->senha = 'chap1982';
    $this->link = mysql_connect($this->servidor, $this->usuario, $this->senha);
    $db = mysql_select_db($this->banco, $this->link); 
  }

  function select_sql(){
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "IOS" ';
    $rs = mysql_query($sql);
    $this->result_IOS = mysql_fetch_row($rs);
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "Android" ';
    $rs = mysql_query($sql);
    $this->result_ANDROID = mysql_fetch_row($rs);
    
    // PARAMETROS PARA CHAMAR A FUNCAO QUE EXECUTA PROCEDURE
    $procedure = 'sp_timb_fe_relatorio';
    $parametro = 'acesso';
    $result_proc = $this->call_procedure($procedure,$parametro);
  }



  /**
   * Invoca a procedure a ser utilizada
   * @param  [type] $proc_string String com o nome da SP
   * @param  [type] $params      String com o valor dos parametros da SP separados por ","
   * @return [type]              Retorna a resposta da SP do banco
   */
  public function call_procedure($proc_string, $params){

      $mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->banco);
     
      $DBH = $mysqli->stmt_init();

      if($DBH->prepare("CALL ".$proc_string."('". $params."')")){

        $stmt = $mysqli->query("CALL ".$proc_string."('". $params ."')");
        $rs = mysqli_fetch_all($stmt);
        
      }
        var_dump($rs); exit;  
    
      return json_encode($result);
  }
}

?>