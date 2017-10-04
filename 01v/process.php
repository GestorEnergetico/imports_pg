<?php
/*
Recibe una cadena de texto mediante un formulario en el formato:
Formato
Estado;id_service;Máster BIM y Diseño Integrado;email;password
*/

/*Files*/
require_once("functions.php");
require_once("Store_users.php");
require_once("Export_data.php");

/*set data var*/
$data = array();
if(isset($_POST['data'])){
  $data = $_POST['data'];
}
// preparing data
$users = getData($data);
// print_r($users);
$handle = new Store_users();

foreach ($users as $k => $user) {
  if(trim($user["email"]) != ''){
    $x = $handle->exists($user);
    if(count($x)>0){
      $users[$k]["estado"] = 'exists';
      $users[$k]["id_user"] = $x;
    }else{
      $s = $handle->insert($user);
      if($s!=0){
        $users[$k]["estado"] = 'inserted';
        $users[$k]["id_user"] = $s;
      }
    }
  }else{
    $users[$k]["estado"] = 'noemail';
    $users[$k]["id_user"] = 0;
  }
}
$export = new Export_data($users);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=result.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
echo $export->excel();
