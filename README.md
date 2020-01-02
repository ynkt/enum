# Implementation like Enum with PHP

# Table of Contents

* Why
* Requirements
* Install
* Usage
* Examples

# Why

This library has been created to be more intuitive and to be used in more situations than the existing library.

It has the following advantages:

* Enumerators can be declared from various data sources, such as class constants, DB, or configuration files
* Private qualifier can use for constant declaration
* Multiple values can be declared for each enumerator

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
// Prepared methods
Status::values(); // Array of Status Enum instances

// Provided by the above declaration
Status::READY(); // Instance created with 'Ready'
Status::IN_PROGRESS(); // Instance created with 'In Progress'
Status::DONE(); // Instance created with 'Done'
```

## Instance methods

```php
$status = Status::READY();

// Prepared methods
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

# Examples

https://github.com/ynkt/enum-like/tree/master/tests/Fixtures
