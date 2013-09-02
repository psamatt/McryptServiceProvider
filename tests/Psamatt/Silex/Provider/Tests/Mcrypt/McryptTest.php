<?php

namespace Psamatt\Silex\Provider\Tests;

use Psamatt\Silex\Provider\Mcrypt\Mcrypt;

class McryptTest extends \PHPUnit_Framework_TestCase
{
    private $key;

    public function setUp()
    {
        if (!class_exists('Psamatt\Silex\Provider\Mcrypt\Mcrypt')) {
            $this->markTestSkipped('Mcrypt class is not available');
        }
        
        $this->key = 'Cne4hTvbnN';
    }
    
    public function testCheckingBase64EncodeAsDefaultValue()
    {
        $mcrypt = new Mcrypt($this->key);
        
        $this->assertTrue($mcrypt->isBase64Encoding());
    }
    
    public function testSettingBase64EncodeAsFalseValue()
    {
        $mcrypt = new Mcrypt($this->key);
        $mcrypt->setBase64Encoding(false);
        
        $this->assertFalse($mcrypt->isBase64Encoding());
    }
    
    public function testSettingBase64EncodeAsTrueValue()
    {
        $mcrypt = new Mcrypt($this->key);
        $mcrypt->setBase64Encoding(true);
        
        $this->assertTrue($mcrypt->isBase64Encoding());
    }
    
    public function testCheckEncryptedDecryptEqualsNormalString()
    {
        $mcrypt = new Mcrypt($this->key);
        
        $string = 'String to encode';
        
        $encryptedString = $mcrypt->encrypt($string);
        
        $this->assertEquals($string, $mcrypt->decrypt($encryptedString));
    }
    
    public function testSettingBase64EncodesString()
    {
        $mcrypt = new Mcrypt($this->key);
        $mcrypt->setBase64Encoding(true);
        
        $base64Decoded = base64_decode($mcrypt->encrypt('String to encode'));
        
        $mcrypt->setBase64Encoding(false);
        
        $encodedString = $mcrypt->encrypt('String to encode');
        
        $this->assertEquals($encodedString, $base64Decoded);
    }
    
    public function testEncryptionDecryptionUsingIv()
    {
        $mcrypt1 = new Mcrypt($this->key, MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $mcrypt1->generateIv();
        
        $mcrypt2 = new Mcrypt($this->key, MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $mcrypt2->setIv($mcrypt1->getIv());
        
        $string = 'String to encode';
        
        $encryptedString = $mcrypt1->encrypt($string);
        
        $this->assertEquals($string, $mcrypt2->decrypt($encryptedString));
    }
}
