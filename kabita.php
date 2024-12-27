<?php include('header.php') ?>
<?php include('nav_bar.php') ?>
<?php
// include('admin/database.php');
// $conn = new Database();

if ($_GET['id']) {
    $id = $_GET['id'];
}
?>
<div class="news-head">
    <h2>କବିତା ସଂକଳନ</h2>
</div>
<div class="kabita-wrap">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6 col-sm-12">

            <?php
            $count = 0;
               $conn->select('tbl_odia_kabita',"*",null,'id='.$id,null,null);
               $res = $conn->getResult();
                 foreach($res as $row){
                    ?>
                      <div class="kabita">
                         <h4><?php echo $row['title'] ?></h4>
                          <div class="desc">
                          <?php echo $row['kabita'] ?>
                          </div>
                          <p><?php echo $row['author'] ?></p>
                          <p><?php echo $row['designation'] ?></p>
                      </div>
                    <?php
                 }
            ?>
            </div>
        </div>

    </div>
</div>
</div>
<?php include('footer.php') ?>

<script>
    $('#example').DataTable();
</script>