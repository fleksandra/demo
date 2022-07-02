<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RegistrationForm extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $login;
    public $email;
    public $password;
    public $password_repeat;
    public $rules = true;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat', 'rules'], 'required'],
            ['email', 'unique', 'targetClass' => User::Class, 'message' => 'E-mail уже занят.'],
            ['email', 'email'],
            ['name', 'match', 'pattern' => '/^[А-Яа-яё\s\-]+$/u'],
            ['surname', 'match', 'pattern' => '/^[А-Яа-яё\s\-]+$/u'],
            ['patronymic', 'match', 'pattern' => '/^[А-Яа-яё\s\-]+$/u'],
            ['login', 'unique', 'targetClass' => User::Class, 'message' => 'Логин уже занят.'],
            ['login', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать.'],
            ['password', 'match', 'pattern' => '/^.{6,}/u', 'message' => 'Пароль не менее 6 символов.'],
            ['rules', 'boolean'],
            ['rules', 'compare', 'compareValue' => 1, 'operator' => '==', 'message' => 'Обязательно.'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'rules' => 'Согласие на обработку персональных данных',
        ];
    }

    public function userRegistration()
    {
        $user = new User();
        $user->load($this->attributes, '');
        if($user->save(false)) {
            return $user;
        } else {
            return false;
        }
    }

}