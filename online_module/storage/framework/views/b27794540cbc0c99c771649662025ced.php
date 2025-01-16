<?php $__env->startSection('content'); ?>

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Manage Program</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
      <div class="container">
          <!-- End Logo -->
             <div class="btn-modal">
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                 Add New Programe
               </button>
             </div>

             <div class="uaser_list">
               <table class="table table-striped" id="users_tbl">
                 <thead>

                   <tr>
                     <th scope="col">SL No</th>
                     <th scope="col">Module</th>
                     <th scope="col">Course</th>
                     <th scope="col">Program</th>
                     <th scope="col">Start Date</th>
                     <th scope="col">End Date</th>
                     <th scope="col">Enroll Start Date</th>
                     <th scope="col">Enroll End Date</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody>
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($program->id); ?></td>
                        <td><?php echo e($program->module->module_name ?? 'N/A'); ?></td>
                        <td><?php echo e($program->course->course_name ?? 'N/A'); ?></td>
                        <td><?php echo e($program->program->program_name ?? 'N/A'); ?></td>
                        <td><?php echo e($program->start_date); ?></td>
                        <td><?php echo e($program->end_date); ?></td>
                        <td><?php echo e($program->en_start_date); ?></td>
                        <td><?php echo e($program->en_end_date); ?></td>
                        <td>
                            <?php if($program->status == 1): ?>
                                Active
                            <?php elseif($program->status == 2): ?>
                                Inactive
                            <?php elseif($program->status == 3): ?>
                                Finished
                            <?php else: ?>
                                Unknown
                            <?php endif; ?>
                        </td>
                        <!-- Actions -->
                        <td>
                            <?php if($program->status == 2): ?>
                               Pending at CourseCo-ordinating Officer
                            <?php endif; ?>
                            <?php if($program->status == 3): ?>
                              Approved
                         <?php endif; ?>

                            <!-- Send to Approve Button (if status is 1) -->
                            <?php if($program->status == 1): ?>
                             <!-- Edit Button -->
                             

                             <!-- Delete Button -->
                             <form action="<?php echo e(route('programs.destroy', $program->id)); ?>" method="POST" style="display:inline;">
                                 <?php echo csrf_field(); ?>
                                 <?php echo method_field('DELETE'); ?>
                                 
                             </form>
                                <form action="<?php echo e(route('programs.approve', $program->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-warning">Send to Approve</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </tbody>
               </table>
             </div>

             <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="motal_title" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h1 class="modal-title fs-5" id="motal_title"> Add New Program </h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                     <form class="row g-3 " id="newProgramfrm" action="#" method="post">
                       <input type="hidden" name="member_id" id="member_id" >

                       <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Select Module</label>
                          <div class="col-sm-8">
                              <select class="form-select" name="module_id" id="module" aria-label="Default select example">
                                  <option selected value="0">Select Module</option>
                                  <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($module->id); ?>"><?php echo e($module->module_name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </select>
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Select Course</label>
                          <div class="col-sm-8">
                              <select class="form-select" name="course_id" id="course" aria-label="Default select example">
                                  <option selected value="0"></option>

                                </select>
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Select Program</label>
                          <div class="col-sm-8">
                              <select class="form-select" name="program_id" id="program" aria-label="Default select example">
                                  <option selected value="0"></option>

                                </select>
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Program Start Date</label>
                          <div class="col-sm-8">
                              <input type="date" name="start_date" class="form-control" id="start_date" >
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Program End Date</label>
                          <div class="col-sm-8">
                              <input type="date" name="end_date" class="form-control" id="end_date" >
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Enrollment Start Date</label>
                          <div class="col-sm-8">
                              <input type="date" name="en_start_date" class="form-control" id="en_start_date" >
                          </div>
                        </div>
                        <div class="row mb-3 mt-2">
                          <label class="col-sm-4 col-form-label">Enrollment End Date</label>
                          <div class="col-sm-8">
                              <input type="date" name="en_end_date" class="form-control" id="en_end_date" >
                          </div>
                        </div>

                     </form>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" id="add-btn" >Save</button>
                   </div>
                 </div>
               </div>
             </div>
         </div>
  </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    $('#module').change(function(){
      const moduleId = $(this).val();

      $.ajax({
          url: "<?php echo e(route('deo.allCourse')); ?>", // Your route to fetch courses
          type: 'POST',
          dataType: 'json',
          data: {
              moduleId: moduleId,

          },
          success: function(data) {
              console.log(data)
              $('#course').empty();
              $('#course').append('<option value="0">Select Course</option>');
              $.each(data, function(key, value) {
                  $('#course').append('<option value="' + value.id + '">' + value.course_name + '</option>');
              });

          },
          error: function(xhr) {
              console.error(xhr);
              $('#course').html('<p>An error occurred while fetching program.</p>');
          }
      });
    })

    $('#course').change(function(){
      const courseId = $(this).val();

      $.ajax({
          url: "<?php echo e(route('deo.allPrograms')); ?>", // Your route to fetch courses
          type: 'POST',
          dataType: 'json',
          data: {
              courseId: courseId,

          },
          success: function(data) {
              console.log(data)
              $('#program').empty();
              $('#program').append('<option value="0">Select Program</option>');
              $.each(data, function(key, value) {
                  $('#program').append('<option value="' + value.id + '">' + value.program_name + '</option>');
              });

          },
          error: function(xhr) {
              console.error(xhr);
              $('#program').html('<p>An error occurred while fetching program.</p>');
          }
      });
    })

    $('#start_date').change(function(){
       const programId = $('#program').val();
       const start_date = $(this).val();

       if (programId === "0" || !start_date) {
          alert("Please select a valid program and start date.");
          return;
      }

       $.ajax({
          url: "<?php echo e(route('deo.allDates')); ?>", // Your route to fetch courses
          type: 'POST',
          dataType: 'json',
          data: {
              programId: programId,
              start_date:start_date

          },
          success: function(data) {
              console.log(data)
              if (data.error) {
                  alert(data.error);
              } else {
                  $('#end_date').val(data.end_date);
                  $('#en_start_date').val(data.enroll_start_date);
                  $('#en_end_date').val(data.enroll_end_date);
              }

          },
          error: function(xhr) {
              console.error(xhr);
              $('#program').html('<p>An error occurred while fetching program.</p>');
          }
      });

    })

    $('#add-btn').click(function(){
      let form = $('#newProgramfrm')[0];
      let formdata = new FormData(form);

      $.ajax({
          url:'<?php echo e(route("deo.saveProgram")); ?>',
          type:'post',
          processData:false,
          contentType:false,
          data:formdata,
          beforeSend: function(){
            $('#add-dtn').prop('disabled',true);
            $('#add-dtn').html('Please Wait <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
          },
          success: function(response){

          }

      });
    });
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/deo/manageProgram.blade.php ENDPATH**/ ?>