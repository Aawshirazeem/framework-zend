<?php

declare(strict_types = 1);

namespace User\Controller;

use http\Exception\RuntimeException;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\CreateForm;
use User\Model\Table\UsersTable;

class AuthController extends AbstractActionController{

    private $usersTable;

    public function __construct(UsersTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }

    //Sign Up Create Action
    public function CreateAction(){
        $auth = new AuthenticationService();

        //check If User is already login redirect to another Pages
        if($auth->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }

        $createform = new CreateForm();

        $request = $this->getRequest();
        if($request->isPost()){
            $formData = $request->getPost()->toArray();
            $createform->setInputFilter($this->usersTable->getCreateInputFilter());
            $createform->setData($formData);

            if($createform->isValid()){
                try {
                    $data = $createform->getData();
                    $this->usersTable->saveAccount($data);

                    $this->flashMessenger()->addSuccessMessage('You have successfully created account , You can login now');
                    $this->redirect()->toRoute('login');

                }catch (RuntimeException $exception){
                    flashMessenger()->addErrorMessage($exception->getMessage());
                    $this->redirect()->refresh();
                }
            }
        }

        return new ViewModel([
            'form' => $createform
        ]);
    }
}

