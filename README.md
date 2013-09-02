# Mcrypt Service Provider

[![Build Status](https://api.travis-ci.org/psamatt/McryptServiceProvider.png?branch=master)](https://api.travis-ci.org/psamatt/McryptServiceProvider)

A simple wrapper of the PHP [Mcrypt](http://www.php.net/manual/en/book.mcrypt.php) library  for [Silex](http://silex.sensiolabs.org)
## Usage

Register the service provider and specify your unique key.
```php
$app->register(new Psamatt\Silex\Provider\McryptServiceProvider('unique_key', array(
        'cipher' => MCRYPT_RIJNDAEL_256, // optional
        'mode' => MCRYPT_MODE_CBC, // optional
        'iv_source' => MCRYPT_DEV_RANDOM, // optional
        'base64' => true|false, // optional. Default is true
        'auto_generate_iv' => true|false, // option. Default is false
    )));

Please note that you must explicitly generate the IV if you leave `auto_generate_iv` to `false`, you can do this by the following:
```php
$app['mcrypt']->generateIv();
```
    
In your Silex application, you can use the Mcrypt provider with the following lines:

```php
$data = 'my string';
$encryptedKey = $app['mcrypt']->encrypt($data);

print $app['mcrypt']->decrypt($encryptedKey); // prints 'my string'
```

If you'd like to use mcrypt in your Twig templates*, you can using either the `mcrypt_encrypt` or the `mcrypt_decrypt` filter:

```php
{{ object.method | mcrypt_encrypt }} // encrypt
{{ object.method | mcrypt_decrypt }} // decrypt 
```

\* ensure you define the `McryptServiceProvider` after your Twig Service Provider to utilise the Twig feature

### Other useful information
If you require to decrypt a mcrypt encrypted string and are not using MCRYPT_MODE_ECB *(recommended)*, you must initially get the IV before you've encrypted your string using `$app['mcrypt']->getIv()` and store this safely, then when you are ready to decrypt, you must set the same IV using `$app['mcrypt']->setIv($my_iv)`, view the [unit test](http://github.com/psamatt/McryptServiceProvider/blob/master/tests/Psamatt/Silex/Provider/Tests/Mcrypt/McryptTest.php#L68) for further clarification.

## Mcrypt Documentation

For more information on what values to use for Mcrypt, view the documentation on each specific type:

- [Cipher](http://php.net/manual/en/mcrypt.ciphers.php)
- [Mode](http://php.net/manual/en/mcrypt.constants.php)
- [IV Source](http://php.net/manual/en/function.mcrypt-create-iv.php)

By default, the encrypted string will use base 64 encoding and decoding, to set this for your application, set the base64 option to `true` or `false`.