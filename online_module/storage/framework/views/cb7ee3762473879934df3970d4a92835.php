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
    <main class="form-signin"  >
        <form action="<?php echo e(route('processRegister')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <h1 class="h3 mb-3 fw-normal">Please sign up</h1>
            <div class="form-floating m-2">
                <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Your Name">
                <label for="name">Name</label>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-floating m-2">
                <input type="text" class="form-control" name="phone" value="<?php echo e(old('phone')); ?>" id="phone" placeholder="Enter Your Phone Number">
                <label for="phone">Phone</label>
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-floating m-2">
                <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="name@example.com">
                <label for="email">Email</label>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-floating m-2">
                <input type="text" class="form-control" value="<?php echo e(old('hrmsId')); ?>" name="hrmsId" placeholder="Hrmas Id">
                <label for="hrmsId">HRMS ID</label>
                <?php $__errorArgs = ['hrmsId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div id="otpSection" style="display:none;">
                <div class="form-floating m-2">
                    <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
                    <label for="otp">OTP</label>
                    <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="text-success"> Resend otp after <span id="timer"></span></div>
                <div> <a href="#" class="btn btn-warning" style="display:none" id="resend_otp"
                    onclick="generateOtp()">Resend OTP</a> </div>
            </div>

            <p id="alreadyAccount">Already have an account? <a href="<?php echo e(route('login')); ?>">click here to login</a> </p>
            <button type="button" id="sendOtpBtn" class="btn btn-warning w-100">Register</button>
            <button class="w-100 btn btn-lg btn-primary" style="display: none" type="submit" id="registerBtn">Verify Otp</button>
            
        </form>
    </main>
</div>

</body>
<script>
    document.getElementById('sendOtpBtn').addEventListener('click', function () {
        const phone = document.getElementById('phone').value;
        if (!phone) {
            alert('Please enter a phone number.');
            return;
        }

        fetch("<?php echo e(route('sendOTP')); ?>", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ phone: phone })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(data.message);

                document.getElementById('alreadyAccount').style.display = 'none';
                document.getElementById('otpSection').style.display = 'block';
                document.getElementById('sendOtpBtn').style.display = 'none';
                document.getElementById('registerBtn').style.display = 'block';
                timer(120);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('timer').innerHTML = m + ':' + s;
        remaining -= 1;

        if (remaining >= 0 ) {
            setTimeout(function() {
                timer(remaining);
            }, 1000);
            return;
        }

        if (!timerOn) {
            // Do validate stuff here
            return;
        }

        // Do timeout stuff here
        $('#resend_otp').show();
        otp = '';
        console.log('expire_otp - ', otp);
    }

</script>

</html>
<?php /**PATH /var/www/html/mdrafm/online_module/resources/views/register.blade.php ENDPATH**/ ?>