# IntegerNet_ProductSaleAttribute Magento Module
<div align="center">

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
![Supported Magento Versions][ico-compatibility]
</div>

---

Create an "is_sale" product attribute and update it automatically from the price attributes

## Installation

1. Install it into your Magento 2 project with composer:
    ```
    composer require integer-net/magento2-product-sale-attribute
    ```

2. Enable module
    ```
    bin/magento setup:upgrade
    ```

## Configuration

You can disable auto generation in `Store -> Configuration -> Catalog -> Product "Is Sale" Attribute -> Will be updated automatically every night` per Store View.

## Usage

A sale product attribute "Is Sale" (`is_sale`) will be created upon installation of this module.
A cronjob is running every night at 00:01 and regenerates the value of this attribute for each 
product, depending on the content of the price attributes (`price` and `special_price`) and catalog price rules.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email avs@integer-net.de instead of using the issue tracker.

## Credits

- [Andreas von Studnitz][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/integer-net/magento2-product-is-sale-attribute.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-compatibility]: https://img.shields.io/badge/magento-2.3%20|%202.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square

[link-packagist]: https://packagist.org/packages/integer-net/magento2-product-sale-attribute
[link-author]: https://github.com/avstudnitz
[link-contributors]: ../../contributors
