# Unfurl links in PHP

This package unwraps urls like t.co or bit.ly to actual destination urls by doing an HTTP requests and remembering the redirect chain.


## Installation

You can install the package via composer:

```bash
composer require exfriend/unfurl
```

## Usage

Get the whole chain:
``` php
unfurl('http://google.com')->all();
// will return [ 'https://google.com', 'https://www.google.com' ];
```

Get the final destination:
``` php
unfurl('http://google.com')->last();
// will return 'https://www.google.com';
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Serpentine.io - The missing Google Search API](https://serpentine.io)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
