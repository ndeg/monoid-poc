<?php

namespace MonoidPoc\Model;

use MonoidPoc\Exception\UnexpectedCurrencyException;

class Price
{
    /**********************/
    /* Private properties */
    /**********************/

    /**
     * @var float
     */
    private $amount = 0.0;

    /**
     * @var Currency
     */
    private $currency;

    /*****************/
    /* Magic methods */
    /*****************/

    /**
     * Constructor
     *
     * @param $amount
     * @param $currencyCode
     */
    public function __construct($amount, $currencyCode)
    {
        $this->amount = (float) $amount;
        $this->currency = new Currency($currencyCode);
    }

    /*******************/
    /* Getters-setters */
    /*******************/

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /******************/
    /* Public methods */
    /******************/

    /**
     * @param Price $price
     *
     * @return Price
     *
     * @throws UnexpectedCurrencyException
     */
    public function add(Price $price)
    {
        if (!$this->currency->isEqualTo($price->getCurrency())) {
            throw new UnexpectedCurrencyException("Impossible to add two prices with different currencies.");
        }

        $newPrice = clone $this;

        return $newPrice->setAmount($this->getAmount() + $price->getAmount());;
    }

    /**
     * @param Price $price
     *
     * @return bool
     *
     * @throws UnexpectedCurrencyException
     */
    public function isEqualTo(Price $price)
    {
        if (!$this->currency->isEqualTo($price->getCurrency())) {
            throw new UnexpectedCurrencyException("Impossible to compare two prices with different currencies.");
        }

        return $this->amount === $price->getAmount();
    }
}