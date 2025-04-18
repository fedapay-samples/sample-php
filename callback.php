<?php

session_start(); // Pour la gestion des cookies ou des sessions lors de l'execution des requêtes POST ou GET
 
require 'vendor/autoload.php';

// Faire appel au SDK de  Fedapay

use FedaPay\Transaction;

use FedaPay\FedaPay;

// Configurer votre environnement Fedapay 

FedaPay::setApiKey('sk_sandbox_XXXXXXXXXXXXXXXXXX'); // Remplacez par votre clé API

FedaPay::setEnvironment('environment'); //Mettez votre environnement. Changez en 'live' pour production

try {
    // Récupération de l'ID de la transaction depuis l'URL
    if (!isset($_GET['id'])) {

        throw new Exception("ID de transaction non fourni.");
    }

    $transaction = Transaction::retrieve($_GET['id']);

    $status = $transaction->status; // Statut du paiement

    // Enregistrer le message flash dans la session

    $_SESSION['flash_message'] = ($status === 'approved') 
    
        ? "Paiement réussi !" 
        : "Échec du paiement. Statut : $status";

} catch (Exception $e) {
    $_SESSION['flash_message'] = "Erreur lors du traitement du paiement : " . $e->getMessage();
}

// Rediriger vers index.php avec un message flash
header("Location: index.php");
exit();
?>
