<?php
namespace Xi\Decimal;

class DecimalComparisonTest extends TestCase
{
    public function testEqualityWithIntegers()
    {
        $a = Decimal::create(15, 0);
        $b = Decimal::create(15, 2);
        $c = Decimal::create('15.55', 2);
        
        $this->assertDecimalEquals($a, 15);
        $this->assertDecimalEquals($b, 15);
        $this->assertDecimalNotEquals($c, 15);
        $this->assertDecimalNotEquals($a, 14);
        $this->assertDecimalNotEquals($b, 14);
        $this->assertDecimalNotEquals($c, 14);
    }
    
    public function testEqualityWithStrings()
    {
        $a = Decimal::create(15, 0);
        $b = Decimal::create(15, 2);
        $c = Decimal::create('15.55', 2);
        
        $this->assertDecimalEquals($a, '15');
        $this->assertDecimalEquals($b, '15');
        $this->assertDecimalNotEquals($c, '15');
        $this->assertDecimalEquals($a, '15.0');
        $this->assertDecimalEquals($b, '15.0');
        $this->assertDecimalEquals($c, '15.55');
        $this->assertDecimalEquals($a->negate(), '-15.0');
        $this->assertDecimalEquals($b->negate(), '-15.0');
        $this->assertDecimalEquals($c->negate(), '-15.55');
        $this->assertDecimalNotEquals($a, '14');
        $this->assertDecimalNotEquals($b, '14');
        $this->assertDecimalNotEquals($c, '14');
        
        $this->assertDecimalEquals($a, '15.00000');
        $this->assertDecimalEquals($b, '15');
        $this->assertDecimalEquals($c, '15.55');
        
        $this->assertDecimalEquals($c, '15.55000');
    }
    
    public function testEqualityWithOtherDecimals()
    {
        $a = Decimal::create(15, 0);
        $b = Decimal::create(15, 1);
        $c = Decimal::create('15.55', 2);
        
        $this->assertDecimalEquals($a, $b);
        $this->assertDecimalNotEquals($a, $c);
        $this->assertDecimalNotEquals($b, $c);
        
        $this->assertDecimalEquals($a, $a);
        $this->assertDecimalEquals($b, $b);
        $this->assertDecimalEquals($c, $c);
    }
    
    public function testComparison()
    {
        $this->assertSame(-1, Decimal::create('1.2', 1)->compareTo(Decimal::create('1.21', 2)));
        $this->assertSame(0, Decimal::create('1.21', 2)->compareTo(Decimal::create('1.21', 2)));
        $this->assertSame(1, Decimal::create('1.21', 2)->compareTo(Decimal::create('1.2', 1)));
    }
}