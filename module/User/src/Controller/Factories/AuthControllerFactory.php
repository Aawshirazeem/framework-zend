<?php

declare(strict_types=1);

namespace User\Controller\Factories;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Controller\AuthController;
use User\Model\Table\UsersTable;

class AuthControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthController(
            $container->get(UsersTable::class)
        );
    }
}