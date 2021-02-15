<?php

declare(strict_types=1);

namespace User\Controller\Factories;

;

use    Interop\Container\Exception\ContainerException;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use User\Controller\LoginController;
use User\Model\Table\UsersTable;

class LoginControllerFactory implements FactoryInterface{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LoginController(
            $container->get(Adapter::class),
            $container->get(UsersTable::class)
        );
    }
}
