showMessage();

function showMessage(){

	if ( sessionStorage.type=="success" ) {
       
        //$('#btn_records_mtnc').show();
        //$('.toast-1').toast('show');
        $("#alert_msg").removeClass("alert-danger");
        $("#alert_msg").addClass("alert alert-secondary").html(sessionStorage.message);
        $('#alert_msg').show();
        closeAlertBox();
       
        sessionStorage.removeItem("message");
        sessionStorage.removeItem("type");
    }
    if (sessionStorage.type == "error") {
        $("#alert_msg").removeClass("alert-secondary");
        $("#alert_msg").addClass("alert alert-danger").html(sessionStorage.message);
        $('#alert_msg').show();
        closeAlertBox();
        sessionStorage.removeItem("message");
        sessionStorage.removeItem("type");
    }
}
function displayMessage(res){
    $('small').text('');
            
    let elm = res.split('#');
    let str = "";
    // if (elm[0] == "success") {
    //     sessionStorage.message = ` ${msg_tpy} is ${msg_flg} successfully`;
    //     sessionStorage.type = "success";
    //     setTimeout(function(){
    //     window.location.reload(1);
    //     }, 1000);
    //     showMessage();
    // }
    if (elm[0] == "error"){
       console.log(elm);
        const  msg = elm[1].split(':');
        console.log(msg);
        const errorMsg = (msg[0]=='message')?msg[1]:'';
        if(elm[2])
        {
            const  field = elm[2].split(':');
            const errorField = (field[0]=='fieldName')?field[1]:'';
            console.log(errorField);
            if(elm[3]==='select'){
                $(`select[name="${errorField}"`).siblings('small').text(errorMsg).css({'color':"red"});
                //$(`#${errorField}`).siblings('small').text(errorMsg).css({'color':"red"});

            }else{
                $(`input[name="${errorField}"`).siblings('small').text(errorMsg).css({'color':"red"});
            }
        }
        
        
        
    }
}
function getBooksList(id,ref_no){

    $.ajax({
            method: "POST",
            url: "book_edit_details.php",
            data: {'location_id': id,'ref_no': ref_no},
            success: function(res) {
               console.log(res);

                $('#tbl_case_law').html(res);
                $('#case_law').DataTable();
                //update();
                //$('#detailsModal_27').modal('hide');

            }
        })
}
function get_book_status(ref_no){
    $.ajax({
            method: "POST",
            url: "get_book_status.php",
            data: {'ref_no': ref_no},
            success: function(res) {
               // alert(res);
                $('#tbl_case_law').html(res);
                $('#case_law').DataTable();
            }
        })
}
function get_member_book_list(book_name,author_name,acc_no){
    $.ajax({
            method: "POST",
            url: "get_member_book_list.php",
            data: {'book_name': book_name,'author_name': author_name,'acc_no': acc_no},
            beforeSend: function(){
               $('.loader').show();
                  //  $('#send_email').prop('disabled', true);
                },
            success: function(res) {
               // alert(res);
                $('#tbl_case_law').html(res);
                $('#case_law').DataTable();
                $('.loader').hide();
                //update();
                //$('#detailsModal_27').modal('hide');

            }
        })
}
function verify_member_request_book_list(req_upto_date){
      $.ajax({
                  method: "POST",
                  url: "verify_book_request.php",
                  data: {'req_upto_date': req_upto_date},
                  success: function(res) {
                     //alert(res)
                      $('#tbl_book_list').html(res);
                      $('#book_table').DataTable();
                      //update();
                      //$('#detailsModal_27').modal('hide');
      
                  }
              })
  }
function get_member_request_book_list(req_upto_date,status_type){
    $.ajax({
                method: "POST",
                url: "get_member_request_book_list.php",
                data: {'req_upto_date': req_upto_date,'status_type': status_type},
                beforeSend: function(){
                    $('.loader').show();
                     },
                success: function(res) {
                    $('.loader').hide();
                    $('#tbl_book_list').html(res);
                     $('#book_table').DataTable({
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All'],
                        ],
                    });

                }
            })
}
function get_member_book_request_report(){
      $.ajax({
                  method: "POST",
                  url: "get_member_book_request_report.php",
                  data: '',
                  success: function(res) {
                     //alert(res)
                      $('#tbl_book_list').html(res);
                      $('#book_table').DataTable();
                      //update();
                      //$('#detailsModal_27').modal('hide');
      
                  }
              })
  }
  function get_book_edit_list(book_name,author_name){
    $.ajax({
            method: "POST",
            url: "get_book_edit_list.php",
            data: {'book_name': book_name,'author_name': author_name},
            beforeSend: function(){
               $('.loader').show();
                  //  $('#send_email').prop('disabled', true);
                },
            success: function(res) {
               // alert(res);
                $('#tbl_case_law').html(res);
                $('#case_law').DataTable();
                $('.loader').hide();
                //update();
                //$('#detailsModal_27').modal('hide');

            }
        })
}
function get_user_list(user_name,phone_no){
    $.ajax({
        method: "POST",
        url: "get_user_list.php",
        data: {'user_name': user_name,'phone_no': phone_no},
        beforeSend: function(){
           $('.loader').show();
              //  $('#send_email').prop('disabled', true);
            },
        success: function(res) {
           // alert(res);
            $('#tbl_case_law').html(res);
            $('#case_law').DataTable();
            $('.loader').hide();
            //update();
            //$('#detailsModal_27').modal('hide');

        }
    })
}

function closeAlertBox(){
window.setTimeout(function () {
$("#alert_msg").fadeOut(1000)
}, 3000);
}
