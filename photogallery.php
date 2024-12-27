<?php 

include('header.php') ;

?>

<?php 
include('nav_bar.php') 
//echo 123;
?>
<?php
 //include ('admin/database.php');
 $db = new Database();

 //print_r($_POST);
 
 //$db->select('tbl_image_gallery',"*",null,'status=1',null,null);
 $db->select_sql('SELECT * FROM `tbl_image_gallery`  ORDER BY id DESC');

  //print_r( $db->getResult());exit;
  
      ?>
        <div class="news-head">
            <h2>Image Gallery</h2>
        </div>
          <div class="galary min-vh-100">

         
            <div class="container">
                <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3 ">
                    <?php
                   
                    foreach($db->getResult() as $row){
                        //print_r($row);
                        ?>
                            <div class="col"> 
                            <img  src="images/galary/<?php echo $row['image']?>" style="max-width:100%" class="galary-item" alt="images" >
                            <p> <?php echo $row['img_title']?> </p>
                            </div>

                        <?php
                    }
                    ?>
                    
                
                </div>

            </div>
            <

<!-- Modal -->
<div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <img src="" alt="image" class="modal-img" />
      </div>
      
    </div>
  </div>
</div>
            </div>
      

<?php include('footer.php') ?>

<script>
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('galary-item') ){
            const src = e.target.getAttribute('src');
            document.querySelector(".modal-img").src = src;
            var myModal = new bootstrap.Modal(document.getElementById('gallery-modal'))
            myModal.show();
        }
    })
</script>