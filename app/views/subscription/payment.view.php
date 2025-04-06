<?php require_once 'views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Subscribe to <?php echo htmlspecialchars($plan['name']); ?></h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>Plan Details</h4>
                        <p>
                            <strong>Price:</strong> $<?php echo number_format($plan['amount'], 2); ?> / <?php echo $plan['interval']; ?><br>
                            <strong>Description:</strong> <?php echo htmlspecialchars($plan['description']); ?>
                        </p>
                    </div>
                    
                    <form id="payment-form">
                        <input type="hidden" id="price-id" value="<?php echo $plan['stripe_price_id']; ?>">
                        
                        <div class="mb-3">
                            <label for="card-element" class="form-label">Credit or debit card</label>
                            <div id="card-element" class="form-control p-3">
                                <!-- Stripe Card Element will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                        </div>
                        
                        <button type="submit" id="submit-button" class="btn btn-primary btn-lg w-100">
                            Subscribe Now
                        </button>
                    </form>
                    
                    <div class="mt-3">
                        <p class="text-muted">
                            <small>Your payment information is secured by Stripe. We do not store your card details.</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    // Initialize Stripe with your publishable key
    const stripe = Stripe('<?php echo $config["publishable_key"]; ?>');
    const elements = stripe.elements();
    
    // Create an instance of the card Element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
            },
        },
    });
    
    // Mount the card Element to the DOM
    cardElement.mount('#card-element');
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const priceId = document.getElementById('price-id').value;
    
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        // Disable the submit button to prevent multiple clicks
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';
        
        // Create payment method using the card element
        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });
        
        if (error) {
            // Show error to your customer
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            submitButton.disabled = false;
            submitButton.textContent = 'Subscribe Now';
        } else {
            // Send the payment method ID to your server
            fetch('/subscription/process-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                    price_id: priceId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.requires_action) {
                    // Use Stripe.js to handle required card action
                    stripe.confirmCardPayment(data.client_secret).then(result => {
                        if (result.error) {
                            // Show error to your customer
                            const errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                            submitButton.disabled = false;
                            submitButton.textContent = 'Subscribe Now';
                        } else {
                            // The payment has been processed!
                            window.location.href = '/subscription/success?session_id=' + data.subscription_id;
                        }
                    });
                } else if (data.error) {
                    // Show error to your customer
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = data.error;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Subscribe Now';
                } else {
                    // Success, redirect to success page
                    window.location.href = '/subscription/success?session_id=' + data.subscription_id;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = 'An unexpected error occurred. Please try again.';
                submitButton.disabled = false;
                submitButton.textContent = 'Subscribe Now';
            });
        }
    });
</script>

<?php require_once 'views/partials/footer.php'; ?>