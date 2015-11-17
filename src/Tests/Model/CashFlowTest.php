<?php

namespace MonoidPoc\Tests;

use MonoidPoc\Model\CashFlow;

class CashFlowTest extends \PHPUnit_Framework_TestCase
{
    /***************/
    /* ->add tests */
    /***************/

    public function testAddWorksOk()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-01', 30, 'EUR');

        $expected = new CashFlow('2015-01-01', 55, 'EUR');
        $returned = $cashflow1->add($cashflow2);

        $this->assertTrue($expected->isEqualTo($returned));
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedDateException
     */
    public function testAddRaiseExceptionIfDatesAreNotTheSame()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-02', 30, 'EUR');

        $cashflow1->add($cashflow2);
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testAddRaiseExceptionIfCurrenciesAreNotTheSame()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-01', 30, 'USD');

        $cashflow1->add($cashflow2);
    }

    /***********************/
    /* ->isEqualTo() tests */
    /***********************/

    public function testIsEqualToReturnTrueIfOk()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-01', 25, 'EUR');

        $this->assertTrue($cashflow1->isEqualTo($cashflow2));
        $this->assertTrue($cashflow2->isEqualTo($cashflow1));
    }

    public function testIsEqualToReturnTrueIfNok()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-01', 35, 'EUR');

        $this->assertFalse($cashflow1->isEqualTo($cashflow2));
        $this->assertFalse($cashflow2->isEqualTo($cashflow1));
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedDateException
     */
    public function testIsEqualToRaiseExceptionIfDatesAreNotTheSame()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-02', 25, 'EUR');

        $cashflow1->isEqualTo($cashflow2);
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testIsEqualToRaiseExceptionIfCurrenciesAreNotTheSame()
    {
        $cashflow1 = new CashFlow('2015-01-01', 25, 'EUR');
        $cashflow2 = new CashFlow('2015-01-01', 25, 'USD');

        $cashflow1->isEqualTo($cashflow2);
    }
}