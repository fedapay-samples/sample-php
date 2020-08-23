<div class="modal fade" id="trans-<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="juice1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="payment.php">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><strong><?php echo $product["subject"] ?> 's <?php echo $product["color"] ?> Hoodie</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Doe">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">Prénoms</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="John">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="johndoe@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number">Téléphone </label>
                                <input type="tel" class="form-control" name="number" id="number" placeholder="66000001"">
                                <input type="hidden" name="amount" id="amount" value="<?php echo $product["price"] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type=" submit" name="submit" class="btn btn-primary">Payer <?php echo $product["price"] ?> FCFA</button>
                </div>
            </form>
        </div>
    </div>
</div>
