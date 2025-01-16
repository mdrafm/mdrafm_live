<?php $__env->startSection('content'); ?>

  <div class="pagetitle">
    <h1>Feedback</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Feedback</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard min-vh-100 py-4">
      <div class="container">
          <!-- End Logo -->

             <div class="topic feedback">
               <table class="table table-striped" id="users_tbl">
                 <thead>

                   <tr>
                     <th scope="col">SL No</th>
                     
                     <th scope="col">Topic Name</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody style="font-size: 13px;">

                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td colspan="3" ><strong class="text-primary" >Session Name - <?php echo e($subject->subject_name); ?></strong></td>
                    </tr>

                        <?php $__currentLoopData = $subject->topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topics): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                        <td><?php echo e($loop->iteration); ?></td>

                        <td> <?php echo e($topics->topic_name); ?></td>
                        <td class="d-flex ">
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_<?php echo e($topics->id); ?>" value="5">
                                    <label class="form-check-label fdName" for="inlineRadio1">Excellent</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_<?php echo e($topics->id); ?>" value="4">
                                    <label class="form-check-label fdName" for="inlineRadio2"> Very
                                        Good</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_<?php echo e($topics->id); ?>" value="3">
                                    <label class="form-check-label fdName" for="inlineRadio3">Good</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_<?php echo e($topics->id); ?>" value="2">
                                    <label class="form-check-label fdName" for="inlineRadio3">Average</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input rd" type="radio" name="feedback_<?php echo e($topics->id); ?>" value="1">
                                    <label class="form-check-label fdName" for="inlineRadio4">Needs
                                        Improvement</label>
                                </div>
                            </div>


                        </td>
                    </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </tbody>
               </table>
             </div>

             <div class="feedback_message">
                <p class="text-dark fw-bold" >What is your suggestion for improving the training program ?
                    (Max 250 Words)</p>
                 <textarea class="form-control" id="class_feedback" name="class_feedback" rows="5"></textarea>
                <button type="submit" class="btn btn-primary mt-3">Submit Feedback</button>
             </div>

         </div>
  </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
$(document).ready(function(){
    CKEDITOR.replace('class_feedback');
})

<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/trainee/feedbackAllTopics.blade.php ENDPATH**/ ?>