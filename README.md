# Image Analysis Microservice Using Laravel Lumen

Proof of concept RESTful microservice that returns analysis data for an image.

## Usage

* Post any valid image file to the root path
* Include Authorization header containing valid Bearer token
* Retrieve JSON data about selected image properties

## Example response

Values are derived from Image Magic image tools and relate to the image's histogram.

```json
{
     "min": {
         "z": "0"
     },
     "max": {
         "z": "255"
     },
     "mean": {
         "r": "99.428",
         "g": "116.548",
         "b": "116.206",
         "z": "110.727"
     },
     "kurtosis": {
         "z": "-0.354155"
     },
     "skewness": {
         "z": "0.461672"
     },
     "entropy": {
         "z": "0.821395"
     }
}
```

## Utilization

This microservice currently utilizes:
* Auth0 for authentication
* Guzzle HTTP client
* Image Magick
* Laravel's Lumen Framework


# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
