<?php
declare(strict_types=1);

namespace User\Form\Auth;

use Laminas\Form\Element;
use Laminas\Form\Form;

class CreateForm extends Form{

    public function __construct()
    {
        parent::__construct('new_account');
        $this->setAttribute('method' , 'post');

        //Username text field
        $this->add([
            'type' => Element\Text::class,
            'name' => 'username',
            'options' =>[
                'label' => 'Username'
            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9]+$',
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Username must consist of alphanumeric characters only',
                'placeholder' => 'Enter Your Username',

            ],
        ]);

        //Gender
        $this->add([
            'type' => Element\Select::class,
            'name' => 'gender',
            'options' =>[
                'label' => 'Gender',
                'empty_options' => 'Select....',
                'value_options' => [
                    'Female' => 'Female',
                    'Male' => 'Male',
                    'Other' => 'Other',
                ]
            ],
            'attributes' => [
                'required' =>true,
                'class' => 'custom-select',
            ],
        ]);


        //Email field
        $this->add([
            'type' => Element\Email::class,
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
                'title' => 'Please provide valid and working Email Address',
                'placeholder' => 'Enter Your Email Address',
            ],
        ]);



        //Verify Email field
        $this->add([
            'type' => Element\Email::class,
            'name' => 'confirm_email',
            'options' =>[
                'label' => 'Verify Email Address'
            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Email Address must match that provided one.',
                'placeholder' => 'Enter Your Email Address Again',
            ],
        ]);

        //Birth Select
        $this->add([
            'type' => Element\DateSelect::class,
            'name' => 'birthday',
            'options' =>[
                'label' => 'Select Date of Birth',
                'create_empty_options' => true,
                'max_year' => date('Y') - 13,
                'year_attributes' =>[
                    'class' => 'custom-select  w-30'
                ],
                'month_attributes' =>[
                    'class' => 'custom-select w-30'
                ],
                'day_attributes' =>[
                    'class' => 'custom-select w-30',
                    'id' => 'day'
                ],

            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Email Address must match that provided one.',
                'placeholder' => 'Enter Your Email Address Again',
            ],
        ]);


        //Password field
        $this->add([
            'type' => Element\Password::class,
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
                'title' => 'Password must have between 8 and 25 characters.',
                'placeholder' => 'Enter Your Password',
            ],
        ]);

        //Verify Password field
        $this->add([
            'type' => Element\Password::class,
            'name' => 'confirm_password',
            'options' =>[
                'label' => 'Verify Password'
            ],
            'attributes' => [
                'required' =>true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'title' => 'Password must must match that provided above.',
                'placeholder' => 'Enter Your Password again',
            ],
        ]);


        //csrf
        $this->add([
            'type' => Element\Csrf::class,
            'name' => 'csrf',
            'options' =>[
                'csrf_options' => [
                    'timeout' => 600,
                ],
            ],
        ]);

        //Submit
        $this->add([
            'type' => Element\Submit::class,
            'name' => 'create_account',
            'attributes' => [
                'value' => 'Create new Account',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
