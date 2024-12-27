<!-- [ navigation menu ] start -->
<style>
   .pcoded-navbar a{
            color: white;
            font-weight: 600;
        }
        a :hover {
            color: black;
            font-weight: bold;
        }
</style>
<?php
session_start(); 

include '../admin/database.php';
$db = new Database();
$_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
 //echo $_SESSION['roll_id'];
 //print_r($_SESSION);
?>
	<nav class="pcoded-navbar" style="background-color:#0693a0 !important">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header" style="background: #f6f6f6;">
						<img class="img-radius" style="width: 89px;margin-bottom: 21px;margin-left: -21px;" src="../images/logo-Copy.png" alt="User-Profile-Image">
						<div class="user-details">
							<span 
                             style="color: #342897;
                                    font-size: 1.2rem;
                                    font-weight: 600;
                                    text-transform: uppercase;" 
                            ><?php echo $_SESSION['name'] ?></span>
							
						</div>
					</div>
					
				</div>
				
				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<!-- <label>Navigation</label> -->
					</li>
					<li class="nav-item">
					    <a href="index.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext" style="font-weight: 600;">Dashboard</span></a>
					</li>
					
					<li class="nav-item pcoded-menu-caption">
						<!-- <label>Pages</label> -->
					</li>
					<?php
					$req_status = 0;

					 $roll_id = explode(',',$_SESSION['roll_id']);
					 foreach($roll_id as $roll){

					 	switch ($roll) {
					 		case '15':
					   	$req_status = 1;
					   	

					 		?>
					 		<li class="nav-item"><a href="book_type_master.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">Add Book Type</span></a></li>
						<li class="nav-item"><a href="subject_master.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">Add Subject</span></a></li>
							<!--<li class="nav-item"><a href="add_book_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">New Book Entry</span></a></li>-->
						<li class="nav-item"><a href="new_book_registration.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">New Book Entry</span></a></li>
						<li class="nav-item"><a href="edit_book_quantity_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">Add Book Copy</span></a></li>
							<li class="nav-item"><a href="edit_book_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i>
						</span><span class="pcoded-mtext">Edit Indivitual Book</span></a></li>
						<li class="nav-item"><a href="merge_book.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Merge Book</span></a></li>
							<li class="nav-item"><a href="book_details_list.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Books In Library</span></a></li>
							<li class="nav-item"><a href="old_book_list.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Old Book Register</span></a></li>
							<li class="nav-item"><a href="issue_book_request.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book Request/Issue</span></a></li>
							<li class="nav-item"><a href="user_book_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">User History</span></a></li>
<li class="nav-item"><a href="book_status_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book Status</span></a></li><li class="nav-item"><a href="book_missing_destroyed_list.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book Lost/Destroyed</span></a></li>
<li class="nav-item"><a href="staff_master_entry.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Staff Entry</span></a></li>
<li class="nav-item"><a href="check_book_issued_trans.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book issued List</span></a></li>

					 		<?php
					 			// code...
					 			break;
					 		case '9':
					 		?>
					 		<li class="nav-item"><a href="member_book_issue.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Find Book</span></a></li>
						<li class="nav-item"><a href="member_book_request_report.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book request register</span></a></li>  
					 		<?php
					 		break;
					 		case '3':
					 		?>
					 		<li class="nav-item"><a href="member_book_issue.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Find Book</span></a></li>
						<li class="nav-item"><a href="member_book_request_report.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book request register</span></a></li>  
					 		<?php
					 		break;

                    case '4':
                    ?>
                    <li class="nav-item"><a href="member_book_issue.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Find Book</span></a></li>
						<li class="nav-item"><a href="member_book_request_report.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Book request register</span></a></li>  
                    <?php
                    break;
                    case '16':
                    $req_status = 0;
                    ?>
                     <li class="nav-item"><a href="get_book_request_details.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Find Book Request</span></a></li> 
                    <?php
                    break;
					 		default:
					 			// code...
					 			break;
					 	}
					 }
					 
						 ?>						
				</ul>
				
				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<script>
  window.csrf = {
    csrf_token: '<?php echo $_SESSION['csrf_token']; ?>'
  };
  $.ajaxSetup({
    data: window.csrf
  });
  jQuery(document).ready(function() {
    jQuery("form").each(function() {
      var tokenElement = jQuery(document.createElement('input'));
      tokenElement.attr('type', 'hidden');
      tokenElement.attr('name', 'csrf_token');
      tokenElement.val('<?= $_SESSION['csrf_token'] ?>');
      jQuery(this).append(tokenElement);
    });
  });
</script>