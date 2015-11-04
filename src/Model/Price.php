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
     * @param Currency $currency
     */
    public function __construct($amount, Currency $currency)
    {
        $this->amount = (float) $amount;
        $this->currency = $currency;
    }

    /*******************/
    /* Getters-setters */
    /*******************/

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
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
            throw new UnexpectedCurrencyException();
        }

        $amount = $this->getAmount() + $price->getAmount();

        return new Price($amount, $this->getCurrency());
    }
}