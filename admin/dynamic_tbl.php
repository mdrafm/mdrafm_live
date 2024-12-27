<?php
class DynamicTable {
    private $headers;
    private $data;
    private $actionColumn;
    private $tblId;
    private $skipArray;
  
    public function __construct($headers, $data, $actionColumn = null,$skipArray,$tblId) {
      $this->headers = $headers;
      $this->data = $data;
      $this->actionColumn = $actionColumn;
      $this->tblId = $tblId;
      $this->skipArray = $skipArray;
    }
    
    // public function generateOptions(){
    //   $options = array();

    //    foreach ($this->data  as $key => $row) {
    //       print_r($row);
    //    }
    // }
    public function generateTable() {
      $table = '<table class="table table-responsive" id='.$this->tblId.' >';
      $table .= '<tr>';
      foreach ($this->headers as $header) {
        $table .= '<th>' . $header . '</th>';
      }
      // if ($this->actionColumn) {
      //   $table .= '<th>' . $this->actionColumn . '</th>';
      // }
      $table .= '</tr>';
      
      $cnt = 1;
       $options = array();
      foreach ($this->data as $row) {
        $table .= '<tr>';
        $table .= '<td>' . $cnt . '</td>';
        foreach ($row as $key => $cell) {
          if(!in_array($key, $this->skipArray)){
            $table .= '<td>' . $cell . '</td>';
          }
         if(in_array($key, $this->skipArray)){
            //array_push($options, $row);
          $options[$key] = $cell;
          }
          
        }
        // if ($this->actionColumn) {
        //   $table .= '<td>' . $this->actionColumn . '</td>';
        // }
        foreach($this->actionColumn as $actionColumn){
          $table .= '<td>';
           $table .= '<button type="button" class="edit btn btn-'.$actionColumn["class"].'" data-options ='.json_encode($options).' >'.$actionColumn["label"].'</button>';
          $table .= '</td>';
        }
        $table .= '</tr>';
        $cnt++;
        $options = array();
      }
  
      $table .= '</table>';
      return $table;
    }
}


?>