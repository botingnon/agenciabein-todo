<?php
/**
 * Gerenciamento de usuários
 *
 * @category Api
 * @package  Todo
 * @author   Valdir Botingnon <valdir.botingnon@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace Todo\Api;

use Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;
use \Luracast\Restler\Defaults;
use \Luracast\Restler\RestException;
use \Firebase\JWT\JWT;

class AccessControl implements iAuthenticate
{

    /**
     * Verifica permissão de acesso
     *
     * Verifica se existe um token válido
     *
     * @return bool
     */
    public function __isAllowed()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'] ?
            str_replace('Bearer ', '', $headers['Authorization']) : $_GET['api_key'];

        try {
            JWT::decode($token, getenv('AUTH_JWT_KEY'), ['HS256']);
            return true;
        } catch (\Exception $e) {
            throw new RestException(401, $e->getMessage());
        }
    }

    /**
     * Localização do token
     *
     * Classifica a localização do token
     *
     * @return bool
     */
    public function __getWWWAuthenticateString()
    {
        return 'Bearer Authorization="api_key"';
    }
}
