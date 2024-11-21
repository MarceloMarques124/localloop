<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property UserInfo $userInfo
 */
class User extends \yii\db\ActiveRecord
{
    public $password;  // Campo temporário para senha

    // Definição das regras de validação
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function createUser()
    {
        if ($this->validate()) {
            $this->setPassword($this->password);  // Criptografar a senha
            $this->generateAuthKey();  // Gerar chave de autenticação
            // Adicionando timestamps, caso não sejam definidos automaticamente
            $this->created_at = time();
            $this->updated_at = time();

            return $this->save();  // Salvar usuário no banco
        }
        return false;
    }




    // Função para criptografar a senha
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }


    // Função para gerar chave de autenticação
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    // Métodos do IdentityInterface (se necessário)
}
