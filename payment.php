<?php
// Include header
include 'inc/header.php';
?>

<?php

require_once('vendor/autoload.php');

/**
 * Set Apikey and environment to connect to FedaPay
 */
FedaPay\FedaPay::setEnvironment($config["environment"]);
FedaPay\FedaPay::setApiKey($config["apikey"]);

// Process to payment
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
    $callback_url ="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $data = [
        'description' => 'Achat de Hoodie',
        'amount' => (int) $amount,
        'currency' => ['iso' => 'XOF'],
        'callback_url' => $callback_url,
        'customer' => $customer
    ];

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
    } catch (\FedaPay\Error\ApiConnection $e) {
        echo '<div class="alert alert-danger">';
        echo $e->getErrorMessage();

        if ($e->hasErrors()) {
            $errors = $e->getErrors();

            echo '<ul>';
            foreach ($errors as $key => $errorMessages) {
                foreach ($errorMessages as $message) {
                    echo "<li><strong>$key:</strong> $message</li>";
                }
            }
            echo '</ul>';
        }

        echo '</div>';
    }
}

// Payment callback
if (isset($_GET['id'])) {
    /**
     * Create a Transaction object with the data
     */
    $transaction = FedaPay\Transaction::retrieve($_GET['id']);

    if ($transaction->wasPaid()) {
        echo '<div class="alert alert-success">Transaction approuvée.</div>';
    } else {
        echo '<div class="alert alert-danger">Transaction échouée.</div>';
    }
}
?>

<?php include 'inc/footer.php'; ?>
