<?php

include('database.php');

$object = new database();

if (!$object->is_login()) {
    header("location:" . $object->base_url . "admin");
}

include('header.php');

?>
<span id="error"></span>
<!-- Page Heading -->
<h4 class="text-gray-800">Trainee Result</h4>


<!-- DataTales Example -->
<span id="message"></span>


<div class="card shadow mb-4">
    <div class="card-header py-3">
       
        <h3>Search Trainee Details</h3>
    </div>
    <div class="card-body">
    <div class="row">
            <div class="col">
              <label>Program Type</label>
                <select name="prog_type" id="prog_type" class="form-control" required>
                    <option value="0">Select</option>
                    <option value="1">Long Term</option>
                    <option value="2">Mid Term</option>
                    
                </select>
            </div>
            <div class="col">
            <label>Select Program</label>
            <select name="prog_id" id="prog_id" class="form-control" required>
                    <option value="0"></option>
                   
                    
                </select>
               
            </div>
            <div class="col">
            <label></label>
              <input type="button" name="view" id="view_button" onclick="showTrainee()" class="btn btn-success mt-5" value="View" />
               
            </div>

        </div>

    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
       
        <h3>Final Result List </h3>
    </div>
    <div class="card-body">
   
       <div id="trainee_list"></div>
      
    </div>
</div>

<?php
include('footer.php');
?>



<script>


   
   $('#prog_type').change(function(){
        let prog_type = $('#prog_type').val();
        
       
        {
            $.ajax({
                url:"final_result_action.php",
                method:"POST",
                data:{action:'fetch_programs', prog_type:prog_type},
                success:function(data)
                {
                    console.log(data);
                    $('#prog_id').html(data);
                }
            });
        }
    });

    function showTrainee() {
        let prog_type = $('#prog_type').val();
        let prog_id = $('#prog_id').val();
        

       
        $.ajax({
            method: "POST",
            url: "final_result_action.php",
            data: {
                'action': 'trainne_list',
                'prog_type': prog_type,
                'prog_id': prog_id
            },
            success: function(res) {
                console.log(res);

                $('#trainee_list').html(res);
                $('#crt_no_gnrt').show();
            }
        })

    }
    function generate_crtificate(trng_type,program_id){
        let exam_type = $('#prog_type').val();
        let prog_short_name = $('#short_name').val();
        let month = $('#month').val();
        let fin_yr = $('#fin_yr').val();
        let place = $('#place').val();
        let cert_date = $('#cert_date').val();
       
        
        TableData = storeTblValues();
        TableData = JSON.stringify(TableData);

        $.ajax({
            url: 'final_result_action.php',
            type: "POST",
            data: {
                'action': 'save_trainee_crtificate',
                'tableData': TableData,
                'exam_type': exam_type,               
                'prog_short_name': prog_short_name,
                'month': month,
                'fin_yr': fin_yr,
                'place': place,
                'cert_date': cert_date,

            },

            success: function(data) {
                console.log(data)

                if(data == 'success'){
                    location.reload();
                }
               
            }
        });
    }

    
    function save(ref){
      //  console.log(ref);
        let exam_id = [];
        let paper_mark = [];
        let presentation_mark = [];
        let surprise_mark = [];

        let currentRow=ref.closest("tr"); 
      
        currentRow.find('input[name="exam_id"]').each(function(){
            exam_id.push($(this).val());
           // console.log(this.value);
        })
        currentRow.find('input[name="paper_mark"]').each(function(){
            paper_mark.push($(this).val());
            //console.log(this.value);
        })
        currentRow.find('input[name="presentation_mark"]').each(function(){
            presentation_mark.push($(this).val());
            //console.log(this.value);
        })
        currentRow.find('input[name="surprise_mark"]').each(function(){
            surprise_mark.push($(this).val());
           // console.log(this.value);
        })
       let program_id =  currentRow.find('input[name="program_id"]').val()
       let user_id =  currentRow.find('input[name="user_id"]').val()
       let roll_no =  currentRow.find('input[name="roll_no"]').val()
        //console.log(currentRow.find('input[name="presentation_mark_8"]').val());roll_no
        //console.log(presentation_mark);

        let exam_ids = JSON.stringify(exam_id);
        let paper_marks = JSON.stringify(paper_mark);
        let presentation_marks = JSON.stringify(presentation_mark);
        let surprise_marks = JSON.stringify(surprise_mark);

        $.ajax({
            url: 'final_result_action.php',
            type: "POST",
            data: {
                'action': 'save_trainee_final_result',
                'exam_data': exam_ids,
                'paper_mark_data': paper_marks,
                'presentation_mark_data': presentation_marks,
                'surprise_mark_data': surprise_marks,
                'program_id': program_id,
                'user_id': user_id,
                'roll_no':roll_no
            },

            success: function(data) {
                console.log(data)
               
            }
        });
        
    }

    function update(ref){

    }
        
    

function storeTblValues() {
        var TableData = new Array();
        $('#exam_result tr').each(function(row, tr) {
            TableData[row] = {
                "user_id": $(tr).find('input[type="hidden"]').val(),
                "roll_no": $(tr).find('input[name="roll_no"]').val(),
                "exam_status": $(tr).find('input[name="exam_status"]').val(),
                "name": $(tr).find('td:eq(2)').text(),
                "desig": $(tr).find('td:eq(3)').text(),
                "office": $(tr).find('td:eq(4)').text(),
            
            }
        });
        TableData.shift(); // first row will be empty - so remove
        return TableData;
    }
    // $(document).ready(function() {
    //     $('#exam_table').DataTable();
    // });

    
</script>