<?php
/**
 * Copyright 07.04.2016 Victoria Speckmann-Bresges
 */
$feefoLinks = new \Trifledev\Feefo\Api\FeefoLinks($domain);

?>

<div class="container">
    <div class="row">
        <h3>Feefo Link Integration Examples</h3>
        <p>See all available logos here <a href="http://www.feefo.com/feefo/selectlogotemplate.jsp">http://www.feefo.com/feefo/selectlogotemplate.jsp</a></p>
        <div class="col-md-9">
            <div class="position-choice">
                <h4>General Supplier Reviews</h4>
                <?php
                echo $feefoLinks->getDisplayContainer();
                ?>
            </div>
            <div>
                <h4>Product Specific Reviews</h4>
                <?php
                echo $feefoLinks->getProductLink('133');
                ?>
            </div>
            <div>
                <h4>Different Logos For Product Specific Reviews</h4>
                <?php
                echo $feefoLinks->getProductLink('133',600,400,'product-stars-white-290x230_en.png');
                echo $feefoLinks->getProductLink('133',600,400,'combined-stars-grey-270x62_en.png');
                echo $feefoLinks->getProductLink('133',600,400,'service-stars-white-391x80_en.png');
                ?>
            </div>
        </div>
    </div>
</div>
