<?php
require_once '../app/core/config.php'; // Load configuration file

return [
    'secret_key'      => STRIPE_SECRET_KEY,
    'publishable_key' => STRIPE_PUBLISHABLE_KEY,
    //'webhook_secret'  => 'whsec_your_webhook_secret', 
    'currency'        => 'lkr'
];