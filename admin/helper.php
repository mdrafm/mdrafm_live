<?php

     class Helper{
       
         private $db;

         public function __construct($db){
            $this->db = $db;
         }
        

        public  function fetchTrineeData($program_id,$trng_type){
            $program_tbl = '';
            if($trng_type == 4 || $trng_type == 5){
                $program_tbl = "tbl_short_program_master";
            }else{
                $program_tbl = "tbl_mid_program_master";
            }

            $this->db->select_sql("SELECT d.id,d.trainee_detail_id,t.name,t.designation,t.hrms_id,t.office_name,t.email,t.phone,t.joining_date,t.sex,t.category,t.edu_qualification,t.joining_date,t.dob,d.mdrafm_status,d.exam_result_status,d.crt_no,d.status,d.mail_status FROM tbl_trainee_details t
            JOIN `tbl_dept_trainee_registration` d ON t.id = d.trainee_detail_id
            JOIN `$program_tbl` p ON d.program_id = p.id 
            WHERE d.trng_type = '$trng_type' AND d.program_id = $program_id;");

            return $this->db->getResult();
           // return $this->db;

            
        }

        public function fetchDataById($tbl,$id){
            $this->db->select($tbl,"*",null,"id =".$id,null,null);
            return   $this->db->getResult();
        }

        public function isUserRegistred($tbl,$programId,$trainee_detail_id){
            $this->db->select($tbl,"*",null,"program_id = $programId AND trainee_detail_id =".$trainee_detail_id,null,null);
            return   $this->db->getResult();
        }

          public  function get_program_name($program_id,$type){

                    if ($type == 1 || $type == 2) {
                         $prog_table = 'tbl_program_master';
                      } elseif ($type == 3 || $type ==7) {
                         $prog_table = 'tbl_mid_program_master';
                      } elseif ($type == 4 || $type == 5) {
                         $prog_table = 'tbl_short_program_master';
                      }
                     
                $this->db->select($prog_table,"id,prg_name",null," id = '".$program_id."' AND trng_type =".$type,null,null);
                 
                return $this->db->getResult();


            }

     }

?>