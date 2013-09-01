<?php

namespace Psamatt\Silex\Provider\Tests;

use Silex\Application;

use Psamatt\Silex\Provider\McryptServiceProvider;
use Psamatt\Silex\Provider\Twig\Extension\McryptExtension;

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
    
    public function RegisterProviderWithoutTwigExtension()
    {
        $app = new Application();
        $app->register(new McryptServiceProvider($this->key));
        
        $this->assertFalse(isset($app['mcrypt.twig.extension']));
    }
    
    public function RegisterProviderWithTwigExtension()
    {
        $app = new Application();
        $app['twig'] = new stdClass; // mock that we've defined the twig object
        $app->register(new McryptServiceProvider($this->key));
        
        $this->assertTrue(isset($app['mcrypt.twig.extension']));
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
