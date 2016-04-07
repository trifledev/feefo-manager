<?php

namespace Trifledev\Feefo\Api;

use Trifledev\Feefo\FeefoManager;

/**
 * Class FeefoReview
 * @package Feefo\Api
 */
class FeefoReview extends FeefoManager
{

    /**
     * @var
     */
    private $feed;

    /**
     * FeefoReview constructor.
     * @param $domain
     */
    function __construct($domain) {

        parent::__construct($domain);
    }

    /**
     * @param $feed
     */
    function setFeed($feed) {
        $this->feed = $feed;
    }

    /**
     * @return array
     */
    function getReviews() {

        $rawData = $this->getFeefoData($this->getApiUrl().'/feefo/xmlfeed.jsp?logon='.$this->getLogon());

        $this->feed = parent::getParser()->parseFeedResponse($rawData);

        return $this->feed;
    }

    /**
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    function getFeefoData($url) {

        $use_errors = libxml_use_internal_errors(true);
        $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (false === $xml) {
            libxml_clear_errors();
            libxml_use_internal_errors($use_errors);
            return false;
        } else {
            // shot way to load objects into array
            return $this->getParser()->parseXml($xml);
        }

    }

    /**
     *
     */
    function dumpTable() {

        $feedArr = $this->feed;

        echo '<div class="feed-list">';
        foreach ($feedArr['feeds'] as $feed) {

            echo '<div class="row">';
            echo '<div class="col-md-2">Feed id</div>';
            echo '<div class="col-md-6">Product</div>';
            echo '<div class="col-md-2">Review Date</div>';
            echo '<div class="col-md-2">Review Rating</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-2">' . $feed['feedback_id'] . '</div>';
            echo '<div class="col-md-6">' . $feed['product_description'] . '</div>';
            if(isset($feed['review_date']))
                echo '<div class="col-md-2">' . $feed['review_date'] . '</div>';
            if(isset($feed['review_rating']))
                echo '<div class="col-md-2">' . $feed['review_rating'] . '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-2">Product Link</div>';
            echo '<div class="col-md-10"><a href="'.$feed['product_link'].'">'.$feed['product_link'].'</a></div>';
            echo '</div>';
            if(isset($feed['social_share_link'])) {
                echo '<div class="row">';
                echo '<div class="col-md-12">';
                echo '<div>Social Share Links</div>';
                foreach($feed['social_share_link'] as $media=>$link) {
                    echo '<div>'.ucfirst($media).': <a href="'.$link.'">'.$link.'</a></div>';
                }
                echo '</div>';
                echo '</div>';
            }
            if(isset($feed['social_share_link'])) {
                echo '<div class="row">';
                echo '<div class="col-md-2">Customer comment</div>';
                echo '<div class="col-md-10">' . $feed['customer_comment'] . '</div>';
                echo '</div>';
            }
            if(isset($feed['vendor_comment'])) {
                echo '<div class="row">';
                echo '<div class="col-md-2">Vendor comment</div>';
                echo '<div class="col-md-10">'.$feed['vendor_comment'].'</div>';
                echo '</div>';
            }
            echo '<div class="row">';
            echo '<div class="col-md-2">Read more link</div>';
            echo '<div class="col-md-10"><a href="'.$feed['url_readmore'].'">'.$feed['url_readmore'].'</a></div>';
            echo '</div>';

        }
        echo '<table>';
    }
}