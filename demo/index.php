<?php
/**
 * Copyright 01.04.2016 Victoria Speckmann-Bresges
 */

header("Content-Type: text/html; charset=utf-8");
include('./bootstrap/autoload.php');

$domain = 'www.examplesupplier.com';

$part = isset($_GET['part']) ? $_GET['part'] : 'reviews';

$navLinks = [
    'links'=>'Links',
    'reviews'=>'Reviews',
    'reviews-2'=>'Reviews 2',
    'single-sale-order'=>'Single Sale Order',
    'bulk-sale-order-upload'=>'Bulk Sale Order Upload',
]
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="container">

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Feefo Manager Demo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                foreach($navLinks as $key=>$label) {
                    echo '<li ';
                    if($key==$part) {
                        echo 'class="active"';
                    }
                    echo '><a href="?part='.$key.'">'.$label.'</a></li>';
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">

            </ul>
        </div>
    </div>
</nav>
</div>
<?php

$partFile = './views/feefo-'.$part.'.php';
if(is_readable($partFile))
include $partFile;

?>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.2.min.js"><\/script>')</script>
<script>

        $(document).ready(function(){

            $('#fill-sample-data').click(function(){
                $('#name').val('Example Name');
                $('#email').val('sample@sample.com');
                $('#date').val('2016-04-05');
                $('#description').val('Some example description to display for the product');
                $('#logon').val('www.examplesupplier.com');
                $('#product_search_code').val('SKU-123456');
                $('#order_ref').val('my-order-ref-to-find-back-product-review');
                $('#category').val('category1/category2/category3');
                $('#product_link').val('http://www.examplesupplier.com?product=123456');
                $('#customer_ref').val('a-reference-to-map-customer-to-reviews');
                $('#feedback_date').val('2016-04-10');
                $('#amount').val(80.00);
                $('#currency').val('GBP');

            });

        });

</script>
<?php
// include feefo javascript if necessary
if($part==='links')
    echo $feefoLinks->getReviewLinkScript();
?>
</body>
</html>
