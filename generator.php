<?php

$data = array();
if (isset($_FILES)) {
  $data = $_FILES["data"];
} else {
  echo "no";
}
// print_r($data);
/*
$data contiene
informacion del archivo
*/
$data = cleardata($data);
$addressFILE = $data["tmp_name"];
// echo $addressFILE;
/*
$addressFILE contiene
el nombre/address del archivo
*/
$dataStr = file_get_contents($addressFILE);

if($dataStr != FALSE){
  // echo $dataStr;
  /*
  $dataStr contiene
  el cotenido del archivo en un string
  */
  $dataArr = explode(PHP_EOL, $dataStr);
  // print_r($dataArr);
  /*
  $dataArr contiene
  un array con la informacion separada por lineas
  */
  /*punto del codigo Mysqli*/
  $mysqli = new mysqli("localhost", "root", "", "old_devadmin");
  if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  /*/punto del codigo Mysqli*/

  foreach ($dataArr as $lineStr) {
    $dataCampo = explode(";", $lineStr);

    if (in_array("si", $dataCampo))
      {
      echo "Match found";
      }
    else
      {
      echo "not found";
      }

    /*Conseguir separar por lines y campos el contenido del archivo*/
    // print_r($dataCampo);
    /*
    $dataCampo que tiene  un array de tipo:
    Array
    (
    [0] => si
    [1] => 4
    [2] => Marcos Souto Filguira
    [3] => marcos.soutofilgueira@gmail.com
    [4] => 3YFNe9r
    )
    para cada usuario

    $stmt = "INSERT INTO `users`
    (`username_users`, `password_users`, `fk_id_rols_users`, `fk_id_people_profile`, `passphrase_users`)
    VALUES
    ('email', md5(), '1', '0', 'password')";

    */
    /*punto del codigo Mysqli*/
    /*punto del codigo Mysqli*/
    $stmt = "INSERT INTO `users`
    (`username_users`, `passphrase_users`, `fk_id_rols_users`, `fk_id_people_profile`, `password_users`)
    VALUES
    ('" .$dataCampo[3]. "', '".md5($dataCampo[4])."', '1', '0', '". $dataCampo[4] ."')";
    echo  $stmt . "<br>";
    /*
    a este punto de codigo tenemos $stmt que tiene:
      la cosulta para insertar usuario
    */
    if (!$mysqli->query($stmt)) {
      echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
    }

  }


}
echo "final";

/*Guardar los usuario en la base de datos*/
/*
/*
*check del estatus que esta al principio de cada linea

*/

/*
Optimizar la app

*check del estatus que esta al principio de cada linea
*la funcion clean para limpiar las lineas vacias

function clean($data){
  $out = array();
  foreach ($data as $value) {
    if(trim($value) != ''){
      $out[]=$value;
    }
  }
  return $out;
}
*funcion clean_Field  que limpia los campos no deseados /email/
  *check si tiene email
*check if exists users

*/
