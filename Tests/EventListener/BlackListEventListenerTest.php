<?php

/*
 * This file is part of GTBlackListBundle.
 *
 * (c) Gerard TOKO <gerard.toko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GT\BlackListBundle\Tests\EventListener;

use GT\BlackListBundle\EventListener\BlackListEventListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Test for the blacllist listener
 *
 * @package GTBlackListBundle
 * @author  Gerard Toko <gerard.toko@gmail.com>
 */
class BlackListEventListenerTest extends \PHPUnit_Framework_TestCase
{

    protected $container;


    public function testRequestEvent()
    {

	$request = Request::create('http://test.com/foo?bar=baz');
	$kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
	$event = new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);

	$this->container = $this->initContainer();

	$this->container->setParameter("gt_black_list", array("provider" => "class", "class" => "GT\BlackListBundle\Tests\Provider\BlackListProvider"));
	$listener = new BlackListEventListener($this->container);
	$this->assertNull($listener->onRequestEvent($event));

	try {
	    $this->container->setParameter("gt_black_list", array("provider" => "class", "class" => "GT\BlackListBundle\Tests\Provider\BlackListProvider"));
	    $listener = new BlackListEventListener($this->container);
	    $listener->setAddressRemote("145.34.134.23");
	    $this->assertNull($listener->onRequestEvent($event));
	} catch (AccessDeniedException $receive) {
	}
	
	$this->container->setParameter("gt_black_list", array("provider" => "class", "class" => "GT\BlackListBundle\Tests\Provider\BlackListProvider"));
	$listener = new BlackListEventListener($this->container);
	$listener->setAddressRemote("145.34.134.234");
	$this->assertNull($listener->onRequestEvent($event));

	try {
	    $this->container->setParameter("gt_black_list", array("provider" => "array", "data" => array("127.0.0.1")));
	    $listener = new BlackListEventListener($this->container);
	    $this->assertNull($listener->onRequestEvent($event));
	} catch (AccessDeniedException $receive) {
	}

	$this->container->setParameter("gt_black_list", array("provider" => "array", "data" => array("145.34.134.234")));
	$listener = new BlackListEventListener($this->container);
	$this->assertNull($listener->onRequestEvent($event));
    }


    /**
     * Init a container
     *
     * @return Container
     */
    protected function initContainer()
    {
	$container = new ContainerBuilder(new ParameterBag(array(
			    'kernel.debug' => false,
			    'kernel.bundles' => array('BlackListBundle' => 'GT\BlackListBundle\GTBlackListBundle,'),
			    'kernel.cache_dir' => sys_get_temp_dir(),
			    'kernel.environment' => 'dev',
			    'kernel.root_dir' => __DIR__ . '/../../../../' // src dir
			)));

	return $container;
    }

}