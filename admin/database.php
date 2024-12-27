<?php

class Database
{

       private $db_host = 'localhost';
       private $db_user = 'root';
       private $db_pass = 'MdR@6%&!#$1';
       private $db_name = 'mdrafm';
       private $mysqli = '';
       public $base_url = '';

    private $result = array();
    private $conn = false;

    public function __construct()
    {

        if (!$this->conn) {

            $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            $this->conn = true;

            if ($this->mysqli->connect_error) {
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
        } else {
            return true;
        }
    }

    //function to insert in database

    public function insert($table, $params = array())
    {
        if ($this->tableExists($table)) {

            //print_r($params);
            $table_columns = implode(', ', array_keys($params));
            $table_values = implode('#', $params);
            // print_r($table_columns);
            // print_r($table_values);
            $val=$this->mysqli->real_escape_string($table_values);
            $result_string = "'" . str_replace("#", "','", $val) . "'";
            $sql = "INSERT INTO $table ($table_columns) VALUES ($result_string)";
             //echo $sql;
        
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->insert_id);
                array_push($this->result, "added successfully");
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }
        $this->mysqli->close();
    }

    //direct insert sql is 
    public function insert_sql($sql)
    {
        //echo $sql; exit;
        $query = $this->mysqli->query($sql);
        if ($query) {
            array_push($this->result, $this->mysqli->insert_id);
            array_push($this->result, "added successfully");
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
         $this->mysqli->close();
    }

    //function to update in Database

    public function update($table, $params = array(), $where = null)
    {
        if ($this->tableExists($table)) {
            $args = array();
            foreach ($params as $key => $value) {
                $val = $this->mysqli->real_escape_string($value);
                // $args[] = "$key = "$val"";
                $args[] = "$key = '$val'";
            }
            $sql = "UPDATE $table SET " . implode(', ', $args);
            if ($where != null) {
                $sql .= " WHERE $where";
            }
            //echo $sql; 
            //exit;
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                array_push($this->result, "update successfully");
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
         $this->mysqli->close();
    }

    public function update_dir($sql)
    {
        // echo $sql; 
        if ($this->mysqli->query($sql)) {
            array_push($this->result, $this->mysqli->affected_rows);
            array_push($this->result, "update successfully");
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
         $this->mysqli->close();
    }

    //function to delete in Database

    public function delete($table, $where = null)
    {

        if ($this->tableExists($table)) {

            $sql = "DELETE FROM $table ";

            if ($where != null) {
                $sql .= "WHERE $where";
            }
            // echo $sql; 
            if ($this->mysqli->query($sql)) {
                array_push($this->result, "success");
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
         $this->mysqli->close();
    }

     public function delete_sql($sql)
    {
        //echo $sql;
        $query = $this->mysqli->query($sql);
        if ($query) {
            array_push($this->result, $this->mysqli->affected_rows);
            array_push($this->result, "Deleted successfully");
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
         $this->mysqli->close();
    }

    //function to select form database in database
    public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null)
    {
        if ($this->tableExists($table)) {
            $sql = "SELECT $rows FROM $table";
            if ($join != null) {
                $sql .= "$join";
            }
            if ($where != null) {
                $sql .= " WHERE  $where";
            }
            if ($order != null) {
                $sql .= " ORDER BY $order";
            }
            if ($limit != null) {
                $sql .= " LIMIT 0, $limit";
            }
          //echo $sql;
            $query = $this->mysqli->query($sql);
             $this->mysqli->set_charset('utf8');
            if ($query) {
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
         $this->mysqli->close();
    }


    public function select_sql($sql)
    {
//echo $sql;
        $query = $this->mysqli->query($sql);
        if ($query) {
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
         $this->mysqli->close();
    }
    public function getFacultyName($facultyId){
           $result = $this->select('tbl_faculty_master','name',null,'id='.$facultyId,null,null);
           $res = $this->getResult();

           foreach( $res as $row){
            print_r($row);
             return $row['name'];
           }
            $this->mysqli->close();
      }
    public function select_sql_row($sql)
    {
       $query = $this->mysqli->query($sql);
        if ($query) {
            $row = $query->fetch_object();
            return $row;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
         $this->mysqli->close();
    }
    function SecureSql($str)
    {
        $str = @trim($str);
        /*		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}*/
        $str = stripslashes($str);
        $str = ltrim($str);
        $str = rtrim($str);
        $newstring = htmlentities($str);
        $newstring_after_scrt = $this->mysqli->real_escape_string($newstring);
        return $this->filter($newstring_after_scrt);
    }
    function filter($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = str_replace("'", "", $var);
        $var = str_replace('"', '', $var);
        $var = str_replace('DELETE', '', $var);
        $var = str_replace('delete', '', $var);
        $var = str_replace('SELECT', '', $var);
        $var = str_replace('select', '', $var);
        $var = str_replace('UPDATE', '', $var);
        $var = str_replace('update', '', $var);
        $var = str_replace('alert', '', $var);
        $var = str_replace('ALERT', '', $var);
        $var = str_replace('script', '', $var);
        $var = str_replace('<script>', '', $var);
        $var = str_replace('</script>', '', $var);
        $var = str_replace('<SCRIPT>', '', $var);
        $var = str_replace('</SCRIPT>', '', $var);
        $var = str_replace('!', '', $var);
        //$var = str_replace('@','',$var) ;
        //$var = str_replace('#','',$var) ;
        //$var = str_replace('$','',$var) ;
        //$var = str_replace('%','',$var) ;
        $var = str_replace('^', '', $var);
        $var = str_replace('*', '', $var);
        $var = str_replace('+', '', $var);
        $var = str_replace('=', '', $var);
        $var = str_replace('{', '', $var);
        $var = str_replace('}', '', $var);
        $var = str_replace('[', '', $var);
        $var = str_replace(']', '', $var);
        $var = str_replace('|', '', $var);
        $var = str_replace(';', '', $var);
        $var = str_replace(':', '', $var);
        $var = str_replace('<', '', $var);
        $var = str_replace('>', '', $var);
        $var = str_replace('?', '', $var);
        $var = str_replace('&lt', '', $var);
        $var = str_replace('&gt', '', $var);
        $var = str_replace('%2', '', $var);
        $var = str_replace('http', '', $var);
        $var = str_replace('https', '', $var);
        $var = str_replace('www', '', $var);
        $var = str_replace('&quot', '', $var);
        $var = str_replace("\'", '', $var);
        $var = str_replace("'\'", '', $var);
        $var = str_replace("'/'", '', $var);
        $var = str_replace("", '', $var);
        return $var;
    }
    public function select_one($table, $rows, $id)
    {
        $sql = "SELECT $rows FROM $table WHERE id = $id";
        //echo $sql;
        $query = $this->mysqli->query($sql);
        if ($query) {
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
    }

    //function to check table in database
    private function tableExists($table)
    {
        // echo $table;
        $sql = "SHOW TABLES FROM $this->db_name LIKe '$table' ";
        $tableInDb = $this->mysqli->query($sql);
        if ($tableInDb->num_rows == 1) {
            return true;
        } else {
            array_push($this->result, $table . "doesnot exists in database");
            return false;
        }
    }

    //function to show result array

    public function getResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    //close connection to database
    public function __destruct()
    {
        if ($this->conn) {
            if ($this->mysqli->close()) {
                $this->conn = false;
                return true;
            }
        } else {
            return false;
        }
    }
    public function getCourseDirector($id){
         $this->select('tbl_program_directors','course_director',null,'id='.$id,null,null);
         $res = $this->getResult();

        foreach ( $res as $row ) {
            return $row['course_director'];
        }
        
    }

    public function getAsstCourseDirector($id){
        $this->select('tbl_program_directors','asst_course_director',null,'id='.$id,null,null);
        $res = $this->getResult();

       foreach ( $res as $row ) {
           return $row['asst_course_director'];
       }
    }
    public function insert_audit_trail_details($tablename,$transaction_type,$transction_status)
    {
        $audit_data = array(
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'server_session_id' =>session_id(),
            'user_id' => $_SESSION['user_id']
            );
                $insert_audit_data=array(
                'user_id'=>$audit_data['user_id'],
                'workdone'=>$tablename,
                'transaction_type'=>$transaction_type,
                'transction_status'=>$transction_status,
                'ip_address'=>$audit_data['ip_address'],
                'session_id'=>$audit_data['server_session_id']
                );
                $this->insert('tbl_audit_trail',$insert_audit_data);
    }

    public function getTotalLeave($user_id,$leave_type_id){
        $this->select_sql("SELECT COALESCE(SUM(l.leave_days), 0) AS leave_days FROM `tbl_leave` l 
        JOIN tbl_leave_type_master m ON l.leave_type_id = m.id WHERE l.leave_type_id = $leave_type_id AND user_id = $user_id");

        $res = $this->getResult();

        foreach ( $res as $row ) {
            return $row['leave_days'];
        }
    }

    public function get_regi_link($tbl,$id,$trng_type){
      $key = $this->generateRandomKey(32);
      
     //update($table, $params = array(), $where = null)
      //$_SERVER['DOCUMENT_ROOT'];

      $this->update($tbl,['secret_key'=>$key],'id='.$id);
      $res = $this->getResult();

        if ($res) {
            return $id.'.'.$trng_type.'.'.$key;
        } else {

        echo "error#" . $res[0];
        }

    }

   public function generateRandomKey(int $length): string
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }
}
