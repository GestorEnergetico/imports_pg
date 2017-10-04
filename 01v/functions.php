<?php

function getData($data){
  /*cut and clean by line*/
  $data = explode(PHP_EOL, $data);
  $data = clean($data);
  $users = array();
  foreach ($data as $ku => $user) {
    /*cut by field*/
    $user = explode(";",$user);
    if(trim($user[0]) == 'si'){
      $emp = 0;
      foreach ($user as $kv => $val) {
        if(trim($val) == ''){
          $emp++;
        }
      }
      if($emp < 5){
        $names = explode(" ",$user[2], 2);
        $arr = array(
          "email" => trim(strtolower($user[3])),
          "nombres" => trim($names[0]),
          "apellidos" => trim($names[1]),
          "servicio" => trim($user[1]),
          "password" => trim($user[4])
        );
        $users[] = $arr;
      }
    }
  }
  return $users;
}

function clean($data){
  $out = array();
  foreach ($data as $value) {
    if(trim($value) != ''){
      $out[]=$value;
    }
  }
  return $out;
}
