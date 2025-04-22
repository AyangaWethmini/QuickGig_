<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<style>
  
  .error-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 80vh;
    text-align: center;
    padding: 2rem;
  }

  .error-code {
    font-size: 6rem;
    font-weight: bold;
    color: var(--brand-pri-dark);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .error-message {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .back-button {
    padding: 0.7rem 1.5rem;
    background-color: var(--brand-primary);
    color: #fff;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: background-color 0.2s ease-in-out;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .back-button:hover {
    background-color: #0056b3;
  }
</style>

<div class="error-container">
  <div class="error-code">404</div>
  <div class="error-message">Oops! The page you're looking for doesn't exist.</div>
  <a href="<?=ROOT?>/home" class="back-button">Go Back Home</a>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
