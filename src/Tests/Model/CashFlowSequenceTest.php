<?php

namespace MonoidPoc\Tests;

use MonoidPoc\Model\CashFlow;
use MonoidPoc\Model\CashFlowSequence;

class CashFlowSequenceTest extends \PHPUnit_Framework_TestCase
{
    /******************/
    /* ->_construct() */
    /******************/

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testConstruct()
    {
        new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 20, 'USD'),
        ));
    }

    /***************/
    /* ->add tests */
    /***************/

    public function testAddWorksOk()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 20, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-02', 30, 'EUR'),
            array('2015-01-03', 40, 'EUR'),
        ));

        $expected = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-02', 30, 'EUR'),
            array('2015-01-03', 60, 'EUR'),
        ));

        $returned = $sequence1->add($sequence2);

        $this->assertTrue($expected->isEqualTo($returned));
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testAddRaisesExceptionWhenCurrencyDiffers()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-02', 30, 'USD'),
        ));

        $sequence1->add($sequence2);
    }

    /*********************/
    /* ->isEqualTo tests */
    /*********************/

    public function testIsEqualToReturnsTrueIfOk()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 20, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-03', 20, 'EUR'),
            array('2015-01-01', 10, 'EUR'),
        ));

        $this->assertTrue($sequence1->isEqualTo($sequence2));
        $this->assertTrue($sequence2->isEqualTo($sequence1));
    }

    public function testIsEqualToReturnsFalseIfAmountDiffers()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 20, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 21, 'EUR'),
        ));

        $this->assertFalse($sequence1->isEqualTo($sequence2));
        $this->assertFalse($sequence2->isEqualTo($sequence1));
    }

    public function testIsEqualToReturnsFalseIfDateDiffers()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-03', 20, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-02', 20, 'EUR'),
        ));

        $this->assertFalse($sequence1->isEqualTo($sequence2));
        $this->assertFalse($sequence2->isEqualTo($sequence1));
    }

    public function testIsEqualToReturnsFalseIfCurrencyDiffers()
    {
        $sequence1 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'EUR'),
            array('2015-01-02', 20, 'EUR'),
        ));

        $sequence2 = new CashFlowSequence(array(
            array('2015-01-01', 10, 'USD'),
            array('2015-01-02', 20, 'USD'),
        ));

        $this->assertFalse($sequence1->isEqualTo($sequence2));
        $this->assertFalse($sequence2->isEqualTo($sequence1));
    }
}