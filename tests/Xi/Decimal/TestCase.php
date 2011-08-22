<?php
namespace Xi\Decimal;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function assertDecimalEquals($a, $b)
    {
        $cases = 0;
        if ($a instanceof Decimal) {
            $this->assertTrue($a->equals($b), "$a == $b");
            $cases++;
        }
        if ($b instanceof Decimal) {
            $this->assertTrue($b->equals($a), "$a == $b");
            $cases++;
        }
        if (!$cases) {
            throw new \Exception("assertDecimalEquals called without a Decimal");
        }
    }
    
    protected function assertDecimalNotEquals($a, $b) 
    {
        $cases = 0;
        if ($a instanceof Decimal) {
            $this->assertFalse($a->equals($b), "$a == $b");
            $cases++;
        }
        if ($b instanceof Decimal) {
            $this->assertFalse($b->equals($a), "$a == $b");
            $cases++;
        }
        if (!$cases) {
            throw new \Exception("assertDecimalNotEquals called without a Decimal");
        }
    }
}
