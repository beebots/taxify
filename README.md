# ZayconTaxify

[![Latest Stable Version](https://poser.pugx.org/zaycon/taxify/v/stable)](https://packagist.org/packages/zaycon/taxify)
[![Total Downloads](https://poser.pugx.org/zaycon/taxify/downloads)](https://packagist.org/packages/zaycon/taxify)
[![Build Status](https://travis-ci.org/ZayconFoods/taxify.svg?branch=master)](https://travis-ci.org/ZayconFoods/taxify)
[![Coverage Status](https://coveralls.io/repos/ZayconFoods/taxify/badge.svg?branch=master&service=github)](https://coveralls.io/github/ZayconFoods/taxify?branch=master)

Connect your website with the [Taxify] API

## Table of Contents

* [Notes](#notes)
* [Installation](#install)
* [Documentation](#documentation)
* [About](#about)

## <a name="notes"></a> Fork Notes

It looked like the original [ZayconTaxify] library was abandoned a few years ago
at the time of writing this. We needed to support [Taxify] in a project, and it
has been an adventure. The biggest challenge has been adequate documentation
for the Taxify API itself.

This fork/alternative is derived from the original source of [ZayconTaxify] and
differs enough to be its own implementation now. I've bumped the version to 2.0
to prevent any accidental installs of this package.

Major changes:

  * Support PHP >= 7.1.
  
  * Support PSR-4 autoloading.
  
  * Upgrade PHPUnit to v6 for development
  
  * Decoupled the common "request" object into individual requests:
  
    - `VerifyAddress`
    - `CalculateTax`
    - `CommitTaxRequest`
    - `CancelTaxRequest`
    - `GetCodesRequest`
  
  * Decoupled the common "response" object into individual responses:
  
    - `VerifyAddressResponse`
    - `CalculateTax`
    - `CommitTaxResponse`
    - `CancelTaxResponse`
    - `GetCodesResponse`

  * Refactored to make better use of traits and type hinting

## <a name="install"></a>Installation

Add `rk/taxify` to your `composer.json` file. (We're not currently published to
packagist.)

```json
{
  "require": {
    "rk/taxify": "~2.0"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/rk/taxify"
    }
  ]
}
```

## <a name="documentation"></a>Documentation

**OUTDATED**

Please see tests for the most up-to-date usage. 

## <a name="about"></a>About

Originally developed by [Zaycon Fresh].

This version revised, refactored, and updated for PHP 7 by Robert Kosek. 
Development time and effort is a courtesy of [Wood Street].

  [Wood Street]: https://www.woodst.com/ 
  [ZayconTaxify]: https://packagist.org/packages/zaycon/taxify
  [Zaycon Fresh]: https://www.zayconfresh.com/
  [Taxify]: https://www.taxify.co/