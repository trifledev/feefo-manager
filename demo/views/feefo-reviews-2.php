<?php

use Trifledev\Feefo\Api\FeefoReview;

$feefoApi = new FeefoReview($domain);
$feedArr = $feefoApi->getReviews();
unset($feedArr['feeds'][9])
?>
<style>
    .feed-list {

    }
    .feed-list .item {
        border-top:1px solid #ccc;
        padding:20px 10px;
    }
    .feed-list .title-row {
        padding:20px 10px;
    }
    .feed-list .rating-star {
        font-size: 22px;;
    }
    .feed-list .rating-color-dark-green {
        color: #005413;
    }
    .feed-list .rating-color-light-green {
        color: #009a23
    }
    .feed-list .rating-color-yellow {
        color: #cd9800
    }
    .feed-list .rating-color-orange {
        color: #d05500
    }
    .feed-list .review-rating .rating-star {
        float:left;
        margin-right: 6px;
    }
    .feed-list .review-rating {
        display: block;
    }
    .feed-list .review-time-elapsed {
        font-size:12px;
        color:#949494;
    }
    .feed-summary .side-left {
        margin-top:20px;
        text-align: center;
    }
    .feed-summary .summary-rating {
        padding:0 6px;
        color:#ffffff;
        border-radius: 3px;
    }
    .feed-summary .rating-list-item {
        line-height:30px;
        margin-bottom: 4px;
    }
    .feed-summary .rating-color-dark-green {
        background-color: #005413;
    }
    .feed-summary .rating-color-light-green {
        background-color: #009a23
    }
    .feed-summary .rating-color-yellow {
        background-color: #cd9800
    }
    .feed-summary .rating-color-orange {
        background-color: #d05500
    }
</style>
<div class="container">

    <?php

    $percentageProducts = $feedArr['summary']['stats']['worst'];

    $summary = $feedArr['summary'];

    echo '<div class="feed-summary well">';
    echo '<div class="row">';
    echo '<div class="col-md-3 side-left">';
    echo '<div class="logo"><img src="'.$summary['supplier_logo'].'"></div>';
    echo '<h3>'.$summary['title'].'</h3>';
    echo '</div>';
    echo '<div class="col-md-9">';
    echo '<div class="row">';
    echo '<div class="col-md-6"><h4>Product rating <span class="pull-right">'.$summary['total']['product_count'].'</span></h4></div>';
    echo '<div class="col-md-6"><h4>Service rating <span class="pull-right">'.$summary['total']['service_count'].'</span></h4></div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-6">
    <div class="rating-list-item">Excellent<span class="pull-right summary-rating rating-color-dark-green">'.$summary['product_rating']['excellent'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Good<span class="pull-right summary-rating rating-color-light-green">'.$summary['product_rating']['good'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Poor<span class="pull-right summary-rating rating-color-yellow">'.$summary['product_rating']['poor'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Bad<span class="pull-right summary-rating rating-color-orange">'.$summary['product_rating']['bad'].'</span><div class="clearfix"></div></div>
    </div>';
    echo '<div class="col-md-6">
    <div class="rating-list-item">Excellent<span class="pull-right summary-rating rating-color-dark-green">'.$summary['service_rating']['excellent'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Good<span class="pull-right summary-rating rating-color-light-green">'.$summary['service_rating']['good'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Poor<span class="pull-right summary-rating rating-color-yellow">'.$summary['service_rating']['poor'].'</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Bad<span class="pull-right summary-rating rating-color-orange">'.$summary['service_rating']['bad'].'</span></div><div class="clearfix"></div></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="feed-list">';
    echo '<div class="row title-row">';
    echo '<div class="col-md-2">Date</div>';
    echo '<div class="col-md-2">Product</div>';
    echo '<div class="col-md-1">Rating</div>';
    echo '<div class="col-md-7">Review</div>';
    echo '</div>';
    foreach($feedArr['feeds'] as $key=>$feed) {
        if(isset($feed['review_rating'])) {

            $rating = str_split ($feed['product_rating']);
            $ratingStars = '';
            $ratingClasses = $feefoApi->getHelper()->getRatingStyle($feed['product_rating']);

            foreach($rating as $rate) {
                $ratingStars .= '<div class="rating-star"><i class="'.$ratingClasses['icon'].' rating-color-'.$ratingClasses['color'].'"></i></div>';
            }

            echo '<div class="row item">';
            echo '<div class="col-md-2">';
            echo '<div class="review-date">'.$feefoApi->getHelper()->getHumanDate($feed['review_date']).'</div>';
            echo '<div class="review-time-elapsed">'.$feefoApi->getHelper()->getTimeElapsed($feed['review_date']).'</div>';
            echo '</div>';
            echo '<div class="col-md-2">';
            echo '<div>'.$feed['product_description'].'</div>';
            echo '</div>';
            echo '<div class="col-md-1">
                <div class="review-rating"><div class="title">Product</div><div class="rating">'.$ratingStars.'</div><div class="clearfix"></div></div>
                <div class="review-rating"><div class="title">Service</div><div class="rating">'.$ratingStars.'</div><div class="clearfix"></div></div>
            </div>';

            $feed['customer_comment'] = iconv(mb_detect_encoding($feed['customer_comment'], mb_detect_order(), true), "UTF-8", $feed['customer_comment']);
            echo '<div class="col-md-7">'.utf8_encode ($feed['customer_comment']).'</div>';
            echo '</div>';
        }
    }
    echo '</div>';
    ?>
</div>