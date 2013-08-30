<?php

namespace Psamatt\Silex\Provider\Tests;

use Silex\Application;

use Psamatt\Silex\Provider\McryptServiceProvider;

class McryptServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $key;

    public function setUp()
    {
        if (!class_exists('Silex\Application')) {
            $this->markTestSkipped('Silex is not available');
        }
        
        $this->key = 'Cne4hTvbnN';
    }

    public function testRegister()
    {
        $app = new Application();
        $app->register(new McryptServiceProvider($this->key));
        
        $this->assertInstanceOf('Psamatt\Silex\Provider\Mcrypt\Mcrypt', $app['mcrypt']);
    }
    
    public function testSettingBase64EncodeAsOptionToDefault()
    {
        $app = new Application();
        $app->register(new McryptServiceProvider($this->key));

        $this->assertTrue($app['mcrypt']->isBase64Encoding());
    }
    
    public function testSettingBase64EncodeAsOptionToFalse()
    {
        $app = new Application();
        $app->register(new McryptServiceProvider($this->key, array('base64' => false)));

        $this->assertFalse($app['mcrypt']->isBase64Encoding());
    }
    
    public function testSettingBase64EncodeAsOptionToTrue()
    {
        $app = new Application();
        $app->register(new McryptServiceProvider($this->key, array('base64' => true)));

        $this->assertTrue($app['mcrypt']->isBase64Encoding());
    }
}
