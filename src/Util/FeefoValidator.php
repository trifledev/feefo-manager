<?php
/**
 * Copyright 06.04.2016 Victoria Speckmann-Bresges
 */

namespace Trifledev\Feefo\Util;

/**
 * Class FeefoValidator
 * @package Trifledev\Feefo\Util
 */
/**
 * Class FeefoValidator
 * @package Trifledev\Feefo\Util
 */
class FeefoValidator
{

    /**
     * @var array
     */
    private $validation_errors = [];
    /**
     * @var array
     */
    private $validOrders = [];
    /**
     * @var array
     */
    private $invalidOrders = [];

    /**
     * @var array
     */
    private $order_params = [
        'name'=>'m',
        'email'=>'m',
        'date'=>'m',
        'description'=>'m',
        'logon'=>'m',
        'product_search_code'=>'m',
        'order_ref'=>'m',
        'category'=>'o', // optional
        'product_link'=>'o', // optional
        'customer_ref'=>'o', // optional
        'feedback_date'=>'o', // optional
        'amount'=>'o', // optional
        'currency'=>'o', // optional
    ];

    /**
     *
     */
    function __constuct() {
    }

    /**
     * @return array
     */
    public function getOrderParams()
    {
        return $this->order_params;
    }

    /**
     * @param $key
     * @return array
     */
    public function getOrderParam($key)
    {
        return $this->order_params[$key];
    }
    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    /**
     * @param array $validation_errors
     */
    public function setValidationErrors($validation_errors)
    {
        $this->validation_errors = $validation_errors;
    }
    /**
     * @param string $key Parameter to check
     * @return bool
     */
    function isParamMandatory($key) {
        return $this->getOrderParam($key) === 'm';
    }

    /**
     * @param $orders
     * @return bool
     */
    public function areOrdersValid($orders) {

        if(empty($orders))
            return false;

        foreach($orders as $order) {

            if($this->isOrderValid($order)) {
                $this->validOrders[] = $order;
            } else {
                $this->invalidOrders[] = $order;
            }

        }

        return empty($this->invalidOrders);

    }

    /**
     * @param $order
     * @return bool
     */
    function isOrderValid($order) {

        $keysToCheck = array_intersect(array_keys($order),array_keys($this->getOrderParams()));
        $formLabels = FeefoHelper::getFormLabels($order);
        $errors = [];

        $rules = [
            'name'          => 'string',
            'email'         => 'email',
            'date'          => 'date',
            'description'   => 'string',
            'logon'         => 'string',
            'category'      => 'string',
            'product_search_code'   => 'string',
            'order_ref'     => 'string',
            'product_link'  => 'url',
            'customer_ref'  => 'string',
            'feedback_date' => 'date',
            'amount'        => 'string',
            'currency'      => 'string'
        ];

        foreach($keysToCheck as $key) {

            $detail = $order[$key];

            if($this->isParamMandatory($key)) {
                if(!isset($order[$key])) {
                    $errors[$key] = $key . ' is a mandatory parameter';
                }
            }

            if(isset($rules[$key]))
                switch($rules[$key]) {

                    case 'string':
                        if(!is_string($detail)) {
                            $errors[$key] = $key . ' must be a string ' . gettype($detail) .' given';
                        }
                        break;
                    case 'decimal':
                        if(!is_double($detail)) {
                            $errors[$key] = $key . ' must be of type double ' . gettype($detail) .' given';
                        }
                        break;
                    case 'url':
                        if(filter_var($detail, FILTER_VALIDATE_URL) === false) {
                            $errors[$key] = $key . ' must be a valid URL';
                        }
                        break;
                    case 'email':
                        if(filter_var($detail, FILTER_VALIDATE_EMAIL) === false) {
                            $errors[$key] = $key . ' must be a valid email address';
                        }
                        break;
                    case 'date':
                        $d = \DateTime::createFromFormat('Y-m-d', $detail);
                        if(!$d && $d->format('Y-m-d') === $detail) {
                            $errors[$key] = $key . ' must be a valid date';
                        }
                        break;

                }
            if(empty($detail)) {
                $errors[$key] = 'You must provide a value for '.$formLabels[$key];
            }

        }

        $this->setValidationErrors($errors);

        return empty($errors);

    }

    /**
     * @return array
     */
    public function getValidOrders()
    {
        return $this->validOrders;
    }

    /**
     * @param array $validOrders
     */
    public function setValidOrders($validOrders)
    {
        $this->validOrders = $validOrders;
    }

    /**
     * @return array
     */
    public function getInvalidOrders()
    {
        return $this->invalidOrders;
    }

    /**
     * @param array $invalidOrders
     */
    public function setInvalidOrders($invalidOrders)
    {
        $this->invalidOrders = $invalidOrders;
    }

}