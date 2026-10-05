<?php

session_start();

require 'vendor/autoload.php';
include 'config.php';

    /**
     * Import du SDK FedaPay.
     */
    use FedaPay\Transaction;

// Importer le header.
include 'inc/header.php';

/**
 * Liste des produits.
 */
$products = [
    [
        'id' => 1,
        'name' => 'Ace D. Portgas',
        'price' => 10000,
        'image' => 'pictures/ace.jpg',
        'description' => 'Sweat à capuche pour homme du mangas One Piece représentant.'
    ],
    [
        'id' => 2,
        'name' => 'Méliodas',
        'price' => 29990,
        'image' => 'pictures/meliodas.jpg',
        'description' => 'Sweat à capuche pour homme du mangas Nanatsu No Tazai représentant.'
    ],
    [
        'id' => 3,
        'name' => 'Asta',
        'price' => 38700,
        'image' => 'pictures/asta.jpg',
        'description' => 'Sweat à capuche unisexe du mangas Black Clover représentant.'
    ],
    [
        'id' => 4,
        'name' => 'Juice WRLD',
        'price' => 15000,
        'image' => 'pictures/juice1.jpg',
        'description' => 'Sweat à capuche avec la cover du troisième album de l\'artiste.'
    ],
    [
        'id' => 5,
        'name' => '5 SOS',
        'price' => 22000,
        'image' => 'pictures/sos.jpg',
        'description' => 'Sweat à capuche unisexe portant l\'effigie du boys band.'
    ],
    [
        'id' => 6,
        'name' => 'Power',
        'price' => 37000,
        'image' => 'pictures/Power.jpg',
        'description' => 'Sweat à capuche unisexe portant la cover de la série télévisée.'
    ]
];


/**
 * Affichage du message flash.
 */
if (isset($_SESSION['flash_message'])) {

    echo '<div class="alert alert-info">'
        . htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8')
        . '</div>';

    unset($_SESSION['flash_message']);
}


/**
 * Traitement du formulaire de paiement.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**
     * Récupération des données.
     */
    $productId = isset($_POST['product_id'])
        ? (int) $_POST['product_id']
        : 0;

    $nom = isset($_POST['nom'])
        ? trim($_POST['nom'])
        : '';

    $prenom = isset($_POST['prenom'])
        ? trim($_POST['prenom'])
        : '';

    $email = isset($_POST['email'])
        ? trim($_POST['email'])
        : '';

    $numero = isset($_POST['numero'])
        ? trim($_POST['numero'])
        : '';


    /**
     * Recherche du produit.
     *
     * On ne fait pas confiance au prix envoyé par le navigateur.
     * Le prix officiel est récupéré depuis $products.
     */
    $product = null;

    foreach ($products as $item) {

        if ($item['id'] === $productId) {
            $product = $item;
            break;
        }
    }


    /**
     * Vérification que le produit existe.
     */
    if ($product === null) {

        $_SESSION['flash_message'] = 'Produit invalide.';

        header('Location: ./');
        exit;
    }


    /**
     * Validation du nom.
     */
    if ($nom === '') {

        $_SESSION['flash_message'] = 'Veuillez renseigner votre nom.';

        header('Location: ./');
        exit;
    }


    /**
     * Validation du prénom.
     */
    if ($prenom === '') {

        $_SESSION['flash_message'] = 'Veuillez renseigner votre prénom.';

        header('Location: ./');
        exit;
    }

    if (
        strpos($nom, '../') !== false ||
        strpos($nom, '..\\') !== false ||
        strpos($prenom, '../') !== false ||
        strpos($prenom, '..\\') !== false
    ) {

        $_SESSION['flash_message'] = 'Les informations personnelles saisies sont invalides.';

        header('Location: ./');
        exit;
    }


    /**
     * Validation du nom et du prénom.
     *
     * Autorise :
     * - lettres
     * - espaces
     * - apostrophes
     * - tirets
     * - caractères accentués
     */
    if (
        !preg_match("/^[\p{L}\s'\-]+$/u", $nom) ||
        !preg_match("/^[\p{L}\s'\-]+$/u", $prenom)
    ) {

        $_SESSION['flash_message'] = 'Le nom ou le prénom contient des caractères invalides.';

        header('Location: ./');
        exit;
    }


    /**
     * Validation de l'email.
     */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['flash_message'] = 'Adresse email invalide.';

        header('Location: ./');
        exit;
    }


    /**
     * Validation du numéro.
     *
     * On autorise les chiffres, espaces, +, parenthèses et tirets.
     */
    if (!preg_match('/^[0-9+\s()-]+$/', $numero)) {

        $_SESSION['flash_message'] = 'Numéro de téléphone invalide.';

        header('Location: ./');
        exit;
    }



    /**
     * URL de callback.
     */
    $callback_url = 'http://phpsample.fedapay.com/callback.php';


    try {

        /**
         * Création de la transaction.
         *
         * Le prix utilisé ici provient de $products.
         * Il ne provient PAS du champ hidden du formulaire.
         */
        $transaction = Transaction::create([
            'description' => "Achat de $product[name]",
            'amount' => (int) $product['price'],
            'currency' => ['iso' => 'XOF'],
            'callback_url' => $callback_url,
            'customer' => [
                'firstname' => $nom,
                'lastname' => $prenom,
                'email' => $email,
                'phone_number' => [
                    'number' => $numero,
                    'country' => 'bj'
                ]
            ]
        ]);

        $token = $transaction->generateToken();
        return header('Location: ' . $token->url);


    } catch (\FedaPay\Error\ApiConnectionError $e) {

        $_SESSION['flash_message'] =
            'Erreur de connexion à l\'API FedaPay : '
            . $e->getMessage();


    } catch (\FedaPay\Error\InvalidRequestError $e) {

        $_SESSION['flash_message'] =
            'Erreur de requête FedaPay : '
            . $e->getMessage();


    } catch (\FedaPay\Error\ApiError $e) {

        $_SESSION['flash_message'] =
            'Erreur API FedaPay : '
            . $e->getMessage();


    } catch (\Exception $e) {

        $_SESSION['flash_message'] =
            'Erreur inconnue : '
            . $e->getMessage();
    }

    header('Location: ./');
    exit;
}
?>


