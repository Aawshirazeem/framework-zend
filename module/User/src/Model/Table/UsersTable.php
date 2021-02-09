<?php
declare(strict_types=1);

namespace User\Model\Table;

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\I18n\Filter\Alnum;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\Factory;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Csrf;
use Laminas\Validator\Date;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\Db\RecordExists;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class UsersTable extends AbstractTableGateway{

    protected $table = 'users';
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    //TODO : Fetch Record by Email method Start.
    //Bis später :-)

    public function getLoginFormInputFilter(){
        $inputFilter = new InputFilter();
        $inputFilterFactory = new Factory();


        # filter and validate email input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'email',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                        ['name' => StringToLower::class],
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        ['name' => EmailAddress::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 6,
                                'max' => 128,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Email address must have at least 6 characters!',
                                    StringLength::TOO_LONG => 'Email address must have at most 128 characters!',
                                ],
                            ],
                        ],
                        [
                            'name' => RecordExists::class,
                            'options' => [
                                'table' => $this->table,
                                'field' => 'email',
                                'adapter' => $this->adapter,
                            ],
                        ],
                    ],
                ]
            )
        );


        # filter and validate password input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'password',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 8,
                                'max' => 25,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Password must have at least 8 characters',
                                    StringLength::TOO_LONG => 'Password must have at most 25 characters',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );


        # filter and validate Recall CheckBox
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'recall',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                        ['name' => ToInt::class],
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => IsInt::class,
                        ],
                        [
                            'name' => InArray::class,
                            'options' => [
                                'haystack' => [0,1],
                            ],
                        ],
                    ],
                ]
            )
        );


        # csrf field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'csrf',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => Csrf::class,
                            'options' => [
                                'messages' => [
                                    Csrf::NOT_SAME => 'Oops! Refill the form.',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );

        return $inputFilter;
    }
    public function setCreateInputFilter(){
        $inputFilter = new InputFilter();
        $inputFilterFactory = new Factory();

        # filter and validate username input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'username',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                        ['name' => Alnum::class], # allows only [a-zA-Z0-9] characters
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 2,
                                'max' => 25,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Username must have at least 2 characters',
                                    StringLength::TOO_LONG => 'Username must have at most 25 characters',
                                ],
                            ],
                        ],
                        [
                            'name' => \Laminas\I18n\Validator\Alnum::class,
                            'options' => [
                                'messages' => [
                                    \Laminas\I18n\Validator\Alnum::NOT_ALNUM => 'Username must consist of alphanumeric characters only',
                                ],
                            ],
                        ],
                        [
                            'name' => NoRecordExists::class,
                            'options' => [
                                'table' => $this->table,
                                'field' => 'username',
                                'adapter' => $this->adapter,
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate gender select field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'gender',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => InArray::class,
                            'options' => [
                                'haystack' => ['Female', 'Male', 'Other'],
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate email input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'email',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                        #['name' => Filter\StringToLower::class], comment this line out
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        ['name' => EmailAddress::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 6,
                                'max' => 128,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
                                    StringLength::TOO_LONG => 'Email address must have at most 128 characters',
                                ],
                            ],
                        ],
                        [
                            'name' => NoRecordExists::class,
                            'options' => [
                                'table' => $this->table,
                                'field' => 'email',
                                'adapter' => $this->adapter,
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate confirm_email input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'confirm_email',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                        #['name' => Filter\StringToLower::class], as well as this one
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        ['name' => EmailAddress::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 6,
                                'max' => 128,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
                                    StringLength::TOO_LONG => 'Email address must have at most 128 characters',
                                ],
                            ],
                        ],
                        [
                            'name' => NoRecordExists::class,
                            'options' => [
                                'table' => $this->table,
                                'field' => 'email',
                                'adapter' => $this->adapter,
                            ],
                        ],
                        [
                            'name' => Identical::class,
                            'options' => [
                                'token' => 'email',  # field to compare against
                                'messages' => [
                                    Identical::NOT_SAME => 'Email addresses do not match!',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate birthday dateselect field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'birthday',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => Date::class,
                            'options' => [
                                'format' => 'Y-m-d',
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate password input field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'password',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 8,
                                'max' => 25,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Password must have at least 8 characters',
                                    StringLength::TOO_LONG => 'Password must have at most 25 characters',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );

        # filter and validate confirm_password field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'confirm_password',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'min' => 8,
                                'max' => 25,
                                'messages' => [
                                    StringLength::TOO_SHORT => 'Password must have at least 8 characters',
                                    StringLength::TOO_LONG => 'Password must have at most 25 characters',
                                ],
                            ],
                        ],
                        [
                            'name' => Identical::class,
                            'options' => [
                                'token' => 'password',
                                'messages' => [
                                    Identical::NOT_SAME => 'Passwords do not match!',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );

        # csrf field
        $inputFilter->add(
            $inputFilterFactory->createInput(
                [
                    'name' => 'csrf',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class], # stips html tags
                        ['name' => StringTrim::class], # removes empty spaces
                    ],
                    'validators' => [
                        ['name' => NotEmpty::class],
                        [
                            'name' => Csrf::class,
                            'options' => [
                                'messages' => [
                                    Csrf::NOT_SAME => 'Oops! Refill the form.',
                                ],
                            ],
                        ],
                    ],
                ]
            )
        );

        return $inputFilter;
    }

    public function saveAccount(array $data){
        $timeNow = date('Y-m-d H:i:s');
        $values = [
            'username' => ucfirst($data['username']),
            'email'    => mb_strtolower($data['email']),
            'password' => (new Bcrypt())->create($data['password']), # encrypt/hash password
            'birthday' => $data['birthday'],
            'gender'   => $data['gender'],
            'role_id'  => $this->assignRoleId(),
            'created'  => $timeNow,
            'modified' => $timeNow,
        ];

        $sqlQuery = $this->sql->insert()->values($values);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);

        return $sqlStmt->execute();
    }

    private function assignRoleId()
    {
        $sqlQuery = $this->sql->select()->where(['role_id' => 1]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();

        return (!$handler) ? 1 : 2;
    }

}
