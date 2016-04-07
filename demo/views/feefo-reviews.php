<?php
/**
 * Copyright 03.04.2016 Victoria Speckmann-Bresges
 */

use Trifledev\Feefo\Api\FeefoReview;

$feefoApi = new FeefoReview($domain);
$feedArr = $feefoApi->getReviews();

?>
<div class="container">
    <div class="row-title">
        <div class="container">
            <h1 class="main-headline"><!-- InstanceBeginEditable name="Page Heading" -->Customer Reviews
<!-- InstanceEndEditable --></h1>
        </div>
    </div>
        <div class="row content-div">

            <article class="span8 col-md-7">

                <div class="box_news extra blog_post">

                    <!--==========block-news=============-->
                    <section class="block-news m_b_no_space">
                        <div class="extra-wrap"><!-- InstanceBeginEditable name="Page Content" -->
                            <?php

                            if ($feedArr !== false && $feedArr !== null) {

                                unset($feedArr['feeds'][9]);

                                $percentageProducts = $feedArr['summary']['stats']['worst'];

                                $summary = $feedArr['summary'];

                                echo '<div class="feed-summary">';
                                echo '<div class="row content-div">';
                                echo '<div class="col-md-12">';
                                echo '<div class="row">';
                                echo '<div class="col-md-6">
<div class="summary-title">Product rating <span class="pull-right">' . $summary['total']['product_count'] . '</span></div>
    <div class="rating-list-item">Excellent<span class="pull-right summary-rating rating-color-dark-green">' . $summary['product_rating']['excellent'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Good<span class="pull-right summary-rating rating-color-light-green">' . $summary['product_rating']['good'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Poor<span class="pull-right summary-rating rating-color-yellow">' . $summary['product_rating']['poor'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Bad<span class="pull-right summary-rating rating-color-orange">' . $summary['product_rating']['bad'] . '</span><div class="clearfix"></div></div>
    </div>';
                                echo '<div class="col-md-6">
<div class="summary-title">Service rating <span class="pull-right">' . $summary['total']['service_count'] . '</span></div>
    <div class="rating-list-item">Excellent<span class="pull-right summary-rating rating-color-dark-green">' . $summary['service_rating']['excellent'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Good<span class="pull-right summary-rating rating-color-light-green">' . $summary['service_rating']['good'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Poor<span class="pull-right summary-rating rating-color-yellow">' . $summary['service_rating']['poor'] . '</span><div class="clearfix"></div></div>
    <div class="rating-list-item">Bad<span class="pull-right summary-rating rating-color-orange">' . $summary['service_rating']['bad'] . '</span></div><div class="clearfix"></div></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

                                echo '<div class="feed-list">';
                                echo '<div class="row title-row">';
                                echo '<div class="col-md-2">Date</div>';
                                echo '<div class="col-md-3">Product</div>';
                                echo '<div class="col-md-2">Rating</div>';
                                echo '<div class="col-md-5">Review</div>';
                                echo '</div>';
                                foreach ($feedArr['feeds'] as $feed) {
                                    if (isset($feed['review_rating'])) {

                                        $rating = str_split($feed['product_rating']);
                                        $ratingStars = '';
                                        $ratingClasses = $feefoApi->getHelper()->getRatingStyle($feed['product_rating']);

                                        foreach ($rating as $rate) {
                                            $ratingStars .= '<div class="rating-star"><i class="' . $ratingClasses['icon'] . ' rating-color-' . $ratingClasses['color'] . '"></i></div>';
                                        }

                                        echo '<div class="row list-item">';
                                        echo '<div class="col-md-2">';
                                        echo '<div class="review-date">' . $feefoApi->getHelper()->getHumanDate($feed['review_date']) . '</div>';
                                        echo '<div class="review-time-elapsed">' . $feefoApi->getHelper()->getTimeElapsed($feed['review_date']) . '</div>';
                                        echo '</div>';
                                        echo '<div class="col-md-3">';
                                        echo '<div>' . $feed['product_description'] . '</div>';
                                        echo '</div>';
                                        echo '<div class="col-md-2">
                <div class="review-rating"><div class="title">Product</div><div class="rating-star">' . $ratingStars . '</div><div class="clearfix"></div></div>
                <div class="review-rating"><div class="title">Service</div><div class="rating-star">' . $ratingStars . '</div><div class="clearfix"></div></div>
            </div>';

                                        $feed['customer_comment'] = iconv(mb_detect_encoding($feed['customer_comment'], mb_detect_order(), true), "UTF-8", $feed['customer_comment']);
                                        echo '<div class="col-md-5">' . utf8_encode($feed['customer_comment']) . '</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                            ?>


<!-- InstanceEndEditable --></div>

</section>
<!--==========end block-news=============-->

</div>
</article>

<article class="span4 col-md-4">
    <div class="col-left">
        <div class="feefo-widget-sidebar">

            <h4 class="heading-h4">Customer Reviews</h4>

            <div class="tab-content">

                <?php
                $counter = 0;

                foreach ($feedArr['feeds'] as $feed) {

                    $counter++;

                    if (isset($feed['review_rating'])) {

                        $rating = str_split($feed['product_rating']);
                        $ratingStars = '';
                        $ratingClasses = $feefoApi->getHelper()->getRatingStyle($feed['product_rating']);

                        foreach ($rating as $rate) {
                            $ratingStars .= '<div class="rating-star"><i class="' . $ratingClasses['icon'] . ' rating-color-' . $ratingClasses['color'] . '"></i></div>';
                        }

                        echo '<div class="tab-pane fade in active" id="tab1">';
                        echo '<div>';
                        echo '<div class="review-date">' . $feefoApi->getHelper()->getHumanDate($feed['review_date']) . ' <small class="pull-right">' . $feefoApi->getHelper()->getTimeElapsed($feed['review_date']) . '</small></div>';
                        echo '<div class="review-time-elapsed"></div>';
                        echo '</div>';
                        /*
                        echo '<div class="col-md-2">
    <div class="review-rating"><div class="title">Product</div><div class="rating">' . $ratingStars . '</div><div class="clearfix"></div></div>
    <div class="review-rating"><div class="title">Service</div><div class="rating">' . $ratingStars . '</div><div class="clearfix"></div></div>
</div>';*/

                        $feed['customer_comment'] = iconv(mb_detect_encoding($feed['customer_comment'], mb_detect_order(), true), "UTF-8", $feed['customer_comment']);
                        echo '<blockquote><i class="fa fa-quote-left"></i> <em>' . utf8_encode($feed['customer_comment_short']) . '</em></blockquote>';
                        echo '</div>';
                    }

                    if($counter==3)
                        break;

                }
                ?>

                <a href="/reviews" class="link">Read More Reviews</a>
            </div> <!-- /tab-content -->
        </div>
    </div>
</article>


</div>