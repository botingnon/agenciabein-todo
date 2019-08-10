<?php
/**
 * Gerenciamento de tarefas
 *
 * @category Api
 * @package  Todo
 * @author   Valdir Botingnon <valdir.botingnon@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://localhost:3000/doc/#!/auth
 */
namespace Todo\Api;

use \Luracast\Restler\RestException;
use \Firebase\JWT\JWT;

class Auth
{

    /**
     * Login
     *
     * Autenticação de usuários
     *
     * @param string $email {@from body}{@min 3}{@max 255}{@type email}
     *                    E-mail do usuário
     *
     * @param string $password {@from body}{@min 3}{@max 255}
     *                    Senha do usuário
     *
     * @return array Usuário autenticado
     * @url POST /login
     */
    public function login($email, $password)
    {
        $find = \R::findOne(
            'user',
            'email = ? AND password = ?',
            [trim($email), hash('sha256', $password)]
        );

        if (!$find->id) {
            throw new RestException(400, 'Incorrect e-mail or password');
        }

        unset($find->password);

        $key = getenv('AUTH_JWT_KEY');
        $token = [
            "iss" => getenv('AUTH_JWT_ISS'),
            "aud" => getenv('AUTH_JWT_AUD'),
            "exp" => time() + getenv('AUTH_EXPIRE_TIME'),
            "iat" => time(),
            'user' => $find
        ];

        $jwt = JWT::encode($token, $key);

        $decoded = JWT::decode($jwt, $key, ['HS256']);
        $decoded->token = $jwt;

        return $decoded;
    }

    /**
     * Registrar
     *
     * Registro de novos usuários
     *
     * @param string $name {@from body}{@min 3}{@max 255}
     *                    Nome do usuário
     *
     * @param string $email {@from body}{@min 3}{@max 255}{@type email}
     *                    E-mail do usuário
     *
     * @param string $password {@from body}{@min 3}{@max 255}
     *                    Senha do usuário
     *
     * @param string $c_password {@from body}{@min 3}{@max 255}
     *                    Confirmação de senha do usuário
     *
     * @return array Usuário autenticado
     * @url POST /register
     */
    public function register($name, $email, $password, $c_password)
    {
        if ($password !== $c_password) {
            throw new RestException(400, 'c_password other than password');
        }

        if ($this->hasUserByEmail($email)) {
            throw new RestException(400, 'E-mail already registered');
        }

        $User = \R::dispense('user');
        $User->name = trim($name);
        $User->email = trim($email);
        $User->password = hash('sha256', $password);

        $id = \R::store($User);

        unset($User->password);

        return $User;
    }

    /**
     * Verifica e-mail cadastrado
     *
     * Verifica se um determinado email já está cadastrado
     *
     * @param string $email E-mail do usuário
     *
     * @return bool
     */
    private function hasUserByEmail(string $email)
    {
        $find = \R::findOne('user', 'email = ?', [trim($email)]);

        return ($find->id);
    }
}
