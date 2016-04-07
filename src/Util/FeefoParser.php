<?php
/**
 * Copyright 01.04.2016 Victoria Speckmann-Bresges
 */

namespace Trifledev\Feefo\Util;


/**
 * Class FeefoParser
 * @package Trifledev\Feefo\Util
 */
class FeefoParser
{

    /**
     * FeefoParser constructor.
     */
    function __construct()
    {
        return $this;
    }

    /**
     * @param $response
     * @return array
     */
    function parseFeedResponse($response)
    {

        if (null === $response)
            return false;

        $feedSummary = $response['SUMMARY'];
        $summary = [];

        if (isset($feedSummary['MODE']))
            $summary['mode'] = $feedSummary['MODE'];
        if (isset($feedSummary['VENDORLOGON']))
            $summary['vendor_logon'] = $feedSummary['VENDORLOGON'];
        if (isset($feedSummary['VENDORREF']))
            $summary['vendor_reference'] = $feedSummary['VENDORREF'];
        if (isset($feedSummary['TOTALSERVICECOUNT']))
            $summary['total']['service_count'] = $feedSummary['TOTALSERVICECOUNT'];
        if (isset($feedSummary['TOTALPRODUCTCOUNT']))
            $summary['total']['product_count'] = $feedSummary['TOTALPRODUCTCOUNT'];
        if (isset($feedSummary['COUNT']))
            $summary['count'] = $feedSummary['COUNT'];
        if (isset($feedSummary['SUPPLIERLOGO']))
            $summary['supplier_logo'] = $feedSummary['SUPPLIERLOGO'];
        if (isset($feedSummary['TITLE']))
            $summary['title'] = $feedSummary['TITLE'];
        if (isset($feedSummary['BEST']))
            $summary['stats']['best'] = $feedSummary['BEST'];
        if (isset($feedSummary['WORST']))
            $summary['stats']['worst'] = $feedSummary['WORST'];
        if (isset($feedSummary['AVERAGE']))
            $summary['stats']['average'] = $feedSummary['AVERAGE'];
        if (isset($feedSummary['START']))
            $summary['stats']['start'] = $feedSummary['START'];
        if (isset($feedSummary['LIMIT']))
            $summary['stats']['limit'] = $feedSummary['LIMIT'];
        if (isset($feedSummary['PRODUCTEXCELLENT']))
            $summary['product_rating']['excellent'] = $feedSummary['PRODUCTEXCELLENT'];
        if (isset($feedSummary['PRODUCTGOOD']))
            $summary['product_rating']['good'] = $feedSummary['PRODUCTGOOD'];
        if (isset($feedSummary['PRODUCTPOOR']))
            $summary['product_rating']['poor'] = $feedSummary['PRODUCTPOOR'];
        if (isset($feedSummary['PRODUCTBAD']))
            $summary['product_rating']['bad'] = $feedSummary['PRODUCTBAD'];
        if (isset($feedSummary['SERVICEEXCELLENT']))
            $summary['service_rating']['excellent'] = $feedSummary['SERVICEEXCELLENT'];
        if (isset($feedSummary['SERVICEGOOD']))
            $summary['service_rating']['good'] = $feedSummary['SERVICEGOOD'];
        if (isset($feedSummary['SERVICEPOOR']))
            $summary['service_rating']['poor'] = $feedSummary['SERVICEPOOR'];
        if (isset($feedSummary['SERVICEBAD']))
            $summary['service_rating']['bad'] = $feedSummary['SERVICEBAD'];
        if (isset($feedSummary['TOTALRESPONSES']))
            $summary['total']['responses'] = $feedSummary['TOTALRESPONSES'];
        if (isset($feedSummary['FEEDGENERATION']))
            $summary['feed_date'] = date('d.m.Y', strtotime($feedSummary['FEEDGENERATION']));


        $feedList = $response['FEEDBACK'];

        $list = [];

        foreach ($feedList as $item) {

            $current = [];

            // parameters always received
            if (isset($item['FEEDBACKID']))
                $current['feedback_id'] = $item['FEEDBACKID'];
            if (isset($item['DATE']))
                $current['date'] = date('d.m.Y', strtotime($item['DATE']));
            if (isset($item['HREVIEWDATE']))
                $current['review_date'] = $item['HREVIEWDATE'];
            if (isset($item['HREVIEWRATING']))
                $current['review_rating'] = $item['HREVIEWRATING'];
            if (isset($item['PRODUCTCODE']))
                $current['product_code'] = $item['PRODUCTCODE'];
            if (isset($item['DESCRIPTION']))
                $current['product_description'] = $item['DESCRIPTION'];
            if (isset($item['PRODUCTRATING']))
                $current['product_rating'] = $item['PRODUCTRATING'];
            if (isset($item['SERVICERATING']))
                $current['service_rating'] = $item['SERVICERATING'];
            if (isset($item['LINK']))
                $current['product_link'] = $item['LINK'];
            if (isset($item['FACEBOOKSHARELINK']))
                $current['social_share_link']['facebook'] = $item['FACEBOOKSHARELINK'];
            if (isset($item['CUSTOMERCOMMENT']))
                $current['customer_comment'] = $item['CUSTOMERCOMMENT'];
            if (isset($item['SHORTCUSTOMERCOMMENT']))
                $current['customer_comment_short'] = $item['SHORTCUSTOMERCOMMENT'];
            if (isset($item['VENDORCOMMENT']))
                $current['vendor_comment'] = $item['VENDORCOMMENT'];
            if (isset($item['SHORTVENDORCOMMENT']))
                $current['vendor_comment_short'] = $item['SHORTVENDORCOMMENT'];
            if (isset($item['READMOREURL']))
                $current['url_readmore'] = $item['READMOREURL'];

            // optional parameters received
            if (isset($item['ADDITIONALITEMS'])) {
                if (isset($addItem['ADDITIONALITEMS']['ITEM'])) {
                    foreach ($addItem['ADDITIONALITEMS']['ITEM'] as $addItem) {
                        $current['product_additional_item_names'][] = $addItem;
                    }
                }
            }
            if (isset($item['FURTHERCOMMENTSTHREAD'])) {
                if (isset($addItem['FURTHERCOMMENTSTHREAD']['POST'])) {
                    foreach ($addItem['ADDITIONALITEMS']['POST'] as $comment) {

                        $commentArr = [];
                        if (isset($comment['DATE']))
                            $commentArr['date'] = date('d.m.Y', strtotime($comment['DATE']));
                        if (isset($comment['VENDORCOMMENT']))
                            $commentArr['vendor_comment'] = $comment['VENDORCOMMENT'];
                        if (isset($comment['CUSTOMERCOMMENT']))
                            $commentArr['customer_comment'] = $comment['CUSTOMERCOMMENT'];
                        if (isset($comment['SERVICERATING']))
                            $commentArr['service_rating'] = $comment['SERVICERATING'];
                        if (isset($comment['PRODUCTRATING']))
                            $commentArr['service_rating'] = $comment['PRODUCTRATING'];

                        $current['product_further_comments'][] = $commentArr;
                    }
                }
            }

            if (!empty($current))
                $list[] = $current;

        }
        return ['feeds' => $list, 'summary' => $summary];
    }

