# Implementation like Enum with PHP

# Table of Contents

* Enum with PHP
* Why
* Requirements
* Install
* Usage
* Examples

# Enum with PHP

Enumはコーディングに当たってとても便利な概念であることは言うまでもありません。

引数のタイプヒントに利用する場合や、そのEnumの対象に関わる処理を分離する場合など、動作を安定させたり、コードの質を高めることができます。

ただし、PHPではEnumが標準でサポートされていないため、ライブラリを利用するか、スクラッチで開発する必要があります。

# Why

このライブラリを作った理由は、現時点で公開されている代表的なEnumのライブラリ群が個人的に使い辛かったためです。

(定数を使うことでしか列挙できない要素群、public修飾子を使わざるをえない定数宣言、定義値を1つしか記述できないなど)

本ライブラリは、直観的に利用でき、且つコーディングの量を抑えつつ、多くの場面でEnumを利用してもらうことを目的に作成しました。

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
