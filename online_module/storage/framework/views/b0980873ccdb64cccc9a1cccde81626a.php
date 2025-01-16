<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">

    <link href="resources/css/bootstrap-icons.css" rel="stylesheet">

    <link href="resources/css/templatemo-topic-listing.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
    <?php endif; ?>

    <style>
        .form-signin{
            width: 33%;
            margin: 0 auto;
            margin-top: 10%;
            border: 1px solid black;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body class=" text-center">
<div class="container">
     <?php if(Session::has('success')): ?>
         <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
     <?php endif; ?>
    <main class="form-signin"  >
        <form action="<?php echo e(route('authenticate')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating m-2">
                <input type="text" value="<?php echo e(old('phone')); ?>" class="form-control" <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> id="phone" name="phone" placeholder="Phone Number">
                <label for="phone">Phone Number</label>
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="invalid-feedback" ><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-floating m-2">
                <input type="password" value="<?php echo e(old('password')); ?>" class="form-control" <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="invalid-feedback" ><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <p>Don't have an account?<a href="<?php echo e(route('register')); ?>">click here to register</a> </p>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            
            
        </form>
    </main>
</div>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/login.blade.php ENDPATH**/ ?>