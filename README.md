# Implementation like Enum with PHP

# Table of Contents

* [Why](#why)
* [Requirements](#requirements)
* [Install](#install)
* [Usage](#usage)
* [Tips](#tips)
* [Examples](#examples)

# Why

I created this library to allow Enum to be used in many situations.

This library has the following advantages:
* Multiple values can be declared per enumerator
* You can declare Enum from various data sources, such as class constant, DB, or configuration file

# Requirements

* PHP ^7.4

# Install

```shell script
composer require ynkt/enum
```

# Usage

```Enum``` is an abstract class needs to be extended to use.

## Basic Declaration

The following code uses class constant for the declaring Enum. 
**Note: Use protected visibility when writing the ```__constructor()```.**

```php
use Ynkt\Enum\Enum;

/**
 * Class Status
 */
class Status extends Enum
{
    private const READY = 'Ready';
    private const IN_PROGRESS = 'In Progress';
    private const DONE = 'Done';

    private string $text;

    // The argument of __constructor() is automatically assigned to the value of the enumerator
    protected function __construct(string $text) { $this->text = $text; }

    public function text(): string { return $this->text; }
}
```

## Static methods

```php
// Provided by this library
Status::values(); // Returns instances of the Enum class of all Enumerators
Status::first(); // Returns the first instance
Status::first(callable $closure); // Returns the first instance that passes a given truth
Status::has(callable $closure); // Tests an instance exists that passes a given truth

// Provided by the user declaration
// This library automatically provide the static method whose name is same of the enumerators name.
// The following methods return an Enum instance.
Status::READY();
Status::IN_PROGRESS();
Status::DONE();
```

Static methods that has the same name as the enumerator name are implemented by ```__callStatic()```.
Therefore, if you care about the IDE auto completion, I recommend using the phpdoc as follows:
**Note: Do not declare the static methods that has the same name as the enumerator name.**

```php
/**
 * Class Status
 * 
 * @method static self READY()
 * @method static self IN_PROGRESS()
 * @method static self DONE()
 */
class Status extends Enum
{
    private const READY = 'Ready';
    private const IN_PROGRESS = 'In Progress';
    private const DONE = 'Done';

    // ...
}
```

## Instance methods

```php
$status = Status::READY();

// Provided by this library
$status->name(); // Returns the name of the current enumerator (e.g.:'READY')
$status->ordinal(); // Returns the ordinal of the current enumerator (e.g.:0)
$status->declaringClass(); // Returns the declaring class of the current enumerator (e.g.:'Status')
$status->equals(Status::Ready()); // Tests enum instances are equal (e.g.:true)

// Provided by the user declaration
$status->text(); // Returns 'Ready'
```

## Type hint

You can use classes that inherit from Enum for type hints.

```php
function updateStatus(Status $status){
  // ...
}

updateStatus(Status::READY());
```

## How to declare the multiple values per enumerator

If you want to declare the multiple values per enumerator, you can assign an array.

```php
class Color extends Enum
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    // The argument of __constructor() is automatically assigned to the value of the enumerator
    protected function __construct(string $code, array $rgb) {}

    // ...
}
```

## How to declare the Enum from various data sources

If you want to declare an Enum based on data that is not a class constant,
you can overwrite ```getConstants()```.
If ```getConstants()``` returns an associative array, it is the same of the declaring the class constants.

The following two ways of declaration are equivalent.

```php
class ColorFromDataSource extends Enum
{
    /**
     * @overwrite
     */
    protected static function getConstants(string $class): array
    {
        return [
            'RED'   => ['#FF0000', [255, 0, 0]],
            'BLUE'  => ['#0000FF', [0, 0, 255]],
            'BLACK' => ['#000000', [0, 0, 0]],
        ];
    }

    // ...
}
```

```php
class Color extends Enum
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    // ...
}
```

# Tips

## If you want to get an instance by Identifier or something

Using an identifier as a way to get an instance is a common pattern.
So, as a way to achieve this, I have prepared sample code to get an instance based on the ID.
You can use it simply by writing ```use ByIdTrait;``` when declaring Enum.

```php
class DayOfWeek extends Enum
{
    use ByIdTrait;

    private const MONDAY = 1;
    private const TUESDAY = 2;

    private int $id;   

    public function id(): int { return $this->id; }

    // ...
}

// You can use byId() to get the Enum instance.
$dayOfWeek = DayOfWeek::byId(1);
$dayOfWeek->equals(DayOfWeek::MONDAY()); // Returns true
```

I think the implementation of the ```ByIdTrait``` will be helpful when you get an instance based on some identifiers.

# Examples

https://github.com/ynkt/enum/tree/master/tests/Fixtures
