# Implementation like Enum with PHP

# Table of Contents

* [Why](#why)
* [Requirements](#requirements)
* [Install](#install)
* [Usage](#usage)
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

## Basic Declaration

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
Status::values(); // Array of Status Enum instances

// Provided by the above declaration
Status::READY(); // Instance created with 'Ready'
Status::IN_PROGRESS(); // Instance created with 'In Progress'
Status::DONE(); // Instance created with 'Done'
```

Static method helpers are implemented using ```__callStatic()```.

If you care about IDE auto completion, you can use phpdoc.

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
$status->name(); // 'READY'
$status->ordinal(); // 0
$status->declaringClass(); // 'Status'
$status->equals(Status::Ready()); // true

// Provided by the above declaration
$status->text(); // 'Ready'
```

## Type hint

```php
function updateStatus(Status $status){
  // ...
}
```

## Advanced Declaration

### Multiple definition values

```php
class Color extends EnumLike
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    protected function __construct(string $code, array $rgb) {}
```

### Except using class constant

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

### Get instance by Identifier

```php
class DayOfWeek extends EnumLike
{
    use ByIdTrait;

    private const MONDAY = 1;
    private const TUESDAY = 2;
}

$dayOfWeek = DayOfWeek::byId(1);
$dayOfWeek->equals(DayOfWeek::MONDAY()); // true
```

# Note

* Use the protected modifier for ```__constructor```
* Do not manually declare a static method with the same name that uses to get an instance.

# Examples

https://github.com/ynkt/enum-like/tree/master/tests/Fixtures
