# xi-decimal #

`Xi\Decimal\Decimal` is a fixed-point number class for PHP.

- It's immutable. All operations return a new instance.
- The number of decimals is explicitly specified.
- It uses [BCMath](http://php.net/manual/en/book.bc.php) internally.
- It's designed to be subclassable e.g. to make your own [Money](http://martinfowler.com/eaaCatalog/money.html) class.
