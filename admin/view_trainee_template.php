<table class=" term table" id="tableid">
    <thead class="" style="background: #315682;color:#fff;font-size: 11px;">
        <th>Sl No</th>
        <th>Name</th>
        <th>HRMS Id</th>
        <th>Designation</th>
        <th>Place of Posting</th>
        <th>Email</th>
        <th style="text-align:center;">Phone</th>
        <th style="text-align:center;width: 8rem;">Action</th>
    </thead>
    <tbody>
        <?php
       
        $count = 0;

        foreach ($res as $row) {
            //print_r($row);
            $count++
        ?>
            <tr>

                <td><?php echo $count; ?></td>
              
                <td > <?php echo $row['name']  ?></td>
                <td > <?php echo $row['hrms_id']  ?></td>
                <td > <?php echo $row['designation']  ?></td>
                <td > <?php echo $row['office_name']  ?></td>
                <td > <?php echo $row['email']  ?></td>
                <td style="text-align:center;"><?php echo $row['phone']; ?> </td>
              

                <td style="text-align:center;">
                  
                            <a href="#" data-id="<?php echo $row['trainee_detail_id']; ?>" class="editBtn" style="color:#4164b3 ;">
                              <i class="far fa-edit " style="font-size:1.5rem;"></i>
                            </a>
                            
                    &nbsp;
                   
                    <!--Tranee Detail Modal -->
                   
                    
                </td>
            </tr>
        <?php
        }


        ?>

    </tbody>
</table>