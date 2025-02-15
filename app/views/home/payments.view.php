<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div>
  <form id="payment-form">
    <div id="card-element">
      <!-- Stripe Card Element will be inserted here -->
    </div>
    <button id="submit-button">Pay</button>
    <div id="payment-message" class="hidden"></div>
  </form>
</div>

  <script>
    // Initialize Stripe with your publishable key
    const stripe = Stripe('pk_test_51QsoGLFq0GU0Vr5TlrQlsKQR7BGw4Ander7Yu8s1koQDaQR0qFY9c7QXJMKkpKNoGLuST4xEIj8S1tdvUA0azg0Y00ucoa4ozu');

    // Create a Stripe card element
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const { paymentIntent, error } = await stripe.confirmCardPayment(
        '{{CLIENT_SECRET}}', // Replace with the client secret from your PHP backend
        {
          payment_method: {
            card: cardElement,
          },
        }
      );

      if (error) {
        document.getElementById('payment-message').textContent = error.message;
      } else {
        document.getElementById('payment-message').textContent = 'Payment succeeded!';
      }
    });
  </script>
  <script src="https://js.stripe.com/v3/"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>