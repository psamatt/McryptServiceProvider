<?php

/*
 * This file is part of Mcrypt ServiceProvider.
 *
 * (c) Matt Goodwin <matt.goodwin491@gmail.com>
 *
 */

namespace Psamatt\Silex\Provider\Twig\Extension;

use Psamatt\Silex\Provider\Mcrypt\Mcrypt;

class McryptExtension extends \Twig_Extension
{
    /**
     * Mcrypt
     *
     * @var Mcrypt
     * @access private
     */
    private $mcrypt;

    /**
     * Constructor
     *
     * @param Mcrypt $mcrypt
     */
    public function __construct(Mcrypt $mcrypt)
    {
        $this->mcrypt = $mcrypt;
    }

    /**
    * {@inheritdoc}
    */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mcrypt_encrypt', array($this->mcrypt, 'encrypt')),
            new \Twig_SimpleFilter('mcrypt_decrypt', array($this->mcrypt, 'decrypt')),
        );
    }

    /**
    * {@inheritdoc}
    */
    public function getName()
    {
        return 'mcrypt';
    }
}