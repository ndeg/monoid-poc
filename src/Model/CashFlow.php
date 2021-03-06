<?php
namespace MonoidPoc\Model;

use MonoidPoc\Exception\UnexpectedDateException;

class CashFlow
{
    /**********************/
    /* Private properties */
    /**********************/

    /** @var \DateTime */
    private $date;

    /** @var \MonoidPoc\Model\Price */
    private $price;

    /*******************/
    /* Getters-Setters */
    /*******************/

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getFormattedDate()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @return \MonoidPoc\Model\Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return $this
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;

        return $this;
    }

    /*****************/
    /* Magic methods */
    /*****************/

    /**
     * Constructeur
     *
     * @param string $date
     * @param float $amount
     * @param string $code
     */
    public function __construct($date, $amount, $code)
    {
        $this->date = \DateTime::createFromFormat('Y-m-d', $date);

        $this->price = new Price($amount, $code);
    }

    /******************/
    /* Public methods */
    /******************/

    public function add(CashFlow $cashflow)
    {
        if ($this->getFormattedDate() !== $cashflow->getFormattedDate())
        {
            throw new UnexpectedDateException('Impossible to compare two cashflows not belonging to the same day.');
        }

        $newCashflow = clone $this;

        return $newCashflow->setPrice($this->price->add($cashflow->getPrice()));
    }

    /**
     * @param CashFlow $cashflow
     *
     * @return bool
     *
     * @throws UnexpectedDateException
     */
    public function isEqualTo(CashFlow $cashflow)
    {
        if ($this->date->format('Y-m-d') !== $cashflow->getDate()->format('Y-m-d'))
        {
            throw new UnexpectedDateException('Impossible to compare two cashflows not belonging to the same day.');
        }

        return $this->price->isEqualTo($cashflow->getPrice());
    }

}