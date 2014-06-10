<?php

namespace app\modules\user\models;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends User
{
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'username'], 'unique'],
            ['email', 'email'],
            [['email', 'username', 'password', 'company_name', 'password_repeat'], 'required'],
            [['username', 'password', 'company_name', 'password_repeat'], 'string', 'min' => 2, 'max' => 255],
            ['password_repeat', 'rulePassword', 'message'=>'Incorrect username or password.'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function rulePassword($attribute, $message)
    {
        if ($this->password != $this->$attribute) {
            $this->addError($attribute, $message);
        }
    }
}
