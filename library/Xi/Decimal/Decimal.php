<?php
namespace Xi\Decimal;

/**
 * An immutable fixed-point decimal number.
 * 
 * All arithmetic operations on the number return the result as a new instance.
 * The scale of the new instance is the maximum of the scale of the operands
 * i.e. the scale of `Decimal::create('3.45', 2)->plus('0.12345')` would be 5.
 * You can override this by giving the desired scale as a second parameter
 * to operations.
 */
class Decimal
{
    protected $amt;
    protected $scale;
    
    public function __construct($amount, $scale)
    {
        $this->amt = $this->asNormalizedString($amount, (int)$scale);
        $this->scale = (int)$scale;
    }
    
    /**
     * @return Decimal
     */
    public static function create($amount, $scale)
    {
        return new static($amount, $scale);
    }
    
    protected function asNormalizedString($value, $scale = null)
    {
        $scale = $scale ?: $this->scale;
        return bcadd($value, '0', $scale);
    }
    
    public function getAmt()
    {
        return $this->amt;
    }

    public function getScale()
    {
        return $this->scale;
    }
    
    public function isPositive()
    {
        return !$this->isNegative();
    }
    
    public function isNegative()
    {
        return $this->amt[0] == '-';
    }
    
    /**
     * Returns a negated value.
     * 
     * @return Decimal
     */
    public function negate()
    {
        if ($this->isNegative()) {
            return new static(substr($this->amt, 1), $this->scale);
        } else {
            return new static('-' . $this->amt, $this->scale);
        }
    }
    
    /**
     * Returns the absolute value.
     * 
     * @return Decimal
     */
    public function abs()
    {
        if ($this->isNegative()) {
            return $this->negate();
        } else {
            return $this;
        }
    }

    /**
     * Performs addition with an integer, float, string or Decimal.
     * 
     * @param int|float|string|Decimal $that What to add.
     * @return Decimal
     */
    public function plus($that, $scale = null)
    {
        return $this->doOp($that, $scale, 'bcadd');
    }
    
    /**
     * Performs subtraction with an integer, float, string or Decimal.
     * 
     * @param int|float|string|Decimal $that What to subtract.
     * @return Decimal
     */
    public function minus($that, $scale = null)
    {
        return $this->doOp($that, $scale, 'bcsub');
    }
    
    /**
     * Performs multiplication with an integer, float, string or Decimal.
     * 
     * @param int|float|string|Decimal $that What to multiply with.
     * @return Decimal
     */
    public function times($that, $scale = null)
    {
        return $this->doOp($that, $scale, 'bcmul');
    }
        
    /**
     * Performs division with an integer, float, string or Decimal.
     * 
     * @param int|float|string|Decimal $that What to divide with.
     * @return Decimal
     */
    public function div($that, $scale = null)
    {
        return $this->doOp($that, $scale, 'bcdiv');
    }
    
    protected function doOp($that, $scale, $op)
    {
        $scale = $scale ?: self::maxScale($this, $that);
        $result = $op((string)$this, (string)$that, $scale);
        return new static($result, $scale);
    }
    
    /**
     * Compares the value with an integer, float, string or Decimal.
     * 
     * Like Java's `compareTo()`, returns
     * 0 if `$this == $that`, -1 if `$this < $that` and 1 if `$this > $that`.
     * 
     * @return int 0 if $this is equal to, -1 if less than or 1 if greater than $that.
     */
    public function compareTo($that)
    {
        $scale = $this->maxScale($this, $that);
        return bccomp($this->asNormalizedString($this->amt, $scale), $this->asNormalizedString($that, $scale), $scale);
    }
    
    /**
     * Checks (loose) equality with an integer, float, string or Decimal.
     * 
     * @param int|float|string|Decimal $that What to compare to.
     * @return Decimal
     */
    public function equals($that)
    {
        return $this->compareTo($that) === 0;
    }
    
    public function lessThan($that)
    {
        return $this->compareTo($that) < 0;
    }
    
    public function lessThanOrEqual($that)
    {
        return $this->compareTo($that) <= 0;
    }
    
    public function greaterThan($that)
    {
        return $this->compareTo($that) > 0;
    }
    
    public function greaterThanOrEqual($that)
    {
        return $this->compareTo($that) >= 0;
    }
    
    protected static function maxScale($a, $b)
    {
        return max(self::scaleOf($a), self::scaleOf($b));
    }
    
    protected static function scaleOf($x)
    {
        $s = (string)$x;
        $i = strrpos($s, '.');
        if ($i === false) {
            return 0;
        } else {
            return strlen($s) - $i - 1;
        }
    }
    
    /**
     * Returns a string of the number with full precision.
     * 
     * This is a prettier alias to __toString().
     * 
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
    
    /**
     * Returns a string of the number with full precision.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->amt;
    }
}