# Implementation like Enum with PHP

# Table of Contents

* [Why](#why)
* [Requirements](#requirements)
* [Install](#install)
* [Usage](#usage)
* [Tips](#tips)
* [Examples](#examples)

# Why

I created this library to make it easier to describe the behavior of enumerators and make them available in more situations than the existing Enum library.

This library has the following advantages:

* Multiple values can be declared for each enumerator
* Enumerators can be declared from various data sources, such as class constant, DB, or configuration file

# Requirements

* PHP ^7.2

# Install

```shell script
composer require ynkt/enum-like
```

# Usage

```EnumLike``` is an abstract class that needs to be extended to use.

* You must use protected or public visibility when writing the ```__constructor()```.
* Do not manually declare the static methods with the same name as the enumerator name.

## Basic Declaration

The following code is an example of declaring enumerators using class constants.

* The name of the enumerators is automatically used as the name of the static method.
* The value of the enumerators is automatically passed as an argument to the ```constructor()```.

```php
use Ynkt\EnumLike\EnumLike;

/**
 * Class Status
 */
class Status extends EnumLike
{
    private const READY = 'Ready';
    private const IN_PROGRESS = 'In Progress';
    private const DONE = 'Done';

    /** * @var string */
    private $text;

    protected function __construct(string $text) { $this->text = $text; }

    public function text(): string { return $this->text; }
}
```

## Static methods

```php
// Automatically prepared by library
Status::values(); // Returns instances of the Enum class of all Enum constants

// Provided by the above declaration
Status::READY(); // Returns an instance that 'Ready' was passed as an argument to the constructor
Status::IN_PROGRESS(); // Returns an instance that 'In Progress' was passed as an argument to the constructor
Status::DONE(); // Returns an instance that 'Done' was passed as an argument to the constructor
```

Static methods for getting an enumeration instance are implemented by ```__callStatic()```.

Therefore, if you care about IDE auto completion, I recommend using phpdoc as follows:

```php
/**
 * Class Status
 * 
 * @method static self READY()
 * @method static self IN_PROGRESS()
 * @method static self DONE()
 */
class Status extends EnumLike
{
    private const READY = 'Ready';
    private const IN_PROGRESS = 'In Progress';
    private const DONE = 'Done';
}
```

## Instance methods

```php
$status = Status::READY();

// Automatically prepared by library
$status->name(); // Returns the name of the current enumerator. In this case returns 'READY'
$status->ordinal(); // Returns the ordinal of the current enumerator. In this case returns 0
$status->declaringClass(); // Returns the declaring class of the current enumerator. In this case returns 'Status'
$status->equals(Status::Ready()); // Tests enum instances are equal. In this case returns true

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

## Declare multiple values for each enumerator

You can assign an array to the enumerator definitions.
Also, its values are automatically passed to the constructor as a variable length arguments.

```php
class Color extends EnumLike
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    protected function __construct(string $code, array $rgb) {}
}
```

## Declare enumerators from data sources except class constant

You can use Enum without using class constants by overwriting ```getConstants()```.

```getConstants()``` returns an associative array of the enumerations, and its keys are used as the enumerators name.

The following two ways of declaration are equivalent.

```php
class RepositoryColor extends EnumLike
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
}
```

```php
class Color extends EnumLike
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];
}
```

# Tips

## If you want to get instance by Identifier or something

Using an identifier as a way to get an instance is a common pattern.
So, as a way to achieve this, I have prepared sample code to get an instance based on the ID.
You can use it simply by writing ```use ByIdTrait;``` when declaring Enum.

```php
class DayOfWeek extends EnumLike
{
    use ByIdTrait;

    private const MONDAY = 1;
    private const TUESDAY = 2;

    private $id;   

    public function id(): int { return $this->id; }
    // ...
}

$dayOfWeek = DayOfWeek::byId(1);
$dayOfWeek->equals(DayOfWeek::MONDAY()); // Returns true
```

I think the implementation of ```ByIdTrait``` will be helpful when you get an instance based on some identifiers other than ID.

# Examples

https://github.com/ynkt/enum-like/tree/master/tests/Fixtures
