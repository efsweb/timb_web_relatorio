<?php 
class connect_mysql{
   
  //RESULTADO DO GRAFICO DE BARRA - DISPOSITIVOS -  
  public $result_IOS;
  public $result_ANDROID;

  //RESULTADO DO GRAFICO DE LINHAS - PRO MES
  public $result_proc;

  //ADMINISTRA A CONEXAO E INVOCA A FUNCAO PARA EXECUCAO DAS QUERYS
  function connect_mysql(){
    $conection = $this->prepara_conection();
    $this->execute_mysql($conection);
  }

  //FUNCAO RESPONSAVEL PELA EXECUCAO DAS QUERYS E PROCEDURES
  function execute_mysql($conection){
    $this->select_sql_disp_plat($conection);

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

  //EXECUTA O SELECT PARA OS GRAFICOS DE BARRA - DIPOSISTIVOS E PLATAFORMA
  function select_sql_disp_plat($mysqli){
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "IOS" ';
    $rs = mysqli_query($mysqli, $sql);
    $this->result_IOS = mysqli_fetch_row($rs);
    $sql = 'select COUNT(tipo_acesso) from mb_timb_log_acesso where tipo_acesso LIKE "Android" ';
    $rs = mysqli_query($mysqli, $sql);
    $this->result_ANDROID = mysqli_fetch_row($rs);
  }

    //PARA REALIZAR A CONEXÃO RECEBE COMO PARAMETRO A CONEXÃO
  public function connection_procedure($mysqli){
    
    // PARAMETROS PARA CHAMAR A FUNCAO QUE EXECUTA PROCEDURE 
    $procedure = 'sp_timb_fe_relatorio'; //NOME DA PROCEDURE
    $parametro = 'acesso'; //PARAMETRO PASSADO PARA A PROCEDURE
    $this->result_proc = $this->call_procedure($procedure,$parametro, $mysqli); //$result_proc -> RECEBE O RESULTADO DA PROCEDURE

    return $this->result_proc;

  }
  /**
   * Invoca a procedure a ser utilizada
   * @param  [type] $proc_string String com o nome da SP
   * @param  [type] $params      String com o valor dos parametros da SP separados por ","
   * @param  [type] $mysqli      Conexão do banco      
   * @return [type]              Retorna a resposta da SP do banco
   */
  public function call_procedure($proc_string, $params,$mysqli){
      
        $stmt = mysqli_query($mysqli,("CALL sp_timb_rel_gerencial('acesso');")) or die($mysqli->error. "ufiabsf");
        $result= mysqli_fetch_all($stmt); //RESULTADOS DA QUERY DA PROCEDURE
       

      return $result;
  }
}

?>