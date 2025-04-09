<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<style>
    .status-container {
        max-width: 500px;
        margin: 100px auto;
        padding: 40px;
        text-align: center;
        background: #ffe6e6;
        border: 2px solid #ffcccc;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .status-container h2 {
        color: #dc3545;
        font-size: 2rem;
        margin-bottom: 20px;
    }
    .status-container p {
        color: #444;
        font-size: 1.1rem;
    }
    .status-container a {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 30px;
        background-color: #dc3545;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: background 0.3s;
    }
    .status-container a:hover {
        background-color: #c82333;
    }
</style>

<div class="status-container">
    <h2>❌ Payment Failed</h2>
    <p>Oops! Something went wrong with your payment. Please try again.</p>
    <a href="<?php echo ROOT; ?>/subscribe">Retry Payment</a>
</div>
