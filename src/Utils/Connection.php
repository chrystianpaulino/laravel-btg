<?php

namespace BeeDelivery\Btg\Utils;

use Illuminate\Support\Facades\Http;

class Connection
{
    /*
     * Realiza uma solicitação get padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function get($url, $params = null): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->withToken($this->accessToken)
                ->get($this->baseUrl . $url, $params);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }

    /*
     * Realiza uma solicitação post padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function post($url, $params = null): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->withToken($this->accessToken)
                ->post($this->baseUrl . $url, $params);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }

    /*
     * Realiza uma solicitação put padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function put($url, $params = null): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->withToken($this->accessToken)
                ->put($this->baseUrl . $url, $params);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }

    /*
     * Realiza uma solicitação delete padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function delete($url, $params = null): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
                ->withToken($this->accessToken)
                ->delete($this->baseUrl . $url, $params);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }

    /*
     * Realiza uma solicitação post utilizando Basic Authentication
     * para gerar um token de acesso.
     *
     * @param array $params
     * @return array
     */
    public function auth($params): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . $this->basicAuth
            ])
                ->asForm()
                ->post(env('BTG_BASE_URL_BTG_ID') . '/oauth2/token', $params);


            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }

    /*
     * Realiza uma solicitação put com envio de arquivos
     * utilizando Bearer Authentication.
     *
     * @param string $url
     * @param string $fileName
     * @param string $filePath
     * @param string $newFileName
     * @return array
     */
    public function putAttach($url, $fileName, $filePath, $newFileName): array
    {
        try {
            $response = Http::attach($fileName, file_get_contents($filePath), $newFileName)
                ->withToken($this->accessToken)
                ->put($this->baseUrl . $url);

            return [
                'code'     => $response->getStatusCode(),
                'response' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'code'     => $e->getCode(),
                'response' => $e->getMessage(),
            ];
        }
    }
}
