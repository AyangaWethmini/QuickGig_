<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/contactUs.css">


<div class="contact-us">
    <h1>Contact Us</h1>
    <p>If you have any questions or feedback, feel free to reach out!</p>
    
    <form action="<?=ROOT?>/home/sendEmail" method="POST">
        <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        </div>
        
        <button type="submit" class="btn-accent" >Send Message</button>


        <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>

        <!-- <script>
            function sendEmail(event) {
            event.preventDefault(); // Prevent form submission

            const form = event.target.closest('form');
            const formData = new FormData(form);

            fetch('<?=ROOT?>/home/sendEmail', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Display server response
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send email.');
            });
            }
        </script> -->
    </form>

</div>