<?php 
//include 'database.php';

class Validation
{
   
    public function checkValidation($request_data,$rules){
    
       
        //print_r($request_data);
       // print_r($rules);
      //   exit;
        foreach ($request_data as $key => $value) {
          // check for which field rules is define.
          if(array_key_exists($key,$rules)){
            $validationMsg = explode(",",$rules[$key]);
            if(isset($validationMsg[1])){
              $errorMsg = $validationMsg[1];
            }else{
              $errorMsg = '';
            }
            // print_r($validationMsg);
            // echo $errorMsg;
            // exit;
            // if one filed have multiple validation then explode validation methods.
            $validationRule = explode("|",$validationMsg[0]);
            // call that all validation method.
            foreach ($validationRule as $methodName) {
    
              $dbValidation = explode(":",$methodName);
              // print_r($dbValidation);
              // exit;
              if(sizeof($dbValidation)>=2){
                // mendetory fields
                // print_r($dbValidation);
                $methodName = $dbValidation[0];
                $table = $dbValidation[1];
                $fieldName = $key;
                // optional fields
                $program_id =  (isset($dbValidation[2]) && !empty($dbValidation[2])?$dbValidation[2]:"");
                $trng_type = (isset($dbValidation[3]) && !empty($dbValidation[3])?$dbValidation[3]:"");
                $returnData = $this->$methodName($value,$fieldName,$table,$program_id,$trng_type,$errorMsg);
              }else {
                // make a validation rule name as a function name.
                $returnData = $this->$methodName($value,$key,$errorMsg);
              }
              //if error so it return json error message.
              if($returnData!=$value){
                // return a error message.
                return $returnData;
              }
            }
          }
        }
        // if all rules are setisfying conditions then return true.
        return true;
    }

    /*
   Check a given email is valid or not.
  */
  public function email($value,$fieldName,$validationMsg ){
    if(filter_var($value,FILTER_VALIDATE_EMAIL) === false){
      // to send error message we are calling a Formatter class's method for display alert and error with their message.
      if($validationMsg == ''){
        $msg = "Invalide $fieldName address";
      }else{
        $msg = "Invalide $validationMsg address";
      }

      return $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }
  /*
  Check given param is empty or not
  */
  public function required($value,$fieldName,$validationMsg){
    // echo $value;
    // echo '<br>';
    // echo $fieldName;

    if(trim($value)==""){
      if($validationMsg == ''){
        $msg = "Please enter ".str_replace("_"," ",$fieldName);
      }else{
        $msg =  $msg = "Please enter $validationMsg  ";
      }
      

      return $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }
  /*
  Check given dropdown is select or not
  */
  public function select($value,$fieldName,$validationMsg){
    if(trim($value)==0){
      if($validationMsg == ''){
        $msg = "Please select ".str_replace("_"," ",$fieldName);
      }else{
        $msg =  $msg = "Please select $validationMsg  ";
      }
     
      return $this->errorAlertMessage($msg,$fieldName,"select");
    }else {
      return $value;
    }
  }
  /*
    preg match for a contact number
  */
  public function contactNumber($value,$fieldName,$validationMsg){
    //if(!preg_match('/^[6-9][0-9]{10}$/', $value))
    if(!preg_match('/^[0-9]{10}+$/', $value))
    {
      if($validationMsg == ''){
        $msg = "Invalid ".str_replace("_"," ",$fieldName);
      }else{
        $msg = "Invalid $validationMsg ";
      }
      return $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }
 public function phoneNumber($value,$fieldName,$validationMsg){
    //if(!preg_match('/^[6-9][0-9]{10}$/', $value))
    if(!preg_match('/^[0-9]{10}+$/', $value))
    {
      return "error"; exit;
      //eturn $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }
  /*
 restrict a duplicate value into database.
  */
  // That check a data value must be unique at the time of insert data into database.
  public function unique($value="",$fieldName="",$table="",$program_id="",$trng_type="",$validationMsg=""){
    
    $db = new Database;

    $extraCondition = "";
    if(!empty($program_id) && !empty($trng_type)){
      $extraCondition =  " and program_id = ".$program_id." AND trng_type = '".$trng_type."'";
    }
    $query = "SELECT id from ".$table." WHERE ".$fieldName."='".$value."'".$extraCondition."";
     $db->select_sql($query);
     $res = $db->getResult();
    if( count($res)>0){
      if($validationMsg == ''){
        $msg = str_replace("_"," ",$fieldName)." is already taken";
      }else{
        $msg ="$validationMsg is already taken";
      }
     
     
      return $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }

  /*
  Check a given input for the parameter is an integer or not.
  */
  public function integer($value,$fieldName,$validationMsg){
    if(!preg_match('/^[0-9]*$/',$value))
    {
      
      if($validationMsg == ''){
        $msg = str_replace("_"," ",$fieldName)." must be number";
      }else{
        $msg = "$validationMsg must be number";
      }
      
      return $this->errorAlertMessage($msg,$fieldName,"input");
    }else {
      return $value;
    }
  }

  
  /*
   success message you want to send as response.
  */
  public function successDataFormat($request_data){
    $data['data'] = $request_data;
    return json_encode($data);
  }

  /*
   error message 
  */
  public function errorAlertMessage($msg,$fieldName,$type){
   // $msg = array("error"=>array("message"=>$msg,"fieldName"=>$fieldName));
   //return json_encode($msg);
      $msg = "error#message:".$msg."#fieldName:".$fieldName."#".$type;
    return $msg;
  }
}


?>