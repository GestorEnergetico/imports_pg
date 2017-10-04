<?php

/**
*
*/
class Export_data{
  private $data;
  public $order;

  function __construct($data){
    $this->data = $data;
  }
  public function excel($order = array()){
    $header = array_keys($this->data[0]);
    if(count($order) <= 0){
      $order = array(
        0 =>'estado',
        1 =>'id_user',
        2 =>'email',
        3 =>'nombres',
        4 =>'apellidos',
        5 =>'servicio',
        6 =>'password'
      );
    }
    $this->order = $order;
    return $this->genTable($order);
  }
  public function genTable($header){
    $thead = '';

    foreach ($header as $name) {
      $thead .= '<th>'. $name . '</th>';
    }
    $rows = '';
    foreach ($this->data as $key => $user) {
      $rows .= $this->genRows($user);
    }
    return '
    <table>
    '. $thead .'
    '. $rows .'
    </table>
    ';
  }
  public function genRows($user){
    return '
    <tr style="border:solid 1px #aaa">
    <td>'.utf8_decode($user[$this->order[0]]).'</td>
    <td>'.utf8_decode($this->arrayToString($user[$this->order[1]])).'</td>
    <td>'.utf8_decode($user[$this->order[2]]).'</td>
    <td>'.utf8_decode($user[$this->order[3]]).'</td>
    <td>'.utf8_decode($user[$this->order[4]]).'</td>
    <td>'.utf8_decode($user[$this->order[5]]).'</td>
    <td>'.utf8_decode($user[$this->order[6]]).'</td>
    </tr>
    ';
  }

  public function arrayToString($arr){
    $out = $arr;
    if(is_array($arr)){
      $str = '';
      if(count($arr)>0){
        foreach ($arr as $key => $val) {
          if(is_array($val) && (count($val)>0)){
            $str .= $this->arrayToString($val);
          }else{
            $str .= "," . $val . "\n";
          }
        }
      }
      $out = $str;
    }
    return $out;
  }
}
