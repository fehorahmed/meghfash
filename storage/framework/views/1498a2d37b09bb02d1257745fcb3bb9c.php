
    <div style="max-width: 670px;margin: auto;border: 1px solid #98a4b8;margin-bottom: 25px;">
        <p style="text-align: center;margin-bottom: 15px;padding: 5px;">
            <img src="<?php echo e(asset(general()->logo())); ?>" style="max-width: 100%;"><br>
            <span style="font-size: 28px;display: block;line-height: 30px;"><?php echo e(general()->title); ?></span>
            <span>Mobile: <?php echo e(general()->mobile); ?> Email: <?php echo e(general()->email); ?></span> <br>
            <span><?php echo e(general()->address_one); ?></span>
        </p>
        <h4 style="text-align: center;font-weight: bold;font-family: sans-serif;">Order No: <?php echo e($order->invoice); ?></h4>
        <div style="padding: 5px;">
            <table class="table">
                <tr>
                    <th>Name:</th>
                    <th><?php echo e($order->name); ?></th>
                </tr>
                <tr>
                    <th>Mobile:</th>
                    <th><?php echo e($order->mobile); ?></th>
                </tr>
                <tr>
                    <th>Address</th>
                    <th><?php echo e($order->fullAddress()); ?></th>
                </tr>
            </table>
            <br>
            
            <p style="text-align:center;">Thank you for shopping</p>
            <br>
        </div>
    </div>
<?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/orders/includes/slipView.blade.php ENDPATH**/ ?>