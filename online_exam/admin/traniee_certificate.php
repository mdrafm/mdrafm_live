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
<div class="card shadow mb-4" id="crt_no_gnrt" style="display: none;">
    <div class="card-header py-3">
    <h3> Give Certificate No</h3>
        
    </div>
    <div class="card-body">

    <form method="post" id="crt_no_from" action="certificate_pdf.php">
        <div class="row mt-5">


            <div class="col-md-1">
                <p>Certificate No :</p>
              
            </div>
           
                <div class="col-md-2">
                  
                    <input type="text" name="short_name" id="short_name" autocomplete="off" class="form-control" required placeholder=" Program Short Name"  required/>
                </div>
                <div class="col-md-2">
                    <input type="text" name="month" id="month" autocomplete="off" class="form-control" required placeholder="Month" required/>
                </div>
                <div class="col-md-2">
                    <input type="text" name="fin_yr" id="fin_yr" autocomplete="off" class="form-control" required placeholder="Fin Yr" value="<?php //echo $fin_year ?>" required/>
                </div>
                <div class="col-md-1">
                    <input type="text" name="sl_no" id="sl_no" autocomplete="off" class="form-control" readonly placeholder="Roll No" required/>
                </div>
                <div class="col-md-1">
                    <input type="text" name="place" id="place" autocomplete="off" class="form-control" required placeholder="Place" value="BBSR" required/>
                </div>
                <div class="col-md-2">
                    <input type="Date" name="cert_date" id="cert_date" autocomplete="off" class="form-control" required />
                </div>

        </div>
       
        </form>
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
   $("#checkAll").click(function(e) {
    // alert(123);
    var table= $(e.target).closest('table');
    console.log(table)
    $('td input:checkbox',table).prop('checked',this.checked);
});
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
                'action': 'pass_trainne_list',
                'prog_type': prog_type,
                'prog_id': prog_id
            },
            success: function(res) {
                console.log(res);

                $('#trainee_list').html(res);
                $('#crt_no_gnrt').show();
                $("#checkAll").click(function(e) {
    // alert(123);
    var table= $(e.target).closest('table');
    console.log(table)
    $('td input:checkbox',table).prop('checked',this.checked);
});
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
                'trng_type': trng_type,
                'program_id': program_id,
                'prog_short_name': prog_short_name,
                'month': month,
                'fin_yr': fin_yr,
                'place': place,
                'cert_date': cert_date,

            },

            success: function(data) {
                console.log(data)
               
            }
        });
    }

    // function gen_crt_no(){
    //     TableData = storeTblValues();
    //    // TableData = JSON.stringify(TableData);
    //     console.log(storeTblValues());
    // }

    
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
        //console.log(currentRow.find('input[name="presentation_mark_8"]').val());
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
            },

            success: function(data) {
                console.log(data)
               
            }
        });
        
    }

    function generate_crt(prog_id){

    }
        
    

function storeTblValues() {
        var TableData = new Array();
        $('#exam_result tr').each(function(row, tr) {
            TableData[row] = {
                "dept_reg_id": $(tr).find('input[name="dept_reg_id"]').val(),
                "roll_no": $(tr).find('input[name="roll_no"]').val(),
                "name": $(tr).find('td:eq(3)').text(),
                "select": $(tr).find('input[type="checkbox"]:checked').val()
            }
        });
        TableData.shift(); // first row will be empty - so remove
        return TableData;
}
   

function datapost(path, params, method) {
    //alert(path);
    method = method || "post"; // Set method to post by default if not specified.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    for (var key in params) {
        if (params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
    }
    document.body.appendChild(form);
    form.submit();
}

    
</script>