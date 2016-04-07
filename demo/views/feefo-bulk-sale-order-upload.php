<?php
/**
 * Copyright 06.04.2016 Victoria Speckmann-Bresges
 */

use Trifledev\Feefo\Api\FeefoSendBulkSale;

$feefoInform = new FeefoSendBulkSale($domain);
$feefoInform->setExportStoragePath(__DIR__.'/../orders');
$entries = [];
$errors = [];
$success = '';
$isFileValid = false;
$hasConfirmed = false;
$prepResult = [];

// set currency form select options
$formCurrencies = [
    'GBP' => '&pound; Pound',
    'EUR' => '&euro; Euro',
    'USD' => '&#36; U.S. Dollar',
];

if (isset($_POST['bulk_feefo_order_upload']) || isset($_POST['bulk_feefo_order_upload_confirm'])) {

    $hasConfirmed = isset($_POST['bulk_feefo_order_upload_confirm']) && $_POST['hasConfirmed'] === 'true';
    if (!$hasConfirmed) {
        $prepResult = $feefoInform->prepareBulkOrder($_FILES['import_file']);
        $isFileValid = !empty($prepResult);
        if (!$isFileValid) {

            $errors = $feefoInform->getValidator()->getValidationErrors();

        } else {
            $entries = $prepResult['orders'];
        }
    }
        if ($hasConfirmed) {

            $result = $feefoInform->sendBulkOrderFile($_POST['filename']);

            if ($result) {
                $success = 'Order(s) successfully uploaded';
            } else {
                $errors[] = 'Could not connect to Feefo FTP Server';
            }
        }

}
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?php
            if ($isFileValid && !$hasConfirmed) {
                echo '<form class="form" method="POST" action="">';
                echo '<div class="feefo-confirm">';
                echo '<h3>Please confirm your upload</h3>';
                echo '<table>';
                echo '<tr>';
                foreach($feefoInform->getColsHeading() as $heading) {
                    echo '<td>' . $heading . '</td>';
                }
                echo '</tr>';
                foreach ($entries as $entry) {
                    echo '<tr>';
                    foreach($entry as $col) {
                        echo '<td>' . $col . '</td>';
                    }
                    echo '<tr>';
                }
                echo '</table>';
                echo '<input type="hidden" name="hasConfirmed" value="true">';
                echo '<input type="hidden" name="filename" value="'.$prepResult['filename'].'">';
                echo '<input class="btn btn-success" type="submit" name="bulk_feefo_order_upload_confirm" value="Yes, all good!">';

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
            <h3>Bulk Sale Inform Upload</h3>

            <div class="feefo-form">
                <form enctype="multipart/form-data" class="form" method="POST" action="">
                    <div class="form-group">
                        <label for="import_file">File to export to Feefo</label>
                        <input class="form-control" type="file" id="import_file" name="import_file">
                        <p class="help-block">Files supported: XML, CSV (tab delimited), TXT </p>
                    </div>
                    <input class="btn btn-success" type="submit" name="bulk_feefo_order_upload" value="Send">
                </form>
            </div>
        </div>
    </div>

</div>
