# DomUdallWirecardBundle [![Build Status](https://secure.travis-ci.org/domudall/DomUdallWirecardBundle.png)](http://travis-ci.org/domudall/DomUdallWirecardBundle)

This bundle uses version 1.0.8 of the Wirecard QPAY API to allow your Symfony2 project to take single and repeated payments.

Builds are run using the awesome [Travis CI](http://travis-ci.org/), testing against PHP 5.3 with Symfony 2.x

## Installation

Add the following lines to your ``deps`` file:

```
[WirecardBundle]
    git=http://github.com/domudall/DomUdallWirecardBundle.git
    target=bundles/DomUdall/WirecardBundle
```

Update your vendors in the usual way:

``` bash
$ ./bin/vendors install
```

## Configure Autoloader

Add the following to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...

    'DomUdall'      => __DIR__.'/../vendor/bundles',
));
```

### Enable the Bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new DomUdall\WirecardBundle\DomUdallWirecardBundle(),
    );
}
```

### Register Routes

*THIS NEEDS TO BE COMPLETED FIRST!*

## Credits

[Dom Udall](https://github.com/domudall/)

## Licence
Licenced under the [New BSD License](http://opensource.org/licenses/bsd-license.php)