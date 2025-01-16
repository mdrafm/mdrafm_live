<?php $__env->startSection('content'); ?>
    <div class="pagetitle">
        <h1>Enrolled Programs</h1>
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

            <div class="programs">


                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h2>Enrollement Program Details </h2> <!-- Accessing the module relationship -->
                        </div>
                        <div class="card-body">
                            <p><strong>Module Name:</strong> <?php echo e($program->module->module_name ?? 'N/A'); ?></p>
                            <p><strong>Course Name:</strong> <?php echo e($program->course->course_name ?? 'N/A'); ?></p>
                            <!-- Accessing the course relationship -->
                            <p><strong>Duration:</strong> <?php echo e($program->course->duration); ?> days</p>
                            <p><strong>Start Date:</strong> <?php echo e(\Carbon\Carbon::parse($program->start_date)->format('d-m-y')); ?></p>

                            <p><strong>End Date:</strong> <?php echo e(\Carbon\Carbon::parse($program->end_date)->format('d-m-y')); ?></p>
                            <p><strong>Enrollment Start Date:</strong> <?php echo e(\Carbon\Carbon::parse($program->en_start_date)->format('d-m-y')); ?></p>
                            <p><strong>Enrollment End Date:</strong> <?php echo e(\Carbon\Carbon::parse($program->en_end_date)->format('d-m-y')); ?></p>


                            <hp>VC Dates</hp>
                            <ul>
                                <?php $__currentLoopData = $program->programVcDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vcDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($vcDate->description ?? 'N/A'); ?> :- <?php echo e(\Carbon\Carbon::parse($vcDate->vc_date)->format('d-m-y') ?? 'N/A'); ?></li>
                                    <!-- Accessing programVcDates -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <p><strong>Panel Discussion Date & Time:</strong> <?php echo e(\Carbon\Carbon::parse($program->pd_date)->format('d-m-y h:i A')); ?></p>
                            <p><strong>Exam Date & Time:</strong> <?php echo e(\Carbon\Carbon::parse($program->exam_date)->format('d-m-y h:i A')); ?></p>
                            <div class="btn btn-info askRequestToenroll" data-program-id = <?php echo e($program->id); ?> > Request To Enroll </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>


        </div>


    </section>
      <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Enroll Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 programWrap">
                          <p>1. The training programme will start within 7 days of enrollment.</p>
                          <p>2. Participants must appear for all subject practice tests.</p>
                          <p>3. Trainees are required to attend at least one video conference during this training period.</p>
                          <p>4. The final examination will be held at MPRAFM on the specified date.</p>
                          <p>5. Before the final examination, trainees will participate in a panel discussion</p>
                          <p>6. After completing the examination and submitting feedback, participants can download their completion certificate</p>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
              </div>
            </div>
          </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    $('.askRequestToenroll').on('click', function () {
        const program_id = $(this).attr('data-program-id');
        $('.modal-footer').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning requestToEnroll" data-programId = ${program_id} data-bs-dismiss="modal">Enroll</button>
`)
      $('#enrollModal').modal('show')
    })

    $(document).on('click', '.requestToEnroll', function () {
        let programId = $(this).attr('data-programId');

        $.ajax({
            url: "<?php echo e(route('requestToEnroll')); ?>", // Your route to fetch courses
            type: 'POST',
            data: {
                program_id: programId
            },
            success: function(data) {
                console.log(data)

                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                   window.location.href = "<?php echo e(route('get.enrolledPrograms')); ?>"

                }
            },
            error: function(xhr) {
                console.error(xhr);
                $('#moduleWrap').html('<p>An error occurred while fetching courses.</p>');
            }
        });
    });
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/trainee/enrollment.blade.php ENDPATH**/ ?>