<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<style>
    .status-container {
        max-width: 500px;
        margin: 300px auto;
        padding: 40px;
        text-align: center;
        font-family: 'Inter', sans-serif;
        display : flex; 
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .status-container h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .status-container p {
        color: #333;
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .status-container a {
        display: inline-block;
        margin-top: 25px;
        padding: 12px 30px;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: transform 0.3s, background 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .status-container a:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        transform: translateY(-3px);
    }
</style>

<div class="status-container">
    <h2>Payment Successful! <i class="fa-regular fa-circle-check" style="color : green"></i></h2>
    <p>Your Ad has been submitted successfully. We will review it and get back to you shortly.</p>
    <a href="<?php echo ROOT; ?>/home" class="btn btn-accent">Go to Home</a>
</div>
