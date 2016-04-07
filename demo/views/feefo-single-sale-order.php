<?php
/**
 * Copyright 06.04.2016 Victoria Speckmann-Bresges
 */

use Trifledev\Feefo\Api\FeefoSendSingleSale;

$feefoInform = new FeefoSendSingleSale($domain);
$errors = [];
$success = '';
$isFormValid = false;
$hasConfirmed = false;

// set currency form select options
$formCurrencies = [
    'GBP'=>'&pound; Pound',
    'EUR'=>'&euro; Euro',
    'USD'=>'&#36; U.S. Dollar',
];
// init form values
$formKeys = array_fill_keys($feefoInform->getHelper()->getArrayKeys($feefoInform->getValidator()->getOrderParams()),'');
$formLabels = $feefoInform->getHelper()->getFormLabels($formKeys);

if(isset($_POST['send_feefo_data']) || isset($_POST['send_feefo_data_confirm'])) {

    $formKeys = array_merge($formKeys,$_POST);
    $isFormValid = $feefoInform->getValidator()->isOrderValid($formKeys);

    if(!$isFormValid) {

        $errors = $feefoInform->getValidator()->getValidationErrors();

    } else {

        $hasConfirmed = isset($_POST['send_feefo_data_confirm']) && $_POST['hasConfirmed'] === 'true';

        if ($hasConfirmed) {

            $result = $feefoInform->sendSingleOrder($_POST);

            if ($result) {
                $success = 'Order submitted successfully';
            }
        }
    }
}

?>
<div class="container">
    <h3>Single Manual Sale Inform <button id="fill-sample-data">Fill Sample Data</button></h3>

    <div class="row">
        <div class="col-md-9">
                <?php
                if($isFormValid && !$hasConfirmed) {
                    echo '<form class="form" name="single_feefo_order_confirm" method="POST" action="">';
                    echo '<div class="feefo-confirm">';
                    echo '<h3>Please confirm your entries below</h3>';
                    foreach ($formLabels as $key => $label) {
                        echo '
                    <div class="row">
                        <div class="col-md-3"><div class="confirm-label">' . $label . '</div></div>
                        <div class="col-md-9"><div class="confirm-value">' . $formKeys[$key] . '</div></div>
                    </div>
                ';
                        echo '<input type="hidden" name="'.$key.'" value="'.$formKeys[$key].'">';

                    }
                    echo '<input type="hidden" name="hasConfirmed" value="true">';
                    echo '<input class="btn btn-success" type="submit" name="send_feefo_data_confirm" value="Yes, all good!">';

                    echo '</div>';
                    echo '</form>';
                }
                ?>

            <?php

            if(!empty($errors)) {
                echo '<div class="alert alert-danger" role="alert">'.ucfirst(implode('<br>',$errors)).'</div>';
            }
            if(!empty($success)) {
                echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
            }
            ?>
            <div class="feefo-form">

                <form class="form" name="single_feefo_order" method="POST" action="">
                    <div class="form-group">
                        <label for="name">Product name *</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?php echo $formKeys['name'];?>">
                        <p class="help-block">Product name to appear in feedback email</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Customer Email *</label>
                        <input class="form-control" type="text" id="email" name="email" value="<?php echo $formKeys['email'];?>">
                        <p class="help-block">Email that feefo will send feedback email to</p>
                    </div>
                    <div class="form-group">
                        <label for="date">Sale Date *</label>
                        <input class="form-control" type="date" id="date" name="date" value="<?php echo $formKeys['date'];?>">
                        <p class="help-block">Date that the sale was made</p>
                    </div>
                    <div class="form-group">
                        <label for="description">Description *</label>
                        <input class="form-control" type="text" id="description" name="description" value="<?php echo $formKeys['description'];?>">
                        <p class="help-block">Brief description of the item ordered</p>
                    </div>
                    <div class="form-group">
                        <label for="logon">Logon *</label>
                        <input class="form-control" type="text" id="logon" name="logon" value="<?php echo $formKeys['logon'];?>">
                        <p class="help-block">Supplier’s Feefo logon</p>
                    </div>
                    <div class="form-group">
                        <label for="product_search_code">Product Search Code *</label>
                        <input class="form-control" type="text" id="product_search_code" name="product_search_code" value="<?php echo $formKeys['product_search_code'];?>"
                               placeholder="Example: SKU-123456">
                        <p class="help-block">The SKU is often a good choice for this.</p>
                    </div>
                    <div class="form-group">
                        <label for="order_ref">Order Reference *</label>
                        <input class="form-control" type="text" id="order_ref" name="order_ref" placeholder="4545XSHS" value="<?php echo $formKeys['order_ref'];?>">
                        <p class="help-block">Supplier’s unique order reference number</p>
                    </div>
                    <div class="form-group">
                        <label for="category">Category (optional)</label>
                        <input class="form-control" type="text" id="category" name="category" value="<?php echo $formKeys['category'];?>"
                               placeholder="Example: retail/europe/clothing">
                        <p class="help-block">Supplier’s organisational category information</p>
                    </div>
                    <div class="form-group">
                        <label for="product_link">Product Link (optional)</label>
                        <input class="form-control" type="text" id="product_link" name="product_link" placeholder="" value="<?php echo $formKeys['product_link'];?>">
                        <p class="help-block">Full URL to the product page on the supplier’s website</p>
                    </div>
                    <div class="form-group">
                        <label for="customer_ref">Customer Reference (optional)</label>
                        <input class="form-control" type="text" id="customer_ref" name="customer_ref" placeholder="" value="<?php echo $formKeys['customer_ref'];?>">
                        <p class="help-block">Supplier’s customer reference number useful for reports</p>
                    </div>
                    <div class="form-group">
                        <label for="feedback_date">Feedback date (optional)</label>
                        <input class="form-control" type="date" id="feedback_date" name="feedback_date" placeholder="" value="<?php echo $formKeys['feedback_date'];?>">
                        <p class="help-block">Date to send feefo feedback email to customer</p>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (optional)</label>
                        <input class="form-control" type="number" id="amount" name="amount" placeholder="" value="<?php echo $formKeys['amount'];?>">
                        <p class="help-block">Product price</p>
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency (optional)</label>
                        <select class="form-control" id="currency" name="currency">
                            <?php
                            foreach($formCurrencies as $key=>$label) {
                                echo '<option ';
                                if($formKeys['amount']===$key)
                                    echo 'selected="selected"';
                                echo' value="'.$key.'">'.$label.'</option>';
                            }
                            ?>
                        </select>
                        <p class="help-block">Currency sold in</p>
                    </div>
                    <div>
                        <input class="btn btn-success" type="submit" name="send_feefo_data" value="Send">
                    </div>
</form>

            </div>
        </div>

</div>