<?php

require_once '../vendor/autoload.php'; // Load Stripe PHP library

class StripeService{
    private $stripe;
    private $config;

    public function __construct()
    {      
        $this->config = require '../app/core/stripe-config.php'; // Load Stripe configuration from config file
        \Stripe\Stripe::setApiKey($this->config['secret_key']); // Set the Stripe API key
        $this->stripe = new \Stripe\StripeClient($this->config['secret_key']);
    }
   
    public function createCustomer($email, $name = null, $metadata = [])
    {
        try {
            $customer = $this->stripe->customers->create([
                'email' => $email,
                'name' => $name,
                'metadata' => $metadata,
            ]);
            return $customer;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createSubscription($customerId, $priceId, $metadata = [])
    {
        try {
            $subscription = $this->stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [
                    ['price' => $priceId]
                ],
                'metadata' => $metadata,
            ]);
            return $subscription;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

   
    public function updateSubscription($subscriptionId, $priceId)
    {
        try {
            $subscription = $this->stripe->subscriptions->update($subscriptionId, [
                'items' => [
                    [
                        'id' => $subscriptionId,
                        'price' => $priceId]
                ]
            ]);
            return $subscription;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function cancelSubscription($subscriptionId)
    {
        try {
            $subscription = $this->stripe->subscriptions->cancel($subscriptionId, ['cancel_at_period_end' => true]);
            return $subscription;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getSubsbcription($subscriptionId)
    {
        try {
            $subscription = $this->stripe->subscriptions->retrieve($subscriptionId);
            return $subscription;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getPlans()
    {
        try {
            $plans = $this->stripe->prices->all(['active' => true]);
            return $plans;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createCheckoutSession($customerId, $priceId, $successUrl, $cancelUrl)
    {
        try {
            $session = $this->stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'customer' => $customerId,
                'line_items' => [[
                    'price' => $priceId,
                    'quantity' => 1,
                ]],
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);
            return $session;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error !ERRORS!
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createPaymentIntent($amount, $currency = 'lkr', $paymentMethodId, $customerId = null)
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method' => $paymentMethodId,
                'customer' => $customerId,
                'payment_method_types' => ['card'], // Only implemented for the card payment method
                'confirm' => true,
            ]);
            return $paymentIntent;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }
   


}