<div class="row">

    <?php foreach ($products as $product): ?>

        <!-- Produit -->

        <div class="col-md-4 mb-4">

            <div class="card">

                <img
                    src="<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
                    class="card-img-top"
                    alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                >

                <div class="card-body">

                    <h5 class="card-title">

                        <strong>
                            <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </strong>

                    </h5>


                    <p class="card-text">

                        Prix :
                        <?php echo number_format($product['price'], 0, ',', ' '); ?>
                        FCFA

                    </p>


                    <!-- Bouton détails -->

                    <button
                        class="btn btn-outline-info me-2"
                        data-bs-toggle="modal"
                        data-bs-target="#detailModal<?php echo $product['id']; ?>"
                    >
                        Détails
                    </button>


                    <!-- Bouton acheter -->

                    <button
                        class="btn btn-outline-success"
                        data-bs-toggle="modal"
                        data-bs-target="#payModal<?php echo $product['id']; ?>"
                    >
                        Acheter
                    </button>

                </div>

            </div>

        </div>


        <!--
            Modal Détails
        -->

        <div
            class="modal fade"
            id="detailModal<?php echo $product['id']; ?>"
            tabindex="-1"
            aria-hidden="true"
        >

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            Détails de l'article

                            <strong>
                                <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </strong>

                        </h5>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fermer"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <p>

                            <strong>Description :</strong>

                            <?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>

                        </p>


                        <p>

                            <strong>Prix :</strong>

                            <strong>

                                <?php
                                echo number_format(
                                    $product['price'],
                                    0,
                                    ',',
                                    ' '
                                );
                                ?>

                                FCFA

                            </strong>

                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!--
            Modal Paiement
        -->

        <div
            class="modal fade"
            id="payModal<?php echo $product['id']; ?>"
            tabindex="-1"
            aria-hidden="true"
        >

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h3 class="modal-title">

                            <strong>
                                Formulaire de paiement
                            </strong>

                        </h3>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fermer"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <form
                            action="index.php"
                            method="post"
                        >

                            <!--
                                ID du produit.
                                Le prix n'est volontairement PAS envoyé
                                comme donnée de confiance.
                            -->

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?php echo $product['id']; ?>"
                            >


                            <!-- Nom -->

                            <div class="mb-3">

                                <label for="nom<?php echo $product['id']; ?>">
                                    Nom
                                </label>

                                <input
                                    type="text"
                                    id="nom<?php echo $product['id']; ?>"
                                    name="nom"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            <!-- Prénom -->

                            <div class="mb-3">

                                <label for="prenom<?php echo $product['id']; ?>">
                                    Prénom
                                </label>

                                <input
                                    type="text"
                                    id="prenom<?php echo $product['id']; ?>"
                                    name="prenom"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            <!-- Email -->

                            <div class="mb-3">

                                <label for="email<?php echo $product['id']; ?>">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email<?php echo $product['id']; ?>"
                                    name="email"
                                    class="form-control"
                                    maxlength="150"
                                    required
                                >

                            </div>


                            <!-- Numéro -->

                            <div class="mb-3">

                                <label for="numero<?php echo $product['id']; ?>">
                                    Numéro
                                </label>

                                <input
                                    type="tel"
                                    id="numero<?php echo $product['id']; ?>"
                                    name="numero"
                                    class="form-control"
                                    maxlength="30"
                                    required
                                >

                            </div>


                            <!--
                                Prix affiché uniquement.
                                Il ne sert PAS à déterminer le montant
                                de la transaction côté serveur.
                            -->

                            <div class="mb-3">

                                <label>
                                    Montant
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?php
                                        echo number_format(
                                            $product['price'],
                                            0,
                                            ',',
                                            ' '
                                        );
                                    ?> FCFA"
                                    readonly
                                >

                            </div>


                            <!-- Bouton paiement -->

                            <button
                                type="submit"
                                class="btn btn-primary mt-3"
                            >

                                Payer

                                <?php
                                echo number_format(
                                    $product['price'],
                                    0,
                                    ',',
                                    ' '
                                );
                                ?>

                                FCFA

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

</div>


<!-- Importer le footer -->

<?php include 'inc/footer.php'; ?>