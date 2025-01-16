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

             <div class="uaser_list">
               <table class="table table-striped" id="users_tbl">
                 <thead>

                   <tr>
                     <th scope="col">SL No</th>
                     <th scope="col">Course</th>
                     <th scope="col">Start Date</th>
                     <th scope="col">End Date</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody>

                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td>Training Program on Financial matters for different department officers</td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->start_date)->format('d-m-Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($program->end_date)->format('d-m-Y')); ?></td>
                        <td>
                            <?php if($program->status == 1): ?>
                                Pending At Course Co-ordinating Officer
                            <?php elseif($program->status == 2): ?>
                                Approved

                            <?php else: ?>
                                Unknown
                            <?php endif; ?>
                        </td>
                        <!-- Actions -->
                        <td>


                            <!-- Send to Approve Button (if status is 1) -->
                            <?php if($program->status == 2): ?>

                            <?php if($lastSegment=='enrolled-programs'): ?>
                                <?php if (isset($component)) { $__componentOriginald3e2bcc04d430775a97be9ac7389d525 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3e2bcc04d430775a97be9ac7389d525 = $attributes; } ?>
<?php $component = App\View\Components\RedirectForm::resolve(['id' => $program->id,'type' => 'class'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('redirect-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RedirectForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    Go To Class
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald3e2bcc04d430775a97be9ac7389d525)): ?>
<?php $attributes = $__attributesOriginald3e2bcc04d430775a97be9ac7389d525; ?>
<?php unset($__attributesOriginald3e2bcc04d430775a97be9ac7389d525); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald3e2bcc04d430775a97be9ac7389d525)): ?>
<?php $component = $__componentOriginald3e2bcc04d430775a97be9ac7389d525; ?>
<?php unset($__componentOriginald3e2bcc04d430775a97be9ac7389d525); ?>
<?php endif; ?>
                            <?php else: ?>
                            <form action="<?php echo e(route('get.allTopic')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="course_id" value="<?php echo e($program->program->course_id); ?>">

                                <button type="submit" class="btn btn-primary">
                                   Feedback
                                </button>
                            </form>

                            <?php endif; ?>




                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </tbody>
               </table>
             </div>


         </div>
  </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\online_module\resources\views/trainee/enrolled-programs.blade.php ENDPATH**/ ?>