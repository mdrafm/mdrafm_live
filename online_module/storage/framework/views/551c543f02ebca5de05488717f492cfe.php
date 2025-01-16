<?php if($subjects->isEmpty()): ?>
   <p>No Programs available for this module.</p>
<?php else: ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Sl No.</th>
            <th scope="col">Subject</th>
            <!-- <th scope="col">Type</th> -->
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <tr>
            <th scope="row"><?php echo e($loop->iteration); ?></th>
            <td><?php echo e($subject->subject_name); ?></td>
            <td><button class="btn btn-primary subject" data-subjectId="<?php echo e($subject->id); ?>">
                    Details
                </button></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
</table>

<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/partials/subject_list.blade.php ENDPATH**/ ?>