edwrodrig\exception_with_data
========
Una clase Exception que soporta un array como data

[![Latest Stable Version](https://poser.pugx.org/edwrodrig/exception_with_data/v/stable)](https://packagist.org/packages/edwrodrig/exception_with_data)
[![Total Downloads](https://poser.pugx.org/edwrodrig/exception_with_data/downloads)](https://packagist.org/packages/edwrodrig/exception_with_data)
[![License](https://poser.pugx.org/edwrodrig/exception_with_data/license)](https://github.com/edwrodrig/exception_with_data/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/edwrodrig/exception_with_data.svg?branch=master)](https://travis-ci.org/edwrodrig/exception_with_data)
[![codecov.io Code Coverage](https://codecov.io/gh/edwrodrig/exception_with_data/branch/master/graph/badge.svg)](https://codecov.io/github/edwrodrig/exception_with_data?branch=master)
[![Code Climate](https://codeclimate.com/github/edwrodrig/exception_with_data/badges/gpa.svg)](https://codeclimate.com/github/edwrodrig/exception_with_data)
![Hecho en Chile](https://img.shields.io/badge/country-Chile-red)

## Uso 
```php
use \edwrodrig\exception_with_data\ExceptionWithData;

try {
    throw new ExceptionWithData(
        "division by zero",
        [
          "dividend" => 100,
          "divisor" => 0
        ]);

} catch ( ExceptionWithData $exception ) {
    print_r($exception->getData());
}
```
## Fundamento

Esta es una biblioteca que solucionar el problema de [agregar datos a una excepción](https://stackoverflow.com/questions/22113541/using-additional-data-in-php-exceptions).
No soy partidario de hacer una biblioteca para una funcionalidad tan simple pero prácticamente todos mis proyectos necesitan de esta funcionalidad.

Además si este código estuviera replicado de todas forma necesitaría tener múltiples capturas:
```php

try {
    //something
} catch ( \lib_1\ExceptionWithData $e ) {
    //handle 1
} catch ( \lib_2\ExceptionWithData $e ) {
    //handle 2
} catch ( \lib_3\ExceptionWithData $e ) {
    //handle 3     
}
```

Elegí un nombre extraño para la clase para demostrar que ren realidad quiero que esto se cambie de alguna forma.
Ojalá se agregue un nuevo tipo de excepción en el núcleo de PHP.

## Instalación
```
composer require edwrodrig/exception
```

## Información de mi máquina de desarrollo
Salida de [system_info.sh](https://github.com/edwrodrig/exception_with_data/blob/master/scripts/system_info.sh)
```
+ hostnamectl
+ grep -e 'Operating System:' -e Kernel:
  Operating System: Ubuntu 20.04 LTS
            Kernel: Linux 5.4.0-33-generic
+ php --version
PHP 7.4.3 (cli) (built: May 26 2020 12:24:22) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.3, Copyright (c), by Zend Technologies
    with Xdebug v2.9.2, Copyright (c) 2002-2020, by Derick Rethans
```

## Notas
  - El código se apega a las recomendaciones de estilo de [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md).
  - Este proyecto esta pensado para ser trabajado usando [PhpStorm](https://www.jetbrains.com/phpstorm).
  - Se usa [PHPUnit](https://phpunit.de/) para las pruebas unitarias de código.
  - Para la documentación se utiliza el estilo de [phpDocumentor](http://docs.phpdoc.org/references/phpdoc/basic-syntax.html). 

