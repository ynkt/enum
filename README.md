# Implementation like Enum with PHP

# Table of Contents

* [Why](#why)
* [Requirements](#requirements)
* [Install](#install)
* [Usage](#usage)
* [Tips](#tips)
* [Examples](#examples)

# Why

I created this library for simplify describing the behavior of enumerators and using Enum in many situations.

This library has the following advantages:

* Multiple values can be declared per enumerator
* Enumerators can be declared from various data sources, such as class constant, DB, or configuration file

# Requirements

* PHP ^7.4

# Install

```shell script
composer require ynkt/enum
```

# Usage

```Enum``` is an abstract class that needs to be extended to use.

## Basic Declaration

The following code uses class constant for the declaring enumerators. 

* The name of the enumerators is automatically used as the name of the static method.
* The value of the enumerators is automatically passed as an argument to the ```__constructor()```.
* **Note: Use protected visibility when writing the ```__constructor()```.**

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

    protected function __construct(string $text) { $this->text = $text; }

    public function text(): string { return $this->text; }
}
```

## Static methods

```php
// Provided by this library
Status::values(); // Returns instances of the Enum class of all Enumerators
Status::first(); // Returns the first instance
Status::first(fn(Status $status) => $status->text() === 'Ready'); // Returns the first instance that passes a given truth
Status::has(fn(Status $status) => $status->text() === 'Done'); // Tests an instance exists that passes a given truth (e.g.:true)

// Provided by the above declaration
Status::READY(); // Returns an instance that 'Ready' was passed as an argument to the constructor
Status::IN_PROGRESS(); // Returns an instance that 'In Progress' was passed as an argument to the constructor
Status::DONE(); // Returns an instance that 'Done' was passed as an argument to the constructor
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

// Provided by the above declaration
$status->text(); // Returns 'Ready'
```

## Type hint

```php
function updateStatus(Status $status){
  // ...
}

updateStatus(Status::READY());
```

## How to declare the multiple values per enumerator

You can assign an array per enumerator.
And, the elements of the assigned array are automatically passed to the ```__constructor()```.

```php
class Color extends Enum
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    protected function __construct(string $code, array $rgb) {}

    // ...
}
```

## How to declare the enumerators from various data sources

You can use Enum without using class constants by overwriting ```getConstants()```.

```getConstants()``` returns an associative array, and keys of it are used as the name of the enumerator.

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

$dayOfWeek = DayOfWeek::byId(1);
$dayOfWeek->equals(DayOfWeek::MONDAY()); // Returns true
```

I think the implementation of the ```ByIdTrait``` will be helpful when you get an instance based on some identifiers other than ID.

# Examples

https://github.com/ynkt/enum/tree/master/tests/Fixtures
