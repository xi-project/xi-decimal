<?php
namespace Xi\Decimal;

class DecimalArithmeticTest extends TestCase
{
    public function testConstructionFromIntegers()
    {
        $x = Decimal::create(123, 10);
        $this->assertEquals('123.0000000000', $x->toString());
    }
    
    public function testConstructionFromStrings()
    {
        $x = Decimal::create('123', 10);
        $this->assertEquals('123.0000000000', $x->toString());
        
        $x = Decimal::create('123.000', 10);
        $this->assertEquals('123.0000000000', $x->toString());
        
        $x = Decimal::create('123.0000000000000000001', 10);
        $this->assertEquals('123.0000000000', $x->toString());
    }
    
    public function testConstructionFromOtherDecimals()
    {
        $x = Decimal::create('123.45', 2);
        $y = Decimal::create($x, 1);
        $this->assertEquals('123.4', $y->toString());
    }
    
    public function testAdditionWithIntegers()
    {
        $result = Decimal::create(2, 0)->plus(2);
        $this->assertDecimalEquals($result, 4);
    }
    
    public function testAdditionWithStrings()
    {
        $result = Decimal::create('100.20', 2)->plus('3.3');
        $this->assertDecimalEquals($result, '103.50');
    }
    
    public function testAdditionWithDecimals()
    {
        $result = Decimal::create('2.88', 2)->plus(Decimal::create('4.11111', 5));
        $this->assertDecimalEquals($result, '6.99111');
    }
    
    public function testSubtractionWithIntegers()
    {
        $result = Decimal::create(7, 0)->minus(2);
        $this->assertDecimalEquals($result, 5);
    }
    
    public function testSubtractionWithStrings()
    {
        $result = Decimal::create('100.20', 2)->minus('3.3');
        $this->assertDecimalEquals($result, '96.90');
    }
    
    public function testSubtractionWithDecimals()
    {
        $result = Decimal::create('2.88', 2)->minus(Decimal::create('1.11111', 5));
        $this->assertDecimalEquals($result, '1.76889');
    }
    
    public function testMultiplicationWithIntegers()
    {
        $result = Decimal::create(7, 0)->times(3);
        $this->assertDecimalEquals($result, 21);
    }
    
    public function testMultiplicationWithStrings()
    {
        $result = Decimal::create('100.20', 2)->times('0.5');
        $this->assertDecimalEquals($result, '50.10');
    }
    
    public function testMultiplicationWithDecimals()
    {
        $result = Decimal::create('20.40', 2)->times(Decimal::create('2.5', 5));
        $this->assertDecimalEquals($result, '51.00');
    }
    
    public function testDivisionWithIntegers()
    {
        $result = Decimal::create(7, 2)->div(3);
        $this->assertDecimalEquals($result, '2.33');
    }
    
    public function testDivisionWithStrings()
    {
        $result = Decimal::create('100.20', 2)->div('0.5');
        $this->assertDecimalEquals($result, '200.40');
    }
    
    public function testDivisionWithDecimals()
    {
        $result = Decimal::create('10.', 2)->div(Decimal::create('9', 5));
        $this->assertDecimalEquals($result, '1.11111');
    }
    
    public function testNegate()
    {
        $a = Decimal::create('1.234', 4);
        $this->assertDecimalEquals($a->negate(), '-1.234');
        $this->assertDecimalEquals($a->negate()->negate(), '1.234');
    }
    
    public function testAbs()
    {
        $a = Decimal::create('1.234', 4);
        $this->assertTrue($a->isPositive());
        $this->assertFalse($a->isNegative());
        $this->assertTrue($a->abs()->isPositive());
        $this->assertDecimalEquals($a->abs(), $a);
        
        $b = Decimal::create('-1.234', 4);
        $this->assertFalse($b->isPositive());
        $this->assertTrue($b->isNegative());
        $this->assertTrue($b->abs()->isPositive());
        $this->assertDecimalEquals($b->abs(), $a);
    }
    
}