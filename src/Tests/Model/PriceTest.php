<?php
namespace MonoidPoc\Tests;
use MonoidPoc\Model\Price;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    /*****************/
    /* ->add() tests */
    /*****************/

    public function testAddWorksOk()
    {
        $price1 = new Price(25, 'EUR');
        $price2 = new Price(30, 'EUR');

        $expected = new Price(55, 'EUR');
        $returned = $price1->add($price2);

        $this->assertTrue($expected->isEqualTo($returned));
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testAddRaisesExceptionIfNecessary()
    {
        $price1 = new Price(25, 'EUR');
        $price2 = new Price(30, 'USD');

        $price1->isEqualTo($price2);
    }


    /*****************/
    /* ->isEqualTo() */
    /*****************/

    public function testIsEqualToReturnTrue()
    {
        $price1 = new Price(25, 'EUR');
        $price2 = new Price(25, 'EUR');

        $this->assertTrue($price1->isEqualTo($price2));
    }

    public function testIsEqualToReturnFalse()
    {
        $price1 = new Price(25, 'EUR');
        $price2 = new Price(30, 'EUR');


        $this->assertFalse($price1->isEqualTo($price2));
    }

    /**
     * @expectedException \MonoidPoc\Exception\UnexpectedCurrencyException
     */
    public function testIsEqualToRaiseExceptionIfNecessary()
    {
        $price1 = new Price(25, 'EUR');
        $price2 = new Price(25, 'USD');

        $price1->isEqualTo($price2);
    }
}