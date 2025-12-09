<?php


namespace frontend\tests\Unit;

use frontend\models\Calculadora;
use frontend\tests\UnitTester;
use SebastianBergmann\Complexity\Calculator;

class CalculatorTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {

    }

    // tests
    public function testSum()
    {
        $result = Calculadora::sum(2,3);
        $this->assertEquals(5, $result, "The result should be 5");
    }



}
