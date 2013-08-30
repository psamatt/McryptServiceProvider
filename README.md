# Mcrypt Service Provider

A simple wrapper of the PHP [Mcrypt](http://www.php.net/manual/en/book.mcrypt.php) library  for [Silex](http://silex.sensiolabs.org)
## Usage

Register the service provider and specify your unique key.

    $app->register(new Psamatt\Silex\Provider\McryptServiceProvider('unique_key', array(
            'cipher' => MCRYPT_RIJNDAEL_256, // optional
            'mode' => MCRYPT_MODE_ECB, // optional
            'iv_source' => MCRYPT_RAND, // optional
            'base64' => true|false, // optional. Default is true
        )));
    
Then in your Silex application, you can use the Mcrypt provider with the following lines:

```
$data = 'my string';
$encryptedKey = $app['mcrypt']->encrypt($data);

print $app['mcrypt']->decrypt($encryptedKey); // prints 'my string'
```

For more information on what values to use for Mcrypt, view the documentation on each specific type:

- [Cipher](http://php.net/manual/en/mcrypt.ciphers.php)
- [Mode](http://php.net/manual/en/mcrypt.constants.php)
- [IV Source](http://php.net/manual/en/function.mcrypt-create-iv.php)

By default, the encrypted string will use base 64 encoding and decoding, to set this for your application, set the base64 option to `true` or `false`.