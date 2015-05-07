<?php
if($_POST)
{
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array('type'=>'error', 'text' => 'Request must come from Ajax'));
        die($output);
    } 
    
    if(!isset($_POST["userName"]) || !isset($_POST["userSenha"]) )
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Campos vazios!'));
        die($output);
    }

    $user_Name        = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
    $user_Senha       = filter_var($_POST["userSenha"], FILTER_SANITIZE_EMAIL);
    
    if(strlen($user_Name)<4) 
    {
        $output = json_encode(array('type'=>'error', 'text' => 'CPF invalido'));
        die($output);
    }
    if(strlen($user_Senha)<4) 
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Senha invalido'));
        die($output);
    }
    
    $conexao = mysql_connect("dbmy0052.whservidor.com", "truckinfom", "chap1982") or die(mysql_error());
    $banco = mysql_select_db("truckinfom")or die(mysql_error());
    $query = "SELECT * FROM mb_timb_cadastro WHERE cpf=".$user_Name." AND senha='".$user_Senha. "'";
    $result = mysql_query($query, $conexao);
    //echo($result);
    if (!$result) {
        $output = json_encode(array('type'=>'error', 'text' => 'Usuariao ou senha não encontrados'));
        die($output);
    }else{
       $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_Name .' Thank you for your email'));
       die($output);
   }
}
?>



