<?php

/*
 * This file is part of Mcrypt ServiceProvider.
 *
 * (c) Matt Goodwin <matt.goodwin491@gmail.com>
 *
 */

namespace Psamatt\Silex\Provider\Mcrypt;

use Silex\Application;
use Silex\ServiceProviderInterface;

class Mcrypt 
{
    /**
     * The encryption key
     *
     * @var string
     * @access private
     */
    private $key;
    
    /**
     * The cipher to use
     *
     * @var string
     * @access private
     */
    private $cipher;
    
    /**
     * The mode
     *
     * @var string
     * @access private
     */
    private $mode;
    
    /**
     * The iv to use
     *
     * @var string
     * @access private
     */
    private $iv;
    
    /**
     * Whether to base64 encode and decode the ecrypted value
     *
     * @var string
     * @access private
     */
    private $base64 = true;

    /**
     * Constructor
     *
     * @param string $key The key with which the data will be encrypted
     * @param string $cipher One of the MCRYPT_ciphername constants, or the name of the algorithm as string. Default MCRYPT_RIJNDAEL_256
     * @param string $mode One of the MCRYPT_MODE_modename constants. Default MCRYPT_MODE_ECB
     * @param string $iv_source The source of the IV. Default MCRYPT_RAND
     */
    public function __construct($key, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_ECB, $iv_source = MCRYPT_RAND)
    {
        $this->key = $key;
        $this->cipher = $cipher;
        $this->mode = $mode;
        $this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), $iv_source);
    }
    
    /**
     * Encrypt the string
     *
     * @param string $data
     * @return string The encrypted data
     */
    public function encrypt($data)
    {
        $encryptedData = mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
        
        return $this->base64? base64_encode($encryptedData): $encryptedData;
    }
    
    /**
     * Decrypt the string
     * 
     * @param string $data The encrypted data to decrypt
     * @return string The normal string
     */
    public function decrypt($data)
    {
        $data = ($this->base64) ? base64_decode($data) : $data;
    
        return rtrim(mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $this->iv), "\0");
    }
    
    /**
     * Base 64 encode and decode the encrypted value
     *
     * @param boolean $base64
     */
    public function setBase64Encoding($base64)
    {
        $this->base64 = (bool)$base64;
    }
    
    /**
     * Is base 64 enabled
     *
     * @return boolean
     */
    public function isBase64Encoding()
    {
        return $this->base64;
    }
    
}