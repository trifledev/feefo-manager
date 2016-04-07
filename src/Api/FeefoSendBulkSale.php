<?php

namespace Trifledev\Feefo\Api;

use Trifledev\Feefo\Contract\FeefoSendBulkSaleInterface;
use Trifledev\Feefo\FeefoManager;

/**
 * Class FeefoSendSale
 * @package Trifledev\Feefo\Api
 */
class FeefoSendBulkSale extends FeefoManager implements FeefoSendBulkSaleInterface
{

    /**
     * @var array
     */
    private $colsHeading = [
        'name',
        'email',
        'date',
        'description',
        'logon',
        'category',
        'product_search_code',
        'order_ref',
        'product_link',
        'customer_ref'
    ];
    /**
     * @var string
     */
    private $export_base_filename = 'feefo_bulk_order_export';
    /**
     * @var string
     */
    private $export_storage_path = '';
    /**
     * @var string
     */
    private $export_file_name = '';
    /**
     * @var string
     */
    private $export_file_path = '';

    /**
     * @param $file
     * @return array|bool
     * @throws \Exception
     */
    public function prepareBulkOrder($file) {

        $orders = $this->getParser()->parseBulkOrderFile($file);

        if($this->getValidator()->areOrdersValid($orders)) {

            $fileContent = $this->generateSalesFileContent($orders);
            $this->storeOrdersToFile($fileContent);

            return ['filename'=>$this->getExportFilename(),'orders'=>$orders];

        } else {
            return false;
        }

    }

    /**
     * @param $fileName
     * @return mixed
     */
    public function sendBulkOrderFile($fileName) {

        return $this->getFtp()->putFile($this->getExportStoragePath().DIRECTORY_SEPARATOR.$fileName);

    }

    /**
     * @param $orders
     * @return string
     */
    private function generateSalesFileContent($orders) {

        $lines[] =  implode("\t",$this->getColsHeading());
        foreach($orders as $order) {

            $lines[] = implode("\t",$order);

        }
        return implode("\n",$lines);

    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function storeOrdersToFile($data) {

        if(empty($this->getExportStoragePath()))
            throw new \Exception('You must provide a storage path using setExportStoragePath()');

        if(!is_dir($this->getExportStoragePath()))
            mkdir($this->getExportStoragePath(),0755,true);

        $this->setExportFilePath($this->getExportStoragePath().'/'.$this->generateExportFilename());

        return file_put_contents($this->getExportFilePath(),$data);

    }

    /**
     * @return string
     */
    private function generateExportFilename() {
        return $this->export_file_name =  $this->getExportBaseFilename().'_'.date('YmdHis').'.txt';
    }

    /**
     * @return string
     */
    public function getExportFilename() {
        return $this->export_file_name;
    }
    /**
     * @return array
     */
    public function getColsHeading()
    {
        return $this->colsHeading;
    }

    /**
     * @param array $colsHeading
     */
    public function setColsHeading($colsHeading)
    {
        $this->colsHeading = $colsHeading;
    }

    /**
     * @return string
     */
    public function getExportBaseFilename()
    {
        return $this->export_base_filename;
    }

    /**
     * @param string $export_base_filename
     */
    public function setExportBaseFilename($export_base_filename)
    {
        $this->export_base_filename = $export_base_filename;
    }

    /**
     * @return string
     */
    public function getExportStoragePath()
    {
        return $this->export_storage_path;
    }

    /**
     * @param string $export_storage_path
     * @return mixed|void
     */
    public function setExportStoragePath($export_storage_path)
    {
        $this->export_storage_path = $export_storage_path;
    }

    /**
     * @return string
     */
    public function getExportFilePath()
    {
        return $this->export_file_path;
    }

    /**
     * @param string $export_file_path
     */
    public function setExportFilePath($export_file_path)
    {
        $this->export_file_path = $export_file_path;
    }
}