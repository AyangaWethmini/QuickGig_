<?php

require_once '../vendor/autoload.php';

class StripeService {
    private $stripe;
    private $config;

    public function __construct() {
        $this->config = require '../app/core/stripe-config.php';
        \Stripe\Stripe::setApiKey($this->config['secret_key']);
        $this->stripe = new \Stripe\StripeClient($this->config['secret_key']);
    }

    public function createCustomer($email, $name = null, $metadata = []) {
        try {
            return $this->stripe->customers->create([
                'email' => $email,
                'name' => $name,
                'metadata' => $metadata
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createSubscription($customerId, $priceId, $metadata = []) {
        try {
            return $this->stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'metadata' => $metadata,
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent']
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createCheckoutSession($customerId, $priceId, $successUrl, $cancelUrl, $metadata = []) {
        try {
            return $this->stripe->checkout->sessions->create([
                'customer' => $customerId,
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $priceId,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => $metadata
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function cancelSubscription($subscriptionId) {
        try {
            return $this->stripe->subscriptions->cancel($subscriptionId);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getSubscription($subscriptionId) {
        try {
            return $this->stripe->subscriptions->retrieve($subscriptionId);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log('Stripe API Error: ' . $e->getMessage());
            return null;
        }
    }
}