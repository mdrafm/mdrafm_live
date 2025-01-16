<?php if($topics->isEmpty()): ?>
   <p>No Programs available for this module.</p>
<?php else: ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Sl No.</th>
            <th scope="col">Topic</th>
            <!-- <th scope="col">Type</th> -->
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <tr>
            <th scope="row"><?php echo e($loop->iteration); ?></th>
            <td><?php echo e($topic->topic_name); ?></td>
            <td></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
</table>

<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/partials/topic_list.blade.php ENDPATH**/ ?>