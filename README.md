GTBlackListBundle
=================

Symfony bundle for the Black list IP in your application


## Configuration

### Select Provider Array
Example of configuration file yml:
```
gt_black_list:
    provider: array
    data: ["145.34.89.123", "145.34.134.23"]
```

### Select Provider Class
The provider class must implement ```InterfaceBlackListProvider```
The InterfaceBlackListProvider require the ```getData``` method for receive the datas. the ```getData``` Method must be returned a array.
Example of configuration file yml:
```
gt_black_list:
    provider: class
    class: Acme\DemoBundle\Provider\BlackListProvider
```

Example of the provider class:
```
<?php

namespace Acme\DemoBundle\Provider;

use GT\BlackListBundle\Provider\InterfaceBlackListPorvider;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
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
```