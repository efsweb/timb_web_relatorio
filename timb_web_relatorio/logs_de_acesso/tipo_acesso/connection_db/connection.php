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
  }

  /**
   * Invoca a procedure a ser utilizada
   * @param  [type] $proc_string String com o nome da SP
   * @param  [type] $params      String com o valor dos parametros da SP separados por ","
   * @return [type]              Retorna a resposta da SP do banco
   */
  public function call_precedure($proc_string, $params){
      $pieces = explode(",", $params);
      $params_str = str_repeat('?,', count($pieces) - 1) . '?';
      $stmt = $this->link->prepare("call ".$proc_string."(". $params_str .")");
      
      for ($i=0; $i < sizeof($pieces); $i++) {
        $val = $pieces[$i];
        $val = substr($val, 0, -1);
        $val = substr($val, 1, strlen($val)-1);
        $pos = $i + 1;
        $stmt->bindValue($pos, "$val" , PDO::PARAM_STR);
      }
      $rs = $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return json_encode($result);
  }
}

?>