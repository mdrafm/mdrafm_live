  
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
                 <table class="table table-striped" id="users_tbl" style="font-size: 13px" >
                   <thead>

                     <tr>
                       <th scope="col">SL No</th>
                       <th scope="col">Module</th>
                       <th scope="col">Course</th>

                       <th scope="col">Start Date</th>
                       <th scope="col">End Date</th>
                       <th scope="col">Enroll Start Date</th>
                       <th scope="col">Enroll End Date</th>
                       
                       <th scope="col">Panel Discussion Date</th>
                       <th scope="col">Exam Date</th>
                       <th scope="col">Action</th>
                     </tr>
                   </thead>
                   <tbody>
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($program->id); ?></td>
                        <td><?php echo e($program->module->module_name ?? 'N/A'); ?></td>
                        <td><?php echo e($program->course->course_name ?? 'N/A'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->start_date)->format('d-m-y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->end_date)->format('d-m-y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->en_start_date)->format('d-m-y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->en_end_date)->format('d-m-y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->pd_date)->format('d-m-y h:i A')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->exam_date)->format('d-m-y h:i A')); ?></td>
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

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </tbody>
                 </table>
               </div>

               <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="motal_title" aria-hidden="true">
                 <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h1 class="modal-title fs-5" id="motal_title"> </h1>
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
                            <label class="col-sm-4 col-form-label">Start Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="start_date" class="form-control" id="start_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="end_date" class="form-control" id="end_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">Enroll Start Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="en_start_date" class="form-control" id="en_start_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">Enroll End Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="en_end_date" class="form-control" id="en_end_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">VC-1 Date</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" name="vc1_date" class="form-control" id="vc1_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">VC-2 Date</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" name="vc2_date" class="form-control" id="vc2_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">Panel Discussion Date</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" name="pd_date" class="form-control" id="pd_date" >
                            </div>
                          </div>
                          <div class="row mb-3 mt-2">
                            <label class="col-sm-4 col-form-label">Exam Date</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" name="exam_date" class="form-control" id="exam_date" >
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
            url: "<?php echo e(route('cd.allCourse')); ?>", // Your route to fetch courses
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

      

      $('#start_date').change(function(){
         const courseId = $('#course').val();
         const start_date = $(this).val();

         if (courseId === "0" || !start_date) {
            alert("Please select a valid program and start date.");
            return;
        }

         $.ajax({
            url: "<?php echo e(route('cd.allDates')); ?>", // Your route to fetch courses
            type: 'POST',
            dataType: 'json',
            data: {
                courseId: courseId,
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
            url:'<?php echo e(route("cd.saveProgram")); ?>',
            type:'post',
            processData:false,
            contentType:false,
            data:formdata,
            beforeSend: function(){
              $('#add-dtn').prop('disabled',true);
              $('#add-dtn').html('Please Wait <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
            },
            success: function(response){
                 if(response.success){
                    location.reload();
                 }
            }

        });
      });
  <?php $__env->stopSection(); ?>



<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/courseDirector/manageProgram.blade.php ENDPATH**/ ?>