<?php

/*
 * This file is part of GTBlackListBundle.
 *
 * (c) Gerard TOKO <gerard.toko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
	 
namespace GT\BlackListBundle\Provider;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @author gerardtoko
 */
interface InterfaceBlackListPorvider
{
    
    public function  __construct(ContainerInterface $container);

    public function getData();

}