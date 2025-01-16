<form action="<?php echo e(route('dynamic.redirect')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="<?php echo e($type); ?>">
    <input type="hidden" name="id" value="<?php echo e($id); ?>">
    <button type="submit" class="btn btn-primary">
        <?php echo e($slot ?? 'Go to ' . ucfirst($type)); ?>

    </button>
</form>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/components/redirect-form.blade.php ENDPATH**/ ?>