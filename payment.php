<?php

use FedaPay;

require_once('vendor/autoload.php');

if (isset($_POST['submit'])) {
    /**
     * get customer name from the form
     */
    $name = $_POST['name'];
    /**
     * get customer firstname from the form
     */
    $firstname = $_POST['firstname'];
    /**
     * get customer email from the form
     */
    $email = $_POST['email'];
    /**
     * get customer phone number from the form
     */
    $phone = $_POST['number'];
    /**
     * get the amount of transaction from the form
     */
    $amount = $_POST['amount'];

    /**
     * @var Array
     * Customer Data
     */
    $customer = [
        'firstname' => $firstname,
        'lastname' => $name,
        'email' => $email,
        'phone_number' => [
            'number'  => $phone,
            'country' => 'bj'
        ]
    ];

    /**
     * @var Object
     * Transaction Data
     */
    $data = [
        'description' => 'Achat de Hoodie',
        'amount' => (int) $amount,
        'currency' => ['iso' => 'XOF'],
        'callback_url' => 'http://localhost/php/php_sample/index.php',
        'customer' => $customer
    ];
    /**
     * Set Apikey and environment to connect to FedaPay
     */
    FedaPay\FedaPay::setEnvironment('sandbox');
    FedaPay\FedaPay::setApiKey("sk_sandbox_y4pIwtdYPSIR9c_Ar1K1NQBW");

    try {
        /**
         * Create a Transaction object with the data
         */
        $transaction = FedaPay\Transaction::create($data);

        /**
         * Generate a token
         */
        $token = $transaction->generateToken();

        /**
         * Redirect to the token url
         */
        return header('Location: ' . $token->url);
        exit;
    } catch (\Exception $e) {
        echo ($e);
    }
} else {
    echo ('data not received');
}
