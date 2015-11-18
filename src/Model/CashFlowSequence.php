<?php

namespace MonoidPoc\Model;

use MonoidPoc\Exception\UnexpectedCurrencyException;
use MonoidPoc\Exception\UnexpectedDataException;

class CashFlowSequence
{
    const DATE_COL = 0;
    const AMOUNT_COL = 1;
    const CURRENCY_COL = 2;

    /*******************/
    /* Private methods */
    /*******************/

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var \MonoidPoc\Model\CashFlow[]
     */
    private $cashflows = array();

    /*****************/
    /* Magic methods */
    /*****************/

    public function __construct(array $cashflows)
    {
        foreach ($cashflows as $cashflow)
        {
            $date = isset($cashflow[self::DATE_COL]) ? $cashflow[self::DATE_COL] : null;
            $amount = isset($cashflow[self::AMOUNT_COL]) ? $cashflow[self::AMOUNT_COL] : null;
            $currency = isset($cashflow[self::CURRENCY_COL]) ? $cashflow[self::CURRENCY_COL] : null;

            if (!$date) {
                throw new UnexpectedDataException('Date is not set into input data.');
            }

            if (!$amount) {
                throw new UnexpectedDataException('Amount is not set into input data.');
            }

            if (!$currency) {
                throw new UnexpectedDataException('Currency is not set into input data.');
            }

            if ($this->currencyCode) {
                if ($this->currencyCode !== $currency) {
                    throw new UnexpectedCurrencyException(sprintf('Currency %s is not authorized in a %s currency cashflow sequence.', $this->currencyCode, $currency));
                }
            }

            $this->currencyCode = $currency;

            $currentCashFlow = new CashFlow($date, $amount, $currency);

            $this->addCashFlow($currentCashFlow);
        }
    }

    /*******************/
    /* Getters-setters */
    /*******************/

    public function getCashFlows()
    {
        return $this->cashflows;
    }

    /******************/
    /* Public methods */
    /******************/

    /**
     * @param CashFlowSequence $sequence
     *
     * @return self
     */
    public function add(CashFlowSequence $sequence)
    {
        foreach ($sequence->getCashFlows() as $date => $cashflow)
        {
            $this->addCashFlow($cashflow);
        }

        return $this;
    }

    /**
     * @param $sequence
     * @return bool
     */
    public function isEqualTo(CashFlowSequence $sequence)
    {
        $cashflows = $sequence->getCashFlows();

        $keys1 = array_keys($this->cashflows);
        $keys2 = array_keys($cashflows);

        if (count(array_diff($keys1, $keys2))>0) {
            return false;
        }

        foreach ($keys1 as $key)
        {
            try {
                if (!$this->cashflows[$key]->isEqualTo($cashflows[$key])) {
                    return false;
                }
            }
            catch (UnexpectedCurrencyException $e)
            {
                return false;
            }
        }

        return true;
    }

    /*******************/
    /* Private methods */
    /*******************/

    /**
     * @param CashFlow $cashflow
     * @throws \MonoidPoc\Exception\UnexpectedDateException
     */
    private function addCashFlow(CashFlow $cashflow)
    {
        $date = $cashflow->getFormattedDate();

        if (!isset($this->cashflows[$date])) {
            $this->cashflows[$date] = new CashFlow($date, 0, $this->currencyCode);
        }

        $this->cashflows[$date] = $this->cashflows[$date]->add($cashflow);
    }
}