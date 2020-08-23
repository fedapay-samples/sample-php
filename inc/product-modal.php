<div class="modal fade" id="des-<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="juice1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><strong><?php echo $product["subject"] ?>'s hoodie</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-image">
                            <img src="<?php echo $product["src"] ?>" alt="" height="250" width="250" class="rounded-25">
                        </div>
                    </div>
                    <div class="col-md-6" text-center>
                        <h4><strong>Description</strong></h4>
                        <p><?php echo $product["description"] ?> <strong><?php echo $product["subject"] ?></strong>.
                        </p>
                        <p>Disponible en <?php echo $product["modele"] ?> pour les tailles <?php echo $product["tailles"] ?> </p>

                        <p>Prix: <strong><?php echo $product["price"] ?> FCFA</strong></p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <a href="#trans-<?php echo $key ?>" data-toggle="modal" data-dismiss="modal"> <button type="button" class="btn btn-primary">Acheter</button></a>
            </div>
        </div>
    </div>
</div>
