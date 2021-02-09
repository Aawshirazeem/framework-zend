<?php
declare(strict_types=1);

namespace User\Form\Auth;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;

class LoginForm extends Form{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('sign_in');
        $this->setAttribute('method' , 'post');


        //Email field
        $this->add([
            'type' => Email::class,
            'name' => 'email',
            'options' =>[
                'label' => 'Email Address'
            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Please provide your Email Address',
                'placeholder' => 'Enter Your Email Address',
            ],
        ]);

        //Password field
        $this->add([
            'type' => Password::class,
            'name' => 'password',
            'options' =>[
                'label' => 'Password'
            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Please provide your Email Address.',
                'placeholder' => 'Enter Your Password',
            ],
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => 'recall',
            'options' => [
                'label'=> 'Remember me?',
                'label_attributes' => [
                    'class' => 'custom-control-label'
                ],
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
            ],
            'attributes' => [
                'values' => 0,
                'id' => 'recall',
                'class' => 'custom-control-input',
            ]
        ]);

        //csrf
        $this->add([
            'type' => Csrf::class,
            'name' => 'csrf',
            'options' =>[
                'csrf_options' => [
                    'timeout' => 600,
                ],
            ],
        ]);

        //Submit
        $this->add([
            'type' => Submit::class,
            'name' => 'login_account',
            'attributes' => [
                'value' => 'Login',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
