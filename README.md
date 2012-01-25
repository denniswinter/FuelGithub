# FuelGithub - ZF2 module for easy access of Github's API

## Introduction


## Requirements

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

## Features

* Provide an access point to the REST webservice of Github [DONE]
* Provide Basic Authentication to Github [DONE]
* Provide OAuth2 Authentication to Github [TODO]

## Installation

### Main Setup

1. Clone this project into your `/vendor/` folder and enable it in your
`application.config.php` file.
2. Copy `./vendor/FuelGithub/config/module.fuelgithub.config.php.dist` to
`./config/autoload/module.fuelgithub.config.php`.
3. Change the values of `password` and `username` to your Github credentials

### Test Setup

1. Make sure you've got the latest version of PHPUnit installed.
2. Make sure ZF2 is in your `include_path`
3. Copy `./test/bootstrap.php.dist` to `./test/bootstrap.php`.
4. The value of the constant `FUEL_GITHUB_ONLINE_TESTS_ENABLED` determines,
if tests are run on the online service, or from cached files
(NOTE: THE CACHED FILES ARE NOT PROVIDED, THEY ARE CREATED ON THE FLY WHEN
RUNNING THE TESTSUITE WITH ONLINE TESTS ENABLED).

## Options

The FuelGithub module has some options to allow you to quickly customize the basic
functionality. After installing FuelGithub, copy
`./vendor/FuelGithub/config/module.fuelgithub.config.php` to
`./config/autoload/module.config.php` and change the values as desired.

- **username** - Your Github username
- **password** - Your Github password
- **auth_conf** - Value may be one of `HTTP_BASIC` or `OAUTH2`.
(NOTE THAT OAUTH2 IS NOT SUPPORTED AT THE MOMENT)