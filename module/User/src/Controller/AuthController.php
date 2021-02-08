<?php

declare(strict_types = 1);

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\CreateForm;

class AuthController extends AbstractActionController{


    public function CreateAction(){
        $createform = new CreateForm();

        return new ViewModel([
            'form' => $createform
        ]);
    }
}

