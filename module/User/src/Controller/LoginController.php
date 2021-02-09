<?php

declare(strict_types=1);

namespace User\Controller;

use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\LoginForm;
use User\Model\Table\UsersTable;

class LoginController extends AbstractActionController{

    private $adapter;
    private $usersTable;

    public function __construct(Adapter $adapter, UsersTable $usersTable)
    {
        $this->adapter = $adapter;
        $this->usersTable = $usersTable;

    }

    public function indexAction()
    {
        $loginForm = new LoginForm();
        return (new ViewModel(['form' => $loginForm]))->setTemplate('user/auth/login');
    }
}