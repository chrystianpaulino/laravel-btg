<?php

namespace BeeDelivery\Btg\Utils;

use Carbon\Carbon;

class BtgConnection extends Connection
{
    protected $baseUrl;
    protected $accountId;
    protected $companyId;
    protected $clientId;
    protected $redirectUri;
    protected $basicAuth;

    /*
     * Pega valores no arquivo de configuração do pacote e atribui às variáveis
     * para utilização na classe.
     *
     * @return void
     */
    public function __construct($code = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->baseUrl     = config('btg.base_url');
        $this->accountId   = config('btg.account_id');
        $this->companyId   = config('btg.company_id');
        $this->clientId    = config('btg.client_id');
        $this->redirectUri = config('btg.redirect_uri');
        $this->basicAuth   = config('btg.basic_auth');

        $this->getAccessToken($code);
    }

    /*
     * Pega o token de acesso da sessão ou gera um novo para utilização na próxima requisição.
     *
     * Access Token: É o token emitido a partir das permissões concedidas pelo usuário final.
     * Representa a autorização da aplicação de acessar certos dados de um usuário na API.
     * Por padrão o token tem duração de 24h.
     *
     * Refresh Token: É o token emitido juntamente ao Access Token e é utilizado para renová-lo sem a
     * necessidadede interação com o usuário final. Por padrão tem duração de 10 dias.(RENOVAVEL).
     *
     * https://developers.empresas.btgpactual.com/docs/btg-id#conceitos-basicos
     *
     * @return array|void
     */
    /**
     * @throws \Exception
     */
    public function getAccessToken($code = null)
    {
        if (isset($_SESSION["btgAuthorization"])) {
            $token         = $_SESSION["btgAuthorization"];
            $diffInMinutes = Carbon::parse($token['updated_at'])->diffInMinutes(now());

            // Durante 23 horas retorna o access_token padrão
            if ($diffInMinutes <= 1380) {
                $this->accessToken = $token['access_token'];

                return $token;
            }

            // Durante 9 dias utiliza o refresh token para gerar o token
            if ($diffInMinutes <= 12960) {
                $params = [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $token['refresh_token'],
                ];

                $response = $this->auth($params);

                if ($response['code'] == 200) {
                    $this->accessToken = $response['response']['access_token'];

                    $token['access_token']  = $this->accessToken;
                    $token['token_type']    = $response['response']['token_type'];
                    $token['expires_in']    = $response['response']['expires_in'];
                    $token['refresh_token'] = $response['response']['refresh_token'];
                    $token['scope']         = $response['response']['scope'];
                    $token['created_at']    = now();
                    $token['updated_at']    = now();

                    $_SESSION["btgAuthorization"] = $token;

                    $this->accessToken = $token['access_token'];

                    return $token;
                }
            }
        }

        if (!$code) {
            throw new \Exception("Code is required");
        }

        $params = [
            'code'         => $code,
            'redirect_uri' => config('btg.redirect_uri'),
            'grant_type'   => 'authorization_code',
            'scope'        => 'openid empresas.btgpactual.com/bank-slips empresas.btgpactual.com/bank-slips.readonly empresas.btgpactual.com/pix-cash-in empresas.btgpactual.com/pix-cash-in.readonly empresas.btgpactual.com/accounts empresas.btgpactual.com/transfers empresas.btgpactual.com/transfers.readonly',
        ];

        $response = $this->auth($params);


        if ($response['code'] == 200) {
            $token['access_token']  = $response['response']['access_token'];
            $token['id_token']      = $response['response']['id_token'];
            $token['token_type']    = $response['response']['token_type'];
            $token['expires_in']    = $response['response']['expires_in'];
            $token['refresh_token'] = $response['response']['refresh_token'];
            $token['scope']         = $response['response']['scope'];
            $token['session_id']    = $response['response']['session_id'];
            $token['created_at']    = now();
            $token['updated_at']    = now();

            $_SESSION["btgAuthorization"] = $token;

            $this->accessToken = $token['access_token'];

            return $token;
        }

        return $response;
    }

    private function tokenInSession()
    {
        //
    }
}
