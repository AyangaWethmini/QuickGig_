<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<style>
    .status-container {
        max-width: 500px;
        margin: 100px auto;
        padding: 40px;
        text-align: center;
        background: #e6f9f0;
        border: 2px solid #c0f2dc;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .status-container h2 {
        color: #28a745;
        font-size: 2rem;
        margin-bottom: 20px;
    }
    .status-container p {
        color: #333;
        font-size: 1.1rem;
    }
    .status-container a {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 30px;
        background-color: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: background 0.3s;
    }
    .status-container a:hover {
        background-color: #218838;
    }
</style>

<div class="status-container">
    <h2>✅ Payment Successful!</h2>
    <p>Your subscription has been activated. Thank you!</p>
    <a href="<?php echo ROOT; ?>/home">Go to Home</a>
</div>
