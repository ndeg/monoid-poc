<?php

namespace MonoidPoc\Model;

class Currency
{
    /**********************/
    /* Private properties */
    /**********************/

    /**
     * @var string
     */
    private $code;

    /*****************/
    /* Magic methods */
    /*****************/

    /**
     * Constructor.
     *
     * @param string $code
     */
    public function __construct($code)
    {
        $this->setCode($code);
    }

    /*******************/
    /* Getters-setters */
    /*******************/

    /**
     * @param string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = (string) $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /*******************/
    /* Public function */
    /*******************/

    /**
     * @param Currency $currency
     *
     * @return bool
     */
    public function isEqualTo(Currency $currency)
    {
        return ($this->getCode() === $currency->getCode());
    }
}