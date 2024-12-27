<div class="row" style="margin-top:50px">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>

            </div>
            <div class="card-body">
                <div id="program_list2">
                    <?php
                        $sql_trainee = "SELECT f.user_id,u.name,u.username,d.designation,d.office_name FROM `tbl_mid_cls_feedback` f 
                                      JOIN `tbl_user` u ON f.user_id = u.id
                                      JOIN `tbl_dept_trainee_registration` d ON d.phone = u.username
                                      WHERE f.time_tbl_id IN (SELECT id FROM `tbl_sponsored_time_table` WHERE `program_id` = $program_id) GROUP BY f.user_id";

                        $db->select_sql($sql_trainee);
                        $res_trainee = $db->getResult();

                        //print_r($res_trainee);
                            $headers = array('Sl No', 'Name', 'Phone Number', 'Designation','Office Name','Action');
                            $traineeList = 'trainees';
                            $skipArray=['user_id'];
                            $actionColumn = array(
                                 array('label'=>'Print','class'=>'primary'),
                                 array('label'=>'Edit','class'=>'success'),
                            );
                            $table = new DynamicTable($headers, $res_trainee,$actionColumn,$skipArray,$traineeList);
                             //echo $table->generateOptions();
                            echo $table->generateTable(); 




                     ?>
                </div>
            </div>
        </div>

    </div>

</div>