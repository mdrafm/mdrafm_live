<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
<?php if(Auth::user()->role == 'admin'): ?>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Question Bank</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?php echo e(route('manage.question')); ?>">
          <i class="bi bi-circle"></i><span>Manage</span>
        </a>
      </li>
      

    </ul>
  </li>
<?php endif; ?>
<?php if(Auth::user()->role == 'cd'): ?>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Programs</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="<?php echo e(route('cd.manageProgram')); ?>">
              <i class="bi bi-circle"></i><span>Add Program</span>
            </a>
        </li>
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>Approve Program</span>
            </a>
        </li>
      

    </ul>
  </li>
<?php endif; ?>

<?php if(Auth::user()->role == 'deo'): ?>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Programs</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?php echo e(route('deo.manageProgram')); ?>">
          <i class="bi bi-circle"></i><span>Add Program</span>
        </a>
      </li>

    </ul>
  </li>
<?php endif; ?>

<?php if(Auth::user()->role == 'trainee'): ?>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Course Offered</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?php echo e(route('trainee.ModuleWise')); ?>">
          <i class="bi bi-circle"></i><span>Module Wise</span>
        </a>
      </li>
      


    </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="<?php echo e(route('get.enrolledPrograms')); ?>">
      <i class="bi bi-file-earmark"></i>
      <span>Ongoing Programs</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="<?php echo e(route('get.allFeedback')); ?>">
      <i class="bi bi-file-earmark"></i>
      <span>Program Feedback</span>
    </a>
  </li>
<?php endif; ?>
      <!-- End Components Nav -->

     <!-- End Blank Page Nav -->

    </ul>

  </aside>
<?php /**PATH C:\xampp\htdocs\online_module\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>