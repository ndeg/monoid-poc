<?php

namespace MonoidPoc\Tests;

use MonoidPoc\Model\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{
    public function testIsEqualToReturnTrue()
    {
        $currency1 = new Currency('EUR');
        $currency2 = new Currency('EUR');

        $this->assertTrue($currency1->isEqualTo($currency2));
        $this->assertTrue($currency2->isEqualTo($currency1));
    }

    public function testIsEqualToReturnFalse()
    {
        $currency1 = new Currency('EUR');
        $currency2 = new Currency('USD');

        $this->assertFalse($currency1->isEqualTo($currency2));
        $this->assertFalse($currency2->isEqualTo($currency1));
    }
}