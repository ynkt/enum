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

本ライブラリでは、既存のライブラリに比べて、より直観的に利用でき、且つコーディングの量を抑えつつ、多くの場面でEnumを利用してもらうことを目的として作成しました。

以下の点において利点があります。

* 列挙項目の宣言が、定数による宣言以外にもDBや設定ファイルからの値取得でも可能
* private修飾子を利用して定数を宣言でき、IDEの補完機能を必要以上に汚染しない
* 1つの列挙項目につき、複数の定義値を宣言できる

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
