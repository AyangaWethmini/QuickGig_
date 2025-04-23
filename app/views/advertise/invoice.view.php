<!-- views/advertisement/invoice.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Ad Payment Confirmation</title>
</head>
<body>
    <div style="text-align:center;">
        <h2><?= $success ? "🎉 Payment Successful" : "❌ Payment Failed" ?></h2>
        <p><?= htmlspecialchars($message) ?></p>

        <?php if ($success && isset($invoiceData)) : ?>
            <h3>Advertisement Details</h3>
            <p><strong>Title:</strong> <?= htmlspecialchars($invoiceData['advertisement']['adTitle']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($invoiceData['advertisement']['adDescription']) ?></p>
            <p><strong>Link:</strong> <a href="<?= htmlspecialchars($invoiceData['advertisement']['link']) ?>" target="_blank"><?= htmlspecialchars($invoiceData['advertisement']['link']) ?></a></p>
            <p><strong>Payment:</strong> LKR <?= number_format($invoiceData['amount'], 2) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
