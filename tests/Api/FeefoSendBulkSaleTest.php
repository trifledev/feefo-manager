<?php
/**
 * Copyright 07.04.2016 Victoria Speckmann-Bresges
 */

namespace Trifledev\Feefo\Test\Api;

use Trifledev\Feefo\Api\FeefoSendBulkSale;

class FeefoSendBulkSaleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FeefoSendBulkSale
     */
    protected $_sendBulkSale;

    public function setup() {
        $this->_sendBulkSale = new FeefoSendBulkSale('www.examplesupplier.com');
    }

    public function testGetters()
    {
        $this->assertEquals($this->_sendBulkSale->getColsHeading(), "string");
        $this->assertEquals($this->_sendBulkSale->getExportBaseFilename(), "string");
        $this->assertEquals($this->_sendBulkSale->getExportStoragePath(), "string");
        $this->assertEquals($this->_sendBulkSale->getExportFilename(), "string");
        $this->assertEquals($this->_sendBulkSale->getExportFilePath(), "string");
    }

    public function testStoreOrdersToFile()
    {

        $testData = [
            'name'=>'Product name',
            'email'=>'Customer email',
            'date'=>'Todays date',
            'description'=>'Example description',
            'logon'=>'www.examplesupplier.com',
            'category'=>'category1',
            'product_search_code'=>'Example name',
            'order_ref'=>'Prod-internal-id',
            'product_link'=>'http://www.examplesupplier.com/products/133',
            'customer_ref'=>'Cust-internal-id'
        ];
        $this->assertContainsOnly('boolean', $this->_sendBulkSale->storeOrdersToFile($testData));
    }
}
