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
      
      $this->servidor = 'localhost';
      $this->banco = 'truckinfom';
      $this->usuario = 'root';
      $this->senha = '';
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
  }



  ?>