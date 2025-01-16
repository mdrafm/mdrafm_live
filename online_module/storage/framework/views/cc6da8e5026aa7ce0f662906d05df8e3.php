<?php if($programs && $programs->count() > 0): ?>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Program Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>VC Dates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <!-- Access program name safely -->
                    <td><?php echo e($program->program->program_name ?? 'N/A'); ?></td>

                    <!-- Access start and end dates safely -->
                    <td><?php echo e($program->start_date ?? 'N/A'); ?></td>
                    <td><?php echo e($program->end_date ?? 'N/A'); ?></td>

                    <!-- Display multiple VC Dates -->
                    <td>
                        <?php if($program->programVcDates && $program->programVcDates->count() > 0): ?>
                            <ul>
                                <?php $__currentLoopData = $program->programVcDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vcDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <?php echo e($vcDate->description ?? 'VC Date'); ?>:
                                        <?php echo e($vcDate->vc_date ?? 'N/A'); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            No VC Dates Available
                        <?php endif; ?>
                    </td>
                    <td>
                        <input class="btn btn-primary btn-sm detailSubject" data-programId = <?php echo e($program->id); ?> type="button" value="View Subjects">
                        <input class="btn btn-warning btn-sm requestToEnroll" data-programId = <?php echo e($program->id); ?> type="button" value="Request To Enroll">
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No programs available for the given ID.</p>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/partials/program-details.blade.php ENDPATH**/ ?>