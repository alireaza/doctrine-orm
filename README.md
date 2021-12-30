# Doctrine ORM


## Install

Via Composer
```bash
$ composer require alireaza/doctrine-orm
```


## Usage

```php
use AliReaza\Doctrine\ORM\Doctrine;

$doctrine = new Doctrine([
    'driver' => 'pdo_mysql',
    'host' => 127.0.0.1,
    'port' => 3306,
    'user' => 'root',
    'password' => '',
    'dbname' => 'database_name'
], [
    'app/Entities'
]);

$em = $doctrine->getEntityManager();
```


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.