    /**
     * @param array $file
     * @return array|mixed
     * @todo Try to use mime_content_type() if extension enabled Fatal error: Call to undefined function mime_content_type()
     */
    function parseBulkOrderFile($file)
    {

        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($fileExt === 'txt') {
            return $this->parseTextFile($file['tmp_name']);
        }
        if ($fileExt === 'xml') {
            return $this->parseXmlFile($file['tmp_name']);
        }
        /*
        $mimeType = \mime_content_type($filePath);

        if ($mimeType === 'text/plain') {
            return $this->parseTextFile($filePath);
        }
        if ($mimeType === 'application/xml') {
            return $this->parseXmlFile($filePath);
        }*/

    }

    /**
     * Used for validation
     * @param $filePath
     * @return array
     */
    private function parseTextFile($filePath)
    {

        $result = [];
        $fp = fopen($filePath, 'r');
        if(($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
            if($headers)
                while(($line = fgetcsv($fp, 0, "\t")) !== FALSE)
                    if($line)
                        if(sizeof($line) == sizeof($headers))
                            $result[] = array_combine($headers, $line);
        fclose($fp);
        return $result;

    }

    /**
     * @param $xml
     * @return mixed
     */
    private function parseXmlFile($xml)
    {
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
    /**
     * @param $xml
     * @return array
     */
    public function parseXml($xml)
    {
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
}