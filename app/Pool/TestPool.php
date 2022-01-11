<?php
namespace App\Pool;

use Hyperf\DbConnection\Pool\DbPool;
use Psr\Container\ContainerInterface;

class TestPool extends DbPool{
    private static $_instance;

    public function __construct(ContainerInterface $container, string $name)
    {
        parent::__construct($container, $name);
    }

    static function getInstance(ContainerInterface $container,string $name){
        if (!self::$_instance){
            self::$_instance = new self($container,$name);
        }

        return self::$_instance;
    }
}