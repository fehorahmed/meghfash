<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 80mm; /* Set width for typical thermal printer paper */
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .receipt {
            margin: 10px;
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            font-size: 14px;
            line-height: 1.8;
        }
        .footer {
            font-size: 12px;
            margin-top: 20px;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
        }
        .line {
            border-top: 1px solid #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="receipt" style="border:1px solid black;">
        <!-- Header -->
        <div class="header">Store Name</div>
        <div>123 Main Street</div>
        <div>Phone: 555-1234</div>
        <div>Date: 2025-01-30</div>

        <div class="line"></div>

        <!-- Itemized list -->
        <div class="content">
            <div>Item 1 .................. $10.00</div>
            <div>Item 2 .................. $20.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
            <div>Item 3 .................. $15.00</div>
        </div>

        <div class="line"></div>

        <!-- Total -->
        <div class="total">Total: $45.00</div>

        <div class="footer">
            <div>Thank you for shopping!</div>
            <div>Visit again soon.</div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/posherbd/public_html/resources/views/admin/pos-orders/printInvoice.blade.php ENDPATH**/ ?>