<?php

namespace GT\BlackListBundle\Tests\EventListener;

use GT\BlackListBundle\EventListener\RequestEventListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Test for the blacllist listener
 *
 * @package GTBlackListBundle
 * @author  Gerard Toko <gerard.toko@gmail.com>
 */
class BlackListEventListenerTest extends \PHPUnit_Framework_TestCase
{

    protected $container;


    public function testDoRequestEvent()
    {

	$request = Request::create('http://test.com/foo?bar=baz');
	$kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
	$event = new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);

	$this->container = $this->initContainer();
	$listener = new RequestEventListener($this->container);
	$this->assertNull($listener->onKernelRequest($event));

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