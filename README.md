GTBlackListBundle
=================

Symfony2 bundle for the Black list IP in your application

##  Installation

### Download GTBlackListBundle using composer

Add GTBlackListBundle in your composer.json:

```js
{
    "require": {
        "gerardtoko/blacklist-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update gerardtoko/blacklist-bundle
```

Composer will install the bundle to your project's `vendor/gerardtoko/blacklist-bundle` directory.


### Register the bundle

You must register the bundle in your kernel:
```php
    <?php
    
    // app/AppKernel.php    
    public function registerBundles()
    {
        $bundles = array(    
            // ...    
             new GT\BlackListBundle\GTBlackListBundle(),
        );    
        // ...
    }
```

## Configuration

### Select Provider Array
Example of configuration file yml:
```yml
gt_black_list:
    provider: array
    data: ["145.34.89.123", "145.34.134.23"]
```

### Select Provider Class
The provider class must implement ```InterfaceBlackListProvider```.
The InterfaceBlackListProvider require the ```getData``` method for receive the data. 

The ```getData``` Method must be returned a array.

Example of configuration file yml:
```yml
gt_black_list:
    provider: class
    class: Acme\DemoBundle\Provider\BlackListProvider
```

Example of the provider class:
```php
<?php

namespace Acme\DemoBundle\Provider;

use GT\BlackListBundle\Provider\InterfaceBlackListPorvider;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @package AcmeDemoBundle
 * @author  Gerard Toko <gerard.toko@gmail.com>
 */
class BlackListProvider implements InterfaceBlackListPorvider
{

    protected $container;

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
     * @return type
     */
    public function getData()
    {
	//put your code here
	//the data can come of doctrine, propel etc...
	return array("145.34.89.123", "145.34.134.23");
    }

}
```
