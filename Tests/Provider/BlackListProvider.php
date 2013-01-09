<?php

/*
 * This file is part of GTBlackListBundle.
 *
 * (c) Gerard TOKO <gerard.toko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GT\BlackListBundle\Tests\Provider;

use GT\BlackListBundle\Provider\InterfaceBlackListPorvider;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Test for the blacllist listener
 *
 * @package GTBlackListBundle
 * @author  Gerard Toko <gerard.toko@gmail.com>
 */
class BlackListProvider implements InterfaceBlackListPorvider
{

    protected $container;


    /**
     * 
     * @param \GT\BlackListBundle\Tests\Provider\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
	$this->container = $container;
    }


    /**
     * 
     * @return type
     */
    public function getData()
    {
	//put your code here
	//the datas can come of doctrine, propel etc...
	return array("145.34.89.123", "145.34.134.23");
    }

}