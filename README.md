# Laravel Rest Helper

## Introduction

This library is developed to help the development of rest API using laravel easy and simple.

## How to install

Install using composer

```
composer require denniskemboi/laravel-rest-helper

```

## Add it to your api controllers

```php
// import the helper
use  Denniskemboi\LaravelRestHelper\Controllers\ApiController;

// then extend it from your controller
class PostController extends ApiController
{
    ...
}
```

## add it to your models

```php
// import the helper
use  Denniskemboi\LaravelRestHelper\Models\ApiModel;

// then extend it from your model
class Post extends ApiModel
{
    ...
}
```