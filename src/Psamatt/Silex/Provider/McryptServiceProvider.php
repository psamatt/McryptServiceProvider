<?php

/*
 * This file is part of Mcrypt ServiceProvider.
 *
 * (c) Matt Goodwin <matt.goodwin491@gmail.com>
 *
 */

namespace Psamatt\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class McryptServiceProvider implements ServiceProviderInterface
{    
    /**
     * The array of options to use
     * 
     * @access private
     * @var array
     */
    private $options;
    
    /**
     * Whether to base64 the encrypted value
     *
     * @access private
     * @var boolean
     */
    private $base64;

    /**
     * Constructor
     *
     * @param string $dsn
     */
    public function __construct($key, array $options = array())
    {
        if (!extension_loaded('mcrypt')) {
            throw new Exception('mcrypt extension is required for this script');
            return false;
        }

        $this->options = array();
        $this->options['key'] = md5($key);
        $this->options['cipher'] = array_key_exists('cipher', $options)? $options['cipher']: MCRYPT_RIJNDAEL_256;
        $this->options['mode'] = array_key_exists('mode', $options)? $options['mode']: MCRYPT_MODE_ECB;
        $this->options['iv_source'] = array_key_exists('iv_source', $options)? $options['iv_source']: MCRYPT_RAND;
        
        $this->base64 = array_key_exists('base64', $options)? $options['base64']: true;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {   
        $mcrypt = new Mcrypt\Mcrypt($this->options['key'], $this->options['cipher'], $this->options['mode'], $this->options['iv_source']);
        $mcrypt->setBase64Encoding($this->base64);
        
        $app['mcrypt'] = $mcrypt;
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
