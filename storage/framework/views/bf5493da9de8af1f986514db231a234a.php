<div class="dashboard_menu">
    <ul class="nav nav-tabs flex-column">
        <li class="nav-item">
        <a class="nav-link <?php echo e(Request::is('customer/dashboard')? 'active' : ''); ?>" href="<?php echo e(route('customer.dashboard')); ?>"><i class="ti-layout-grid2"></i>Dashboard</a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo e(Request::is('customer/orders*')? 'active' : ''); ?>"  href="<?php echo e(route('customer.myOrders')); ?>"><i class="ti-shopping-cart-full"></i>Orders</a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo e(Request::is('customer/profile*')? 'active' : ''); ?>"  href="<?php echo e(route('customer.profile')); ?>"><i class="ti-id-badge"></i>Profile</a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php echo e(Request::is('customer/change-password*')? 'active' : ''); ?>"  href="<?php echo e(route('customer.changePassword')); ?>"><i class="ti-key"></i>Change Password</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-lock"></i>Logout</a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
        </li>
    </ul>
</div><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/customer/includes/sidebar.blade.php ENDPATH**/ ?>