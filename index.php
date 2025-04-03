<!--Page d'accueil affichant les produits et le formulaire de paiement--> 

<!--Importer le header de votre page -->

<?php include 'inc/header.php';?>


<!--gestion du callback avec le push de message de statut de la transaction -->

<?php
    session_start(); // Session pour gerer les requêtes POST et GET 

    if (isset($_SESSION['flash_message'])) {

        echo "<div class='alert alert-info'>" . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']); // Supprime le message après affichage
    }
?>

<!-- Code pour le traitement du formulaire de paiement -->

<?php

require 'vendor/autoload.php'; // Chargez FedaPay SDK

// Appeler votre fonction FedaPay

use FedaPay\Transaction;

use FedaPay\FedaPay;

// Configurer votre environnement FedaPay

FedaPay::setApiKey('sk_sandbox_XXXXXXXXXXX'); // Remplacez par votre clé secrète  API

FedaPay::setEnvironment('environment'); // Mettez votre environnement. Changez en 'live' pour production

 // Récupération des informations saisies par l'utilisateur après validation du formulaire de paiement

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $price = $_POST['price'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];

    $callback_url ="http://localhost:80/Dosbyl/callback.php"; //callback url de votre site 
    
    try {

        $transaction = Transaction::create([

            "description" => "Achat de $product[name] ",
            "amount" =>  $price,
            "currency" => ["iso" => "XOF"],
            "callback_url" => $callback_url,
            "customer" => [
                "firstname" =>  $prenom, // Utilisez $_POST pour récupérer les données du formulaire
                "lastname" => $nom,
                "email" => $email,
                "phone_number" => [
                    "number" => $numero,
                    "country" => "bj"
                ]
            ]
        ]);

        // Génération du token de la trasaction

        $token = $transaction->generateToken();
        
        header('Location: ' . $token->url); // Redirection  vers la page de paiement de la transaction

        exit();

        // Gestion des erreurs

    } catch (\FedaPay\Error\ApiConnectionError $e) {
        echo "Erreur de connexion à l'API : " . $e->getMessage();

    } catch (\FedaPay\Error\InvalidRequestError $e) {
        echo "Erreur de requête invalide : " . $e->getMessage();

    } catch (\FedaPay\Error\ApiError $e) {
        echo "Erreur API : " . $e->getMessage();

    } catch (Exception $e) {
        echo "Erreur inconnue : " . $e->getMessage();
    }    
}
?>
    <!-- Body de la page avec les codes html pour l'affichage des produits et du formulaire de paiement -->

    <div class="row">

        <?php

            // Tableau ou sont stockées les informations sur les produits.

            $products = [

                ['id' => 1, 'name' => 'Ace D. Portgas', 'price' => 19000, 'image' => 'pictures/ace.jpg', 'description' => 'Sweat à capuche pour homme du mangas One Piece représentant.'],

                ['id' => 2, 'name' => 'Méliodas', 'price' => 29990, 'image' => 'pictures/meliodas.jpg', 'description' => 'Sweat à capuche pour homme du mangas Nanatsu No Tazai représentant.'],
                        
                ['id' => 3, 'name' => 'Asta', 'price' => 38700, 'image' => 'pictures/asta.jpg', 'description' => 'Sweat à capuche unisexe du mangas Black Clover représentant.'],
                        
                ['id' => 4, 'name' => 'Juice WRLD', 'price' => 15000, 'image' => 'pictures/juice1.jpg', 'description' => 'Sweat à capuche avec la cover du troisième album de l\'artiste.'],
                        
                ['id' => 5, 'name' => '5 SOS', 'price' => 22000, 'image' => 'pictures/sos.jpg', 'description' => 'Sweat à capuche unisexe portant l\'effigie du boys band.'],
                        
                ['id' => 6, 'name' => 'Power', 'price' => 37000, 'image' => 'pictures/Power.jpg', 'description' => 'Sweat à capuche unisexe portant la cover de la série télévisée.']
                        
                        
            ];

            // Gestion de l'affichage des produits sur la page d'accueil

            foreach ($products as $product): 
        ?>
            <div class="col-md-4 mb-4">

                <div class="card">

                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">

                    <div class="card-body">

                        <h5 class="card-title"><strong><?php echo $product['name']; ?></strong></h5>

                        <p class="card-text">Prix: <?php echo $product['price']; ?>FCFA</p>

                        <button class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#detailModal<?php echo $product['id']; ?>">Détails</button>

                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#payModal<?php echo $product['id']; ?>">Acheter</button>

                    </div>
                </div>
            </div>
                    
            <!-- Modal Détails pour afficher les details des produits sous fome 
             de popup -->

            <div class="modal fade" id="detailModal<?php echo $product['id']; ?>" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">Détails de l'article <strong><?php echo $product['name']; ?></strong></h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                                    
                            <p><strong>Description: </strong> <?php echo $product['description']; ?></p>

                            <p><strong>Prix: </strong> <strong><?php echo $product['price']; ?> FCFA</strong></p>
                        </div>

                    </div>
                </div>
            </div>
                    
            <!-- Récupération de l'ID du produit depuis l'URL -->
                    
            <?php
            
                $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
            ?>

            <!-- Modal Paiement pour afficher le formulaire de paiement 
                sous forme de popup -->

            <div class="modal fade" id="payModal<?php echo $product['id']; ?>" tabindex="-1">

                <div class="modal-dialog">
                            
                    <div class="modal-content">

                        <div class="modal-header">
                            <h3 class="modal-title"><strong>Formulaire de paiement</strong></h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                                
                        <div class="modal-body">

                            <form action="index.php" method="post">

                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                                <div class="mb-3">
                                    <label>Nom</label>
                                    <input type="text" name="nom" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Prénom</label>
                                    <input type="text" name="prenom" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Numéro</label>
                                    <input type="text" name="numero" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Payer <?php echo $product['price']; ?> FCFA</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<!-- Importer le footer de la page -->

<?php include 'inc/footer.php'; ?>
