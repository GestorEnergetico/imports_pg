<?php
class Store_users {
  private $db;
  function __construct(){
    try {
      $this->db = new mysqli("localhost", "root", "", "old_devadmin");
    } catch (Exception $e) {
      echo $this->db->errno;
    }
  }

  public function insert($user){
    $stmt = 'INSERT INTO `users` (`username_users`, `password_users`, `fk_id_rols_users`, `fk_id_people_profile`, `passphrase_users`) VALUES';
    $stmt .= ' ("'.$user["email"].'", "'.$user["password"].'", "1", "0", "'.$user["password"].'")';
    $result = $this->db->query($stmt);
    return $this->db->insert_id;
  }
  public function exists($user){
    // print_r($user);
    $stmt = 'SELECT id_users FROM users WHERE username_users="'.$user["email"].'"';
    $result = $this->db->query($stmt);
    $out = array();
    while($row = $result->fetch_assoc()){
      $out[] = $row;
    }
    return $out;
  }
}
