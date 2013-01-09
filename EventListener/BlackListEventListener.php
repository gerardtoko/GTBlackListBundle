<?php

/*
 * This file is part of GTBlackListBundle.
 *
 * (c) Gerard TOKO <gerard.toko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GT\BlackListBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BlackListEventListener
{

    protected $container;
    protected $addr;


    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
	$this->container = $container;
    }


    /**
     * 
     * @param \Symfony\Component\EventDispatcher\Event $event
     */
    public function onRequestEvent(Event $event)
    {
	$config = $this->container->getParameter('gt_black_list');
	$provider = $config["provider"];

	switch (strtolower($provider)) {
	    case "class":
		if (empty($config["class"])) {
		    throw new \Exception("Undefined 'class' parameter in gt_black_list configuration");
		}

		// verification class
		$class = $config["class"];
		if (!class_exists($class)) {
		    throw new \Exception("Class $class no exists");
		}

		//get Data 
		$blackListPorviderClass = $config["class"];
		$blackListProvider = new $blackListPorviderClass($this->container);
		$data = $blackListProvider->getData();

		//verification data type if it's array value
		if (!is_array($data)) {
		    throw new \Exception("the data provider must return an array for gt_black_list configuration");
		}
		$this->isAccessDenied($data);
		break;

	    case "array":
		if (!empty($config["data"])) {
		    $this->isAccessDenied($config["data"]);
		}
		break;
	}
    }


    /**
     * 
     * @param type $data
     * @throws AccessDeniedException
     */
    public function isAccessDenied($data)
    {
	$addr = $this->getAddressRemote();

	if (in_array($addr, $data)) {
	    throw new AccessDeniedException("You are in the blacklist!");
	}
    }


    /**
     * 
     * @param type $addr
     * @return \GT\BlackListBundle\EventListener\BlackListEventListener
     */
    public function setAddressRemote($addr)
    {
	$this->addr = $addr;
	return $this;
    }


    /**
     * 
     * @return type
     */
    public function getAddressRemote()
    {
	$addr = "127.0.0.1";
	if (!empty($this->addr)) {
	    $addr = $this->addr;
	} else {
	    if (!empty($_SERVER["REMOTE_ADDR"])) {
		$addr = $_SERVER["REMOTE_ADDR"];
		$this->addr = $addr;
	    }
	}
	return $addr;
    }

}