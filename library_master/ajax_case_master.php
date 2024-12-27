<?php
include('../admin/database.php');
include('../admin/utility.php');
include('../admin/formValidation.php');
session_start();
$db = new Database();
$check = new Validation;

$utl = new Utility;
$user_id = $_SESSION['user_id'];
$pos = array_search("action", array_keys($_POST));
$frm_data = array_splice($_POST, 0, $pos);
//print_r($_POST);

if (!empty($_POST['rules'])) {
  $obj = stripcslashes($_POST['rules']);
  $rules = json_decode($obj, true);
}
if (isset($_POST['action']) && $_POST['action'] == 'add_master') {
  if (isset($frm_data["csrf_token"]) && isset($_SESSION["csrf_token"]) && $frm_data["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($frm_data['csrf_token']);
    //print_r($frm_data);

    $isValid = $check->checkValidation($frm_data, $rules);
    if ($isValid == 1) {
      $update_id = $_POST['update_id'];
      $table = $_POST['table'];
      //update
      if ($update_id != '') {
        $db->update($table, $frm_data, 'id=' . $update_id);
        $res = $db->getResult();

        if ($res) {
          echo "success#" . $res[1];
        } else {

          echo "error#" . $res[0];
        }
      }
      //add
      else {
        if (!empty($user_id)) {
          $db->insert($table, $frm_data);
          $res = $db->getResult();
          //print_r($res);
          if ($res) {
            $db->insert_audit_trail_details($table, 'Successfully Inserted', 1);
            echo "success#" . $res[1];
          } else {
            $db->insert_audit_trail_details($table, 'Insertion Failed', 0);
            echo "error#" . $res[0];
          }
        } else {
          echo "error#Session has expired";
        }
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
if (isset($_POST['action']) && $_POST['action'] == 'book_request') {

      $update_id = $_POST['update_id'];
      $table = $_POST['table'];
      //update
      if ($update_id != '') {
        $db->update($table, $frm_data, 'id=' . $update_id);
        $res = $db->getResult();

        if ($res) {
          echo "success#" . $res[1];
        } else {

          echo "error#" . $res[0];
        }
      }
      //add
      else {
        if (!empty($user_id)) {
          $db->insert($table, $frm_data);
          $res = $db->getResult();
          //print_r($res);
          if ($res) {
            $db->insert_audit_trail_details($table, 'Successfully Requested', 1);
            echo "success#" . $res[1];
          } else {
            $db->insert_audit_trail_details($table, 'Request Failed', 0);
            echo "error#" . $res[0];
          }
        } else {
          echo "error#Session has expired";
        }
      }
}
//remove case(update status only)
if (isset($_POST['action']) && $_POST['action'] == 'remove_case') {
  $case_id = $_POST['case_id'];
  $table = $_POST['table'];

  $db->update($table, ["status" => 0], 'id=' . $case_id);
  $res = $db->getResult();
  // print_r($res);
  if ($res) {
    echo "success#" . $res[1];
  } else {
    //print_r($db->getResult());
    echo "error#" . $res[0];
  }
}
//Delete book(update status only)
if (isset($_POST['action']) && $_POST['action'] == 'delete_case') {
  $book_id = $_POST['book_id'];
  $table = $_POST['table'];

  $db->update($table, ["status" => 2], 'id=' . $book_id);
  $res = $db->getResult();
  // print_r($res);
  if ($res) {
    echo "success#" . $res[1];
  } else {
    //print_r($db->getResult());
    echo "error#" . $res[0];
  }
}
//Delete from table 
if (isset($_POST['action']) && $_POST['action'] == 'delete_data') {
  $delete_id = $_POST['delete_id'];
  $table = $_POST['table'];

  $db->delete($table, 'id=' . $delete_id);
  $res = $db->getResult();
  //print_r($res);
  if ($res) {
    echo "success#" . $res[0];
  } else {
    //print_r($db->getResult());
    echo "error#" . $res[1];
  }
}
//update status of book request table 
if (isset($_POST['action']) && $_POST['action'] == 'update_manual') {
  $update_id = $_POST['update_id'];
  $status = $_POST['status'];
  $table = $_POST['table'];

  $db->update($table, ["status" => $status], 'id=' . $update_id);
  $res = $db->getResult();
  // print_r($res);
  if ($res) {
    echo "success#" . $res[1];
  } else {
    //print_r($db->getResult());
    echo "error#" . $res[0];
  }
}
//update status of book issue table 
if (isset($_POST['action']) && $_POST['action'] == 'update_issue_tbl') {
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    //print_r($frm_data);

    $isValid = $check->checkValidation($_POST, $rules);
    if ($isValid == 1) {
      $ref_update_id = $_POST['book_ref_no'];
      $issue_update_id = $_POST['issue_update_id'];
      $issue_date = $_POST['issue_date'];
      $request_date = $_POST['request_date'];
      $no_of_days = $_POST['no_of_days'];
      $prog_end_date = strtotime($_POST['prog_end_date']);
      $nw_due_date = strtotime($_POST['nw_due_date']);
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      if ($nw_due_date > $prog_end_date) {
        echo "error#No. of days should not be greater than the program end day";
      } else if ($issue_date < $request_date) {
        echo "error#Issue date should be greater than request date";
      } else {
        $db->update($table1, ["bk_ref_id" => $ref_update_id, "issue_date" => $issue_date, "no_of_days" => $no_of_days, "status" => 2], 'id=' . $issue_update_id);
        $res1 = $db->getResult();
        if ($res1) {
          $db->update($table2, ["status" => 1], 'id=' . $ref_update_id);
          $res2 = $db->getResult();
        }
        if ($res2) {
          $db->insert_audit_trail_details($table2, 'Successfully Issued', 1);
          echo "success#" . $res2[1];
        } else {
          //print_r($db->getResult());
          $db->insert_audit_trail_details($table2, 'Issuance failed', 0);
          echo "error#" . $res2[0];
        }
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//add book details
if (isset($_POST['action']) && $_POST['action'] == 'inesrt_book_details') {
  if (isset($frm_data["csrf_token"]) && isset($_SESSION["csrf_token"]) && $frm_data["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    //print_r($frm_data); exit;
    unset($frm_data['csrf_token']);


    $isValid = $check->checkValidation($frm_data, $rules);
    if ($isValid == 1) {
      $quantity = $frm_data['quantity'];
      $book_name = $frm_data['book_name'];
      $author_name = $frm_data['author_name'];
      $edition = $frm_data['edition'];
      $year_of_publication = $frm_data['year_of_publication'];
      $place_publisher = $frm_data['place_publisher'];
      $volume = $frm_data['volume'];
      $page = $frm_data['page'];
      $price = $frm_data['price'];
      $location = $frm_data['location'];
      $row = $frm_data['row'];
      $book_type = $frm_data['book_type'];
      $subject_id = $frm_data['subject_name'];
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      $cnt_ext_ref = array();
      $obj = stripcslashes($_POST['book_acc_no']);
      $book_ref_no = json_decode($obj, true);
      foreach ($book_ref_no as $ref) {
        $db->select($table2, "*", null, 'reference_no= "' . $ref . '"', null, null);
        $res_book_ref = $db->getResult();
    
        if (!empty($res_book_ref)) {
          $cnt_ext_ref[] =  $ref;
        }
      }
      if (!empty($cnt_ext_ref)) {
        echo 'accesno#' . implode(',', $cnt_ext_ref);
      }
       else {
        if (!empty($_FILES['cover_photo']['name'])) {
          $filename = strtolower(basename($_FILES['cover_photo']['name']));
          $exts = substr($filename, strrpos($filename, '.') + 1);
          $md_referenceno = gen_uuid();
          $ext = "." . $exts;
          $new_filename = '../images/cover_photo/' . $md_referenceno .$ext;
          $allowed = array('jpeg', 'png', 'jpg');
          if (!in_array($exts, $allowed)) {
            echo 'error#Uploaded file is not a valid image.';
          } else {
            move_uploaded_file($_FILES['cover_photo']['tmp_name'], $new_filename);
            $doc_name = $md_referenceno .$ext;
            $txt_photo = $doc_name;
          }
        }  else
          {
            $txt_photo = 'null';
          }
        $frm_data1 = array(
          'book_name' => $book_name,
          'author_name' => $author_name,
          'quantity' => $quantity,
          'subject_id' => $subject_id,
          'book_type' => $book_type,
          'cover_photo' => $txt_photo,
          'status' => 0
        );
        $db->insert($table1, $frm_data1);
        $res1 = $db->getResult();
        $last_insert_id = $res1['0'];
        if ($last_insert_id != '') {
          foreach ($book_ref_no as $ref) {
            $frm_data2 = array(
              'tbl_book_id' => $last_insert_id,
              'reference_no' => $ref,
              'book_name' => $book_name,
              'author_name' => $author_name,
              'edition' => $edition,
              'year_of_publication' => $year_of_publication,
              'place_publisher' => $place_publisher,
              'volume' => $volume,
              'page' => $page,
              'price' => $price,
              'location' => $location,
              'row' => $row,
              'status' => 0
            );
            $db->insert($table2, $frm_data2);
            $res2 = $db->getResult();
          }
          if ($res2) {
            $db->insert_audit_trail_details($table2, 'Successfully Inserted', 1);
            echo "success#" . $res2[1];
          } else {
            $db->insert_audit_trail_details($table2, 'Insertion Failed', 0);
            echo "error#";
          }
        }
      }
    }else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
  // print_r($cnt_ext_ref);
}
if (isset($_POST['action']) && $_POST['action'] == 'update_book_details') {
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    $isValid = $check->checkValidation($_POST, $rules);
    if ($isValid == 1) {
      //echo $isValid; 
      $update_id = $_POST['update_id'];
      $bk_update_id = $_POST['bk_update_id'];
      $book_ref_no = $_POST['book_ref_no'];
      //$quantity=$_POST['quantity'];
      $book_name = $_POST['book_name'];
      $author_name = $_POST['author_name'];
      $edition = $_POST['edition'];
      $year_of_publication = $_POST['year_of_publication'];
      $place_publisher = $_POST['place_publisher'];
      $page = $_POST['page'];
      $volume = $_POST['volume'];
      $price = $_POST['price'];
      $location = $_POST['location'];
      $row = $_POST['row'];
      $book_type = $_POST['book_type'];
      $subject_id = $_POST['book_sub'];
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      //print_r($book_ref_no);
      $frm_data1 = array(
        'book_name' => $book_name,
        'author_name' => $author_name,
        'subject_id' => $subject_id,
        'book_type' => $book_type,
        'status' => 0
      );
      $db->update($table1, $frm_data1, 'id=' . $bk_update_id);
      $res = $db->getResult();

      if ($res) {
        $frm_data2 = array(
          'reference_no' => $book_ref_no,
          'edition' => $edition,
          'year_of_publication' => $year_of_publication,
          'place_publisher' => $place_publisher,
          'volume' => $volume,
          'page' => $page,
          'price' => $price,
          'location' => $location,
          'row' => $row
        );
        $db->update($table2, $frm_data2, 'id=' . $update_id);
        echo "success#";
        $db->insert_audit_trail_details($table2, 'Successfully Updated', 1);
      } else {
        //print_r($db->getResult());
        echo "error#";
        $db->insert_audit_trail_details($table2, 'Updation Failed', 0);
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//update status of book issue table 
if (isset($_POST['action']) && $_POST['action'] == 'update_return_tbl') {
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    $isValid = $check->checkValidation($_POST, $rules);
    if ($isValid == 1) {
     // echo $isValid; 
      $bk_req_id = $_POST['bk_req_id'];
      $bk_user_id = $_POST['bk_user_id'];
      $book_ref_number = $_POST['book_ref_id'];
      $return_date = $_POST['return_date'];
      $fine = $_POST['fine'];
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      $issue_date = $_POST['issue_date'];
      if ($return_date < $issue_date) {
        echo "error#Return date should be greater than issue date";
      } else {
        $db->update($table1, ["return_date" => $return_date, "fine" => $fine, "status" => 4], 'id= "'.$bk_req_id.'" and user_id= "'.$bk_user_id.'"');
        $res = $db->getResult();
        $db->update($table2, ["status" => 0], 'reference_no=' . $book_ref_number);
        $res2 = $db->getResult();
        if ($res) {
          echo "success#" . $res[1];
          $db->insert_audit_trail_details($table2, 'Successfully Returned', 1);
        } else {
          echo "error#" . $res[0];
          $db->insert_audit_trail_details($table2, 'Return Failed', 0);
        }
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
if (isset($_POST['action']) && $_POST['action'] == 'get_ref_number') {
  $qnt_val = $_POST['val_qnt'];
  $ref_no = $_POST['ref_no'];
  if (!empty($qnt_val)) {
    //$ref_no = $_POST['ref_no'];
?>
    <div class="col-9" style="margin-left:4%;margin-right:2%;padding:1%">
      <label>Acc. No :</label>
      <?php
      for ($i = 1; $i <= $qnt_val; $i++) {

      ?>
        <input class="form-control me-3" name="book_reff_no[]" id="book_reff_no" value="<?= isset($ref_no) ? $ref_no : '' ?>" placeholder="Enter Acc. No." required></br>
      <?php if (is_numeric($_POST['ref_no'])) {
          $ref_no = $ref_no + 1;
        }
      } ?>
    </div>
  <?php }
  ?>


<?php
}
//update/Insert Book Quantity in book details table 

if (isset($_POST['action']) && $_POST['action'] == 'update_book_qt_details') {
 
  if (isset($frm_data["csrf_token"]) && isset($_SESSION["csrf_token"]) && $frm_data["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($frm_data['csrf_token']);
    $isValid = $check->checkValidation($frm_data, $rules);
    // echo $isValid;
    //exit;
    if ($isValid == 1) {
      $bk_update_id = $frm_data['update_id'];
      $quantity = $frm_data['quantity'];
      if (!empty($_POST['book_ref_no'])) {
        $book_ref_no = $_POST['book_ref_no'];
      }
      $book_name = $frm_data['book_name_cpy'];
      $author_name = $frm_data['author_name_cpy'];
      $edition = $frm_data['edition'];
      $year_of_publication = $frm_data['year_of_publication'];
      $place_publisher = $frm_data['place_publisher'];
      $page = $frm_data['page'];
      $price = $frm_data['price'];
      $location = $frm_data['location'];
      $row = $frm_data['row'];
      $book_type = $frm_data['book_type'];
      $subject_id = $frm_data['book_sub'];
       
      if (!empty($_FILES['cover_photo']['name'])) {
        $filename = strtolower(basename($_FILES['cover_photo']['name']));
        $exts = substr($filename, strrpos($filename, '.') + 1);
        $md_referenceno = gen_uuid();
        $ext = "." . $exts;
        $new_filename = '../images/cover_photo/' . $md_referenceno .$ext;
        $allowed = array('jpeg', 'png', 'jpg');
        if (!in_array($exts, $allowed)) {
          echo 'error#Uploaded file is not a valid image.';
        } else {
          $file_to_delete = '../images/cover_photo/' . $frm_data['hdn_photo'];
          unlink($file_to_delete);
          move_uploaded_file($_FILES['cover_photo']['tmp_name'], $new_filename);
          $doc_name = $md_referenceno .$ext;
          $txt_photo = $doc_name;
        }
      } else {
        $txt_photo = $frm_data['hdn_photo'];
      }
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      //print_r($book_ref_no);
      $frm_data1 = array(
        'book_name' => $book_name,
        'author_name' => $author_name,
        'quantity' => $quantity,
        'subject_id' => $subject_id,
        'book_type' => $book_type,
        'cover_photo' => $txt_photo,
        'status' => 0
      );
      $db->update($table1, $frm_data1, 'id=' . $bk_update_id);
      $res = $db->getResult();
      $frm_data3 = array(
        'book_name' => $book_name,
        'author_name' => $author_name,
      );
      $db->update($table2, $frm_data3, 'tbl_book_id=' . $bk_update_id);
      $res1 = $db->getResult();
      if ($res) {
        if (!empty($book_ref_no)) {
          foreach ($book_ref_no as $ref) {
            $frm_data2 = array(
              'tbl_book_id' => $bk_update_id,
              'reference_no' => $ref,
              'book_name' => $book_name,
              'author_name' => $author_name,
              'edition' => $edition,
              'year_of_publication' => $year_of_publication,
              'place_publisher' => $place_publisher,
              'page' => $page,
              'price' => $price,
              'location' => $location,
              'row' => $row,
              'status' => 0
            );
            $db->insert($table2, $frm_data2);
          }
        }
        $db->insert_audit_trail_details($table2, 'Successfully Inserted', 1);
        echo "success#";
      } else {
        $db->insert_audit_trail_details($table2, 'Insertion Failed', 0);
        //print_r($db->getResult());
        echo "error#";
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//Merge Book data
if (isset($_POST['action']) && $_POST['action'] == 'merge_book') {
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    //print_r($frm_data);

    $isValid = $check->checkValidation($_POST, $rules);
    //echo $isValid;
    //exit;
    if ($isValid == 1) {
      $old_bk_id = $_POST['old_bk_name'];
      $new_bk_id = $_POST['new_book'];
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      $old_quantity = $_POST['old_quantity'];
      $db->update($table2, ["tbl_book_id" => $new_bk_id], 'tbl_book_id=' . $old_bk_id);
      $res = $db->getResult();
      if (!empty($res)) {
        $sql1 = "UPDATE tbl_book_details SET quantity = quantity+" . $old_quantity . " WHERE id= '" . $new_bk_id . "'";
        $db->update_dir($sql1);

        $db->update($table1, ["status" => 2], 'id=' . $old_bk_id);

        echo "success#";
        $db->insert_audit_trail_details($table1, 'Successfully Merged', 1);
      } else {
        //print_r($db->getResult());
        $db->insert_audit_trail_details($table1, 'Merging Failed', 0);
        echo "error#";
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//Delete from table 
if (isset($_POST['action']) && $_POST['action'] == 'delete_book_type') {
  $delete_id = $_POST['delete_id'];
  $table = $_POST['table'];
  $db->select('tbl_subject_name', "*", null, 'book_category= "' . $delete_id . '"', null, null);
  $res_book_cat = $db->getResult();
  if (!empty($res_book_cat)) {
    echo "error#First delete subject of this Book Type";
  } else {
    $db->delete($table, 'id=' . $delete_id);
    $res = $db->getResult();
    //print_r($res);
    if ($res) {
      echo "success#" . $res[0];
    } else {
      //print_r($db->getResult());
      echo "error#" . $res[1];
    }
  }
}
//Book Renew Details
if (isset($_POST['action']) && $_POST['action'] == 'insert_renew_tbl') {
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    //print_r($frm_data);

    $isValid = $check->checkValidation($_POST, $rules);
    //echo $isValid;
    //exit;
    if ($isValid == 1) {
      $bk_req_id = $_POST['bk_req_id'];
      $renew_date = $_POST['renew_date'];
      $no_of_days = $_POST['renew_no_of_days'];
      $table1 = $_POST['table1'];
      $table2 = $_POST['table2'];
      //print_r($book_ref_no);
      $frm_data1 = array(
        'bk_issue_id' => $bk_req_id,
        'renew_date' => $renew_date,
        'no_of_days' => $no_of_days,
        'status' => '0',
        'user_id' => $user_id,
        'created_date' => date("Y-m-d H:i:s")
      );
      $db->insert($table1, $frm_data1);
      $res = $db->getResult();
      if ($res) {
        $sql1 = "UPDATE $table2 SET no_of_days = no_of_days + " . $no_of_days . " WHERE id= '" . $bk_req_id . "'";
        $db->update_dir($sql1);
        echo "success#";
        $db->insert_audit_trail_details($table2, 'Successfully Renewed', 1);
      } else {
        //print_r($db->getResult());
        $db->insert_audit_trail_details($table2, 'Renewal Failed', 0);
        echo "error#";
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
if (isset($_POST['action']) && $_POST['action'] == 'update_missing_book') {
  //print_r($_POST); exit;
  if (isset($_POST["csrf_token"]) && isset($_SESSION["csrf_token"]) && $_POST["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($_POST['csrf_token']);
    //print_r($frm_data);

    $isValid = $check->checkValidation($_POST, $rules);
    //echo $isValid;
    //exit;
    if ($isValid == 1) {
      $reference_id = $_POST['reference_num'];
      $lost_type = $_POST['lost_type'];
      $table = $_POST['table'];

      $db->update($table, ["lost_status" => $lost_type], 'id=' . $reference_id);
      $res = $db->getResult();
      // print_r($res);
      if ($res) {
        echo "success#" . $res[1];
        $db->insert_audit_trail_details($table2, 'Succefully Saved', 1);
      } else {
        //print_r($db->getResult());
        echo "error#" . $res[0];
        $db->insert_audit_trail_details($table2, 'Updataion Failed', 0);
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
if (isset($_POST['action']) && $_POST['action'] == 'delete_missing_book') {
  //print_r($_POST); exit;

  $reference_id = $_POST['reference_id'];
  $lost_type = $_POST['lost_type'];
  $table = $_POST['table'];

  $db->update($table, ["lost_status" => $lost_type], 'id=' . $reference_id);
  $res = $db->getResult();
  // print_r($res);
  if ($res) {
    $db->insert_audit_trail_details($table, 'Succefully Deleted', 1);
    echo "success#" . $res[1];
  } else {
    $db->insert_audit_trail_details($table, 'Deletion Failed', 0);
    echo "error#" . $res[0];
  }
}
if (isset($_POST['action']) && $_POST['action'] == 'check_exist_book') {
      $book_name = trim($_POST['book_name']);
      $author_name = trim($_POST['author_name']);

      $sql = 'SELECT * FROM tbl_book_details WHERE book_name= "' . $book_name . '" and author_name ="' . $author_name . '"';
      $res_book_det = $db->select_sql_row($sql);
      if (!empty($res_book_det)) {
        echo 'err#Book - ' . $book_name . ', Author -' . $author_name . ' Already Present. ';
      } else {
        echo "success#";
      }
     
}
//check book during edit update book
if (isset($_POST['action']) && $_POST['action'] == 'check_same_book_exist') {
  $book_id = $_POST['update_id'];
  $book_name = trim($_POST['book_name']);
  $author_name = trim($_POST['author_name']);

  $sql = 'SELECT * FROM tbl_book_details WHERE id != "' . $book_id . '" and book_name= "' . $book_name . '" and author_name ="' . $author_name . '"';
  $res_book_det = $db->select_sql_row($sql);
  if (!empty($res_book_det)) {
    echo 'error#Book - ' . $book_name . ', Author -' . $author_name . ' Already Present. ';
  } else {
    echo "success#";
  }
}
//add staff master
if (isset($_POST['action']) && $_POST['action'] == 'add_staff_master') {

  if (isset($frm_data["csrf_token"]) && isset($_SESSION["csrf_token"]) && $frm_data["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($frm_data['csrf_token']);

    $isValid = $check->checkValidation($frm_data, $rules);
    if ($isValid == 1) {
      $staff_type = $frm_data['staff_type'];
      $name = $frm_data['name'];
      $desig = $frm_data['desig'];
      $address = $frm_data['address'];
      $phone_num = $frm_data['phone'];
      $email = $frm_data['email'];
      //image upload
      $filename = strtolower(basename($_FILES['photo']['name']));
      $exts = substr($filename, strrpos($filename, '.') + 1);
      $md_referenceno = gen_uuid();
      $ext = "." . $exts;
      $new_filename = '../images/staff/' . $md_referenceno . $ext;
      $allowed = array('jpeg', 'png', 'jpg');
      if (!in_array($exts, $allowed)) {
        echo 'error#Uploaded file is not a valid image.';
      } else {
        move_uploaded_file($_FILES['photo']['tmp_name'], $new_filename);
        $doc_name = $md_referenceno . $ext;
        $frm_data['image'] = $doc_name;
        $roll_id = '';
        $newstring = substr($phone_num, -5);
        $pass = "Mdrafm@" . $newstring;
        $psw = trim($pass);
        $encryptedpass = password_hash($psw, PASSWORD_BCRYPT);

        $form_tbl2 = array(
          'roll_id' => '3',
          'username' => $phone_num,
          'name' => $name,
          'email' => $email,
          'password' => $encryptedpass,
          'status' => '1',
          'create_on' => date("Y-m-d H:i:s")
        );
        //print_r($form_tbl1);
        //print_r($form_tbl2); exit;
        $table = $_POST['table'];
        $sql = 'SELECT * FROM tbl_staf_master WHERE phone = "' . $phone_num . '"';
        $res_stff = $db->select_sql_row($sql);
        if (!empty($res_stff)) {
          echo 'error#Staff Already Present. ';
        } else {
          $db->insert('tbl_user', $form_tbl2);
          $res1 = $db->getResult();
          $last_insert_id = $res1['0'];
          $form_tbl1 = array(
            'user_id' => $last_insert_id,
            'type' => $staff_type,
            'name' => $name,
            'desig' => $desig,
            'address' => $address,
            'phone' => $phone_num,
            'email' => $email,
            'image' => $frm_data['image'],
            'status' => 1
          );
          if ($res1) {
            $db->insert($table, $form_tbl1);
            $res = $db->getResult();
            echo "success#" . $phone_num . "#" . $psw . "#" . $email;
          } else {
            //print_r($db->getResult());
            echo "error#";
          }
        }
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//Delete Staff details
//print_r($_POST);exit;
if (isset($_POST['action']) && $_POST['action'] == 'delete_staff_details') {

  $delete_id = $_POST['delete_id'];
  $table = $_POST['table'];
  $sql = 'Delete tbl_staf_master,tbl_user FROM tbl_staf_master INNER JOIN tbl_user ON tbl_user.id = tbl_staf_master.user_id WHERE tbl_staf_master.id ="' . $delete_id . '"';
  //print_r($_POST);exit;
  $db->delete_sql($sql);
  $res = $db->getResult();
  //print_r($res);
  if ($res) {
    echo "success#" . $res[0];
  } else {
    echo "error#" . $res[1];
  }
}
//Update staff master
if (isset($_POST['action']) && $_POST['action'] == 'update_staff_master') {
  if (isset($frm_data["csrf_token"]) && isset($_SESSION["csrf_token"]) && $frm_data["csrf_token"] == $_SESSION["csrf_token"]) {
    //echo 123;
    unset($frm_data['csrf_token']);

    $isValid = $check->checkValidation($frm_data, $rules);
    if ($isValid == 1) {
      //print_r($frm_data);
      $staff_type = $frm_data['staff_type'];
      $name = $frm_data['name'];
      $desig = $frm_data['desig'];
      $address = $frm_data['address'];
      $phone_num = $frm_data['phone'];
      $email = $frm_data['email'];
      if (!empty($_FILES['photo']['name'])) {
        $filename = strtolower(basename($_FILES['photo']['name']));
        $exts = substr($filename, strrpos($filename, '.') + 1);
        $md_referenceno = gen_uuid();
        $ext = "." . $exts;
        $new_filename = '../images/staff/' . $md_referenceno . $ext;
        $allowed = array('jpeg', 'png', 'jpg');
        if (!in_array($exts, $allowed)) {
          echo 'error#Uploaded file is not a valid image.';
        } else {
          move_uploaded_file($_FILES['photo']['tmp_name'], $new_filename);
          $doc_name = $md_referenceno . $ext;
          $txt_photo = $doc_name;
        }
      } else {
        $txt_photo = $frm_data['hdn_photo'];
      }
      $form_tbl2 = array(
        'username' => $phone_num,
        'name' => $name,
        'email' => $email,
      );
      //print_r($form_tbl1);
      //print_r($form_tbl2); exit;
      $update_id = $frm_data['update_id'];
      $update_user_id = $frm_data['update_user_id'];
      $table = $_POST['table'];
      $sql = 'SELECT * FROM tbl_staf_master WHERE phone = "' . $phone_num . '" and id!="' . $update_id . '"';
      $res_stff = $db->select_sql_row($sql);
      if (!empty($res_stff)) {
        echo 'error#Staff Already Present. ';
      } else {
        $form_tbl1 = array(
          'type' => $staff_type,
          'name' => $name,
          'desig' => $desig,
          'address' => $address,
          'phone' => $phone_num,
          'email' => $email,
          'image' => $txt_photo,
        );
        $db->update($table, $form_tbl1, 'id=' . $update_id);
        $res = $db->getResult();
        if ($res) {
          $db->update('tbl_user', $form_tbl2, 'id=' . $update_user_id);
          $res1 = $db->getResult();
          echo "success#";
        } else {
          //print_r($db->getResult());
          echo "error#";
        }
      }
    } else {
      echo $isValid;
    }
  } else {
    echo  "error#Security alert: Unable to process your request";
  }
}
//remove case(update status only)
if (isset($_POST['action']) && $_POST['action'] == 'active_inactive_status') {
  $update_id = $_POST['update_id'];
  $table = $_POST['table'];

  $db->update($table, ["status" => 0], 'id=' . $update_id);
  $res = $db->getResult();
  // print_r($res);
  if ($res) {
    echo "success#" . $res[1];
  } else {
    //print_r($db->getResult());
    echo "error#" . $res[0];
  }
}
function gen_uuid()
{
  $s = strtoupper(md5(uniqid(date("YmdHis"), true)));
  $guidText = substr($s, 0, 4) . "-" . substr($s, 4, 4) . "-";

  $date = date("his");
  return "mdrafm-" . $guidText . $date;
}
if(isset($_POST['action']) && $_POST['action'] == 'get_issued_list') {
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  $db->select('tbl_book_details',"tbl_bk.id,tbl_bk.book_name,tbl_bk.author_name,tbl_bk.quantity,tbl_bk_req.id as bk_req_id,tbl_bk_req.request_date,
    tbl_bk_req.status,tbl_user.name,tbl_fclty.desig as f_desig,tbl_fclty.phone,tbl_fclty.email,tbl_trainee.phone as t_phone,tbl_trainee.email as t_email,tbl_trainee.trng_type as new_trng_type,tbl_trainee.program_id as new_program_id,tbl_trainee.designation as t_desig,tbl_bk_req.issue_date,
    tbl_bk_req.no_of_days,tbl_bk_req.return_date,tbl_bk_req.fine,tbl_bk_ref.reference_no,tbl_staff.phone as s_phone,tbl_staff.email as s_email,tbl_staff.desig as s_desig,tbl_dpt_trne.designation as d_desig,tbl_dpt_trne.phone as d_phone,tbl_dpt_trne.email as d_email,tbl_dpt_trne.trng_type as d_trng_type,tbl_dpt_trne.program_id as d_program_id",' 
    tbl_bk LEFT JOIN tbl_book_request_issue tbl_bk_req ON tbl_bk_req.book_id =tbl_bk.id left outer join tbl_book_reference_no tbl_bk_ref ON 
    tbl_bk_ref.id =tbl_bk_req.bk_ref_id JOIN tbl_user ON tbl_user.id =tbl_bk_req.user_id left outer join tbl_new_recruite as tbl_trainee 
    on tbl_trainee.user_id= tbl_bk_req.user_id left outer join tbl_faculty_master as tbl_fclty 
    on tbl_fclty.user_id= tbl_bk_req.user_id left outer join tbl_staf_master as tbl_staff
    on tbl_staff.user_id= tbl_bk_req.user_id left outer join tbl_dept_trainee_registration as tbl_dpt_trne on tbl_dpt_trne.user_id= tbl_bk_req.user_id','tbl_bk_req.issue_date >= "'.$from_date.'" and tbl_bk_req.issue_date <= "' . $to_date . '" and tbl_bk_req.status >= "1"
    GROUP BY tbl_bk_req.id','tbl_bk_req.request_date desc',null); 
  //$db->select('tbl_book_request_issue', "*", null, 'issue_date >= "' . $from_date . '" and issue_date <= "' . $to_date . '"', null, null);
  $res_book = $db->getResult();
  ?>
  <table id="book_table" class="table">
                            <thead class="" style="background: #315682;color:#fff;">
                            <th style="width:;">Sl</th>
                            <th  style="width:100px;">Req Date</th>
                            <th>Name </th>
                            <th>Designation</th>
                            <th>Phone</th>
                            <th>Book Name</th>
                            <th style="width:;">Author Name</th>
                            <th>Acc. No.</th>
                            <th>Issue Date</th>
                            <th>No of Days</th>
                            <th>Return Date</th>
                            </thead>
                            <tbody>
                            <?php 
                           // print_r($res_book);
                            $sl_no=1;
  foreach($res_book as $res)
  {
    $id=$res['id'];
    $bk_req_id=$res['bk_req_id'];
    $request_date=$res['request_date'];
    $name=$res['name'];
    $book_name=$res['book_name'];
    $author_name=$res['author_name'];
    $reference_no=$res['reference_no'];
    $issue_date=$res['issue_date'];
    $no_of_days=$res['no_of_days'];
    $return_date=$res['return_date'];
    $fine=$res['fine'];
    if(!empty($res['new_trng_type']))
    {
        $tranie_type=$res['new_trng_type'];
    }else if(!empty($res['d_trng_type']))
    {
        $tranie_type=$res['d_trng_type'];
    }
    else
    {
        $tranie_type='';
    }
    if(!empty($res['new_program_id']))
    {
        $program_id=$res['new_program_id'];
    }else if(!empty($res['d_program_id']))
    {
        $program_id=$res['d_program_id'];
    }
    else
    {
        $program_id='';
    }
    
   // $designation=$res['s_desig'];
    
    if(!empty($res['f_desig']))
    {
        $desig=$res['f_desig'];
    }
    else if(!empty($res['s_desig']))
    {
        $desig=$res['s_desig'];
    }
    else if(!empty($res['d_desig']))
    {
        $desig=$res['d_desig'];
    }else if(!empty($res['t_desig']))
    {
        $desig=$res['t_desig'];
    }
    else{
        $desig="Trainee";
    }
    $phone_num=$res['phone'];
    $t_phone=$res['t_phone'];
    $s_phone=$res['s_phone'];
    $d_phone=$res['d_phone'];
    if(!empty($phone_num))
    {
        $phone=$phone_num;
    }
    else if(!empty($t_phone)){
        $phone=$t_phone;
    }
    else if(!empty($s_phone)){
        $phone=$s_phone;
    }
    else if(!empty($d_phone)){
        $phone=$d_phone;
    }

    $f_email=$res['email'];
    $t_email=$res['t_email'];
    $s_email=$res['s_email'];
    $d_email=$res['d_email'];
    if(!empty($f_email))
    {
        $email=$f_email;
    }
    else if(!empty($t_email)){
        $email=$t_email;
    }
    else if(!empty($s_email)){
        $email=$s_email;
    } 
    else if(!empty($d_email)){
        $email=$d_email;
    }                   
    ?>
    <tr>
        <td style="text-align:center"><?php echo $sl_no++;?></td>
        <td><?php echo date('d-m-Y',strtotime($request_date))?></td>
        <td><?php echo $name?></td>
        <td><?php echo $desig?></td>
        <td><?=isset($phone)?$phone:''?></td>
        <td><?php echo $book_name?></td>
        <td><?php echo $author_name?></td>
        <?php  if($tranie_type==1 || $tranie_type==2) 
                {
                    $sql = 'SELECT provisonal_Sdate as start_date,provisonal_Edate as end_date FROM tbl_program_master WHERE id= "'.$program_id.'" and trng_type="'.$tranie_type.'"';
                    $res_date= $db->select_sql_row($sql);
                }else if($tranie_type==3 or $tranie_type==7)  
                {
                    $sql = 'SELECT start_date,end_date FROM tbl_mid_program_master WHERE id= "'.$program_id.'" and trng_type="'.$tranie_type.'"';
                    $res_date= $db->select_sql_row($sql);
                }
                else
                {
                    $res_date= '';
                }
                if(!empty($res_date))
                {
                    $upto_st_date=$res_date->start_date;
                    $upto_end_date=date('d-m-Y',strtotime($res_date->end_date));
                }else
                {
                    $upto_end_date='';
                }

        $sql = 'SELECT * FROM tbl_book_request_issue WHERE id= "'.$bk_req_id.'"';
       $res_book= $db->select_sql_row($sql);
       if(!empty($res_book))
       {
        $issue_date=$res_book->issue_date;
        $no_of_days=$res_book->no_of_days;
        $status=$res_book->status;
       }
       else{
        $issue_date='';
        $no_of_days='';
        $status='';
       }
        //$row = $db->fetch_row();
        //echo $status=$row['status']; 
       //echo $issue_date=$row['issue_date']; 
       //echo $no_of_days=$row['no_of_days']; 
        ?>
         <td><?=isset($reference_no)?$reference_no:'';?></td>
        
        <td><?php if(isset($issue_date) && $issue_date !="0000-00-00")
        {
            echo date('d-m-Y',strtotime($issue_date));
        }
       else
       {
            echo "";
       } ?> </td>
        <td>
        <?php if(isset($no_of_days) && $no_of_days !="0")
        {
            echo $no_of_days;
        }
       else
       {
            echo "";
       } ?> 
      </td> 
      <td><?php if(isset($return_date) && $return_date !="0000-00-00")
        {
            echo date('d-m-Y',strtotime($return_date));
        }
       else
       {
            echo "";
       } ?></td>
       <?php
  }
}
?>