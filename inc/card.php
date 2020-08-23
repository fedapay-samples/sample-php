<div class="card h-100 product-card">
    <div class="text-content">
        <p style="text-align: center; margin-left:20px;margin-right:20px; margin-top:12px; text"><strong><?php echo $product["subject"] ?> 's Hoodie</strong></p>
    </div>
    <div class="card-image mx-auto">
        <a href="<?php echo $product["reference"] ?>">
            <img src="<?php echo $product["src"] ?>" class="rounded-25 mx-auto" style="max-width:100%; max-height:100%">
        </a>
    </div>
    <div class="card-footer mt-2 center-align">
        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#des-<?php echo $key ?>">Détails</button>
    </div>
</div>
