<?php
header('Content-Type: text/html; charset=utf-8');


/*$conexao = mysql_connect("dbmy0052.whservidor.com", "truckinfom", "chap1982") or die(mysql_error());
$banco = mysql_select_db("truckinfom")or die(mysql_error());

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

//$query = "CALL teste_proc()";*/
$query = "select * from mb_timb_cadastro;";

$conexao = mysqli_connect("dbmy0052.whservidor.com", "truckinfom", "chap1982", "truckinfom");

//$result = mysql_query($query, $conexao);
mysqli_query($conexao,"SET NAMES 'utf8'");
mysqli_query($conexao,'SET character_set_connection=utf8');
mysqli_query($conexao,'SET character_set_client=utf8');
mysqli_query($conexao,'SET character_set_results=utf8');
$result = mysqli_query($conexao, 'CALL sp_timb_rel_gerencial();') or die($conexao->error. "ufiabsf");


$so = '{"so":[';
$cargo = '"cargo":[';
$razao = '"razao":[';
$evoT = '"evoT":[';
$evoTD = '"evoTD":[';
$eh = '"eh":[';
$ehTotal = '"ehTotal":[';
$ehTableData = '"ehTable":[';
//echo "aki = ". $result->num_rows;
if (!$result) {
  $output = json_encode(array('type'=>'error', 'text' => 'Usuario ou senha não encontrados'));
  die($output);
}else{
  //echo "ok " . $result->num_rows;
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    //echo $row['tipo_grafico'] . " aisi <br> ";
    //foreach ($row as $key => $value) {
      //echo $key . " | " ;
    //}
    //echo "<br>";
  //}
//}
    switch ($row['tipo_grafico']) {
      case 'SO':
            //pegar grafico barra horizontal
        //echo $row['label_1'];
        //$so[] = array('y' => $row['label_1'], 'v' => $row['count_1']);
        $so .= '{"data":"'.$row['label_1'].'","value":'.$row['count_1'].'},';
      break;

      case 'RAZAO_SOCIAL':
      //echo $row['label'];
        //$razao->append(array('data' => $row['label_1'], 'label' => $row['count_1'], 'value' => $row['count_1']));
        $razao .= '{"data":"'.$row['label_1'].'","value":'.$row['count_1']. ',"label":'. $row['count_1'] .'},';
      break;

      case 'CARGO':
        //$cargo->append(array( 'x' => $row['label_1'] , 'v' =>  $row['count_1']));
        $cargo .= '{"x":"'.$row['label_1'].'","v":'.$row['count_1'].'},';
      break;


      case 'DATA_ACESSO':
        if(empty($row['label_2'])){
                  //table 3
          //$evoT->append(array( 'ano' => $row['label_1'] , 'v' =>  $row['count_1']));
          $evoT .= '{"ano":"'.$row['label_1'].'","v":'.$row['count_1'].'},';
        }else{
                  //table 2
          //$evoTD[->append(array( 'period' => $row['label_1'] , $row['label_2'] =>  $row['count_1']));
          $evoTD .= '{"period":"'.$row['label_1'].'","'. $row['label_2'] .'":'. $row['count_1'] .'},';
        }
        break;
      case 'EH':
        //{ y: '2006', a: 100, b: 90, c: 80 }
        //$eh[]->append(array( 'y' => $row['label_1'] , 'a' =>  $row['count_1'], 'b' =>  $row['count_2'], 'c' =>  $row['count_3']));
        $eh .= '{"y":"'.$row['label_1'].'","a":'.$row['count_1']. ',"b":'. $row['count_2'] . ',"c":'. $row['count_3'] . '},';
        break;
      case 'EH_TOTAL':
        //{ y: '2006', a: 100, b: 90, c: 80 }
        //$ehTotal->append(array( 'y' => $row['label_1'] , 'a' =>  $row['count_1']));
        $ehTotal .= '{"y":"'.$row['label_1'].'","a":'.$row['count_1'].'},';
        break;
       case 'EH_TABELA':
        //{ y: '2006', a: 100, b: 90, c: 80 }
       $msgNew = preg_replace('/\s\s+/', ' ', $row['label_5']);
       $msgNew = preg_replace('/\'|"/', ' ', $msgNew);
       
        //$ehTableData->append(array('email' => $row['label_2'] ,'tel' => $row['label_4'] ,'msg' => $row['label_5'] ,'nome' => $row['label_3'] ,'natureza' => $row['label_1'] ,'dia' => $row['label_6']));diaComplet
        $ehTableData .= '{"email":"'.$row['label_4'].'","tel":"'.$row['label_3']. '","msg":"'. trim($msgNew) . '","nome":"'. $row['label_2'] . '","natureza":"'. $row['label_1'] . '","dia":"'. $row['label_6'] . '","diacomplet":"'. $row['label_7'] . '"},'; 
        break;
      default:
              # code...
      break;
    }
  }
  /*foreach ($cargo as $key => $row) {
    $mid[$key]  = $row['v'];
  }
  array_multisort($mid, SORT_ASC, $cargo);*/
  //var $feed = array('cargo' => $so);

  //var_dump(json_encode($feed));
  //echo "<pre>";
  //print_r(json_encode($so));
  //echo "</pre>";

  //$arrayName = array( 'so' => $so);
$so =  substr($so, 0, -1);
  $so .= "],";
  $cargo =  substr($cargo, 0, -1);
  $cargo .= "],";
  $razao =  substr($razao, 0, -1);
  $razao .= "],";
  $evoT =  substr($evoT, 0, -1);
  $evoT .= "],";
  $evoTD =  substr($evoTD, 0, -1);
  $evoTD .= "],";
  $eh =  substr($eh, 0, -1);
  $eh .= "],";
  $ehTotal =  substr($ehTotal, 0, -1);
  $ehTotal .= "],";
  $ehTableData =  substr($ehTableData, 0, -1);
  $ehTableData .= "]}";
  //echo "<pre>";
  print_r($so . $razao . $cargo .  $evoT . $evoTD . $eh . $ehTotal . $ehTableData);
  //echo "</pre>";

  //var_dump(json_encode(array('cargo' => $cargo, 'razao' => $razao, 'so' => $so, 'evoT' => $evoT, 'evoTD' => $evoTD, 'eh' => $eh, 'ehTotal' => $ehTotal, 'ehTable' => $ehTableData), JSON_NUMERIC_CHECK));
}
?>