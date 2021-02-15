<?php

declare(strict_types=1);

namespace User\Controller;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Crypt\Password\Bcrypt;
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

        $auth = new AuthenticationService();
        if($auth->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }

        $loginForm = new LoginForm();
        $request = $this->getRequest();

        if($request->isPost()){
            $formData = $request->getPost()->toArray();
            $loginForm->setInputFilter($this->usersTable->getLoginFormInputFilter());
            $loginForm->setData($formData);

            if($loginForm->isValid()){
                $authAdapter = new CredentialTreatmentAdapter($this->adapter);
                $authAdapter->setTableName($this->usersTable->getTable())
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('password')
                            ->getDbSelect()->where(['active' => 1]);


                //data from Login Form
                $data = $loginForm->getData();
                $authAdapter->setIdentity($data['email']);


                //hashing class
                $hash = new Bcrypt();
                if($hash->verify($data['password'], ));

            }
        }

        return (new ViewModel(['form' => $loginForm]))->setTemplate('user/auth/login');
    }
}