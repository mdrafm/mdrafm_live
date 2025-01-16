<?php $__env->startSection('content'); ?>

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Practice Test</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
        <div class="container">

            <table class="table table-hover">
                <thead>
                    <th>Sl No</th>
                    <th>Subject Name</th>
                    <th>Exam Status</th>
                    <th>Mark</th>
                    <th>Action</th>

                </thead>
                <tbody>

                    <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($test->subject->subject_name); ?></td>
                        <td>
                            <?php if(in_array($test->id, $examStatus)): ?>
                                <span class="text-success">Completed</span>
                            <?php else: ?>
                                <span class="text-danger">Not Completed</span>
                            <?php endif; ?>
                        </td>
                        <td>NA</td>
                        <td>
                            <?php if(!$allCompleted): ?>
                               <p class="text-danger">Complete All the Topics</p>
                               <?php elseif(in_array($test->id, $examStatus)): ?>
                               <button type="button" data-testid="<?php echo e($test->id); ?>" class="btn btn-success showResult">View Result</button>

                               <?php else: ?>
                               
                               <form action="<?php echo e(route('start.test')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="subject_id" value="<?php echo e($test->subject_id); ?>">
                                <input type="hidden" name="test_id" value="<?php echo e($test->id); ?>">
                                <input type="hidden" name="exam_duration" value="<?php echo e($test->exam_duration); ?>">
                                <input type="hidden" name="total_question" value="<?php echo e($test->total_question); ?>">
                                <input type="hidden" name="mark_per_right_ans" value="<?php echo e($test->mark_per_right_ans); ?>">
                                <input type="hidden" name="marks_per_wrong_answer" value="<?php echo e($test->marks_per_wrong_answer); ?>">
                                <button type="submit" class="btn btn-primary">Practice Text</button>


                              </form>


                            <?php endif; ?>



                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="queryModalLabel">Result Summary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
         </div>
  </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
$(document).ready(function () {
 $('.showResult').on('click', function () {
    var testId = $(this).data('testid');
    console.log(testId);
    $.ajax({
        type: 'POST',
        url: '<?php echo e(route('show.result')); ?>',
        data: {
            testId: testId
            },
            success: function (data) {
console.log(data);
                $('#resultModal').modal('show');
                var html = `
                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Exam Information</h5>
                        <p><strong>No. of Questions:</strong> ${data.total_questions}</p>
                        <p><strong>Marks per Correct Answer:</strong> ${data.eachWriteAns}</p>
                        <p><strong>Marks per Incorrect Answer:</strong>0</p>
                        <hr>
                        
                        <p><strong>Correct Answers:</strong> ${data.correct_answers}</p>
                        <p><strong>Incorrect Answers:</strong> ${data.incorrect_answers??'0'}</p>
                        <p><strong>Unattended Questions:</strong> ${data.unanswered_questions}</p>
                        <hr>
                        <p><strong>Total Marks Secured:</strong> ${data.final_answer}</p>
                    </div>
                </div>
            `;
                console.log(html);
                $('#resultModal .modal-body').html(html);
                }
    });
});


});
<?php $__env->stopSection(); ?>



<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/trainee/praticeTestList.blade.php ENDPATH**/ ?>