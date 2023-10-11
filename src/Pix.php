<?php

namespace BeeDelivery\Btg;


use BeeDelivery\Btg\Utils\BtgConnection;

class Pix
{
    protected $http;

    /*
     * Cria uma nova instância de BtgConnection.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = new BtgConnection();
    }

    /*
     * Criar um QR Code Pix
     *
     * @return array
     */
    public function createQrCode(): array
    {
        return $this->http->post('/v1/companies/' . config('btg.account_id') . '/pix-cash-in/locations', []);
    }

    /*
     * Obtem lista de QR Codes
     *
     * @return array
     */
    public function listQrCodes(): array
    {
        return $this->http->get('/v1/companies/' . config('btg.account_id') . '/pix-cash-in/locations');
    }

    /*
     * Iniciação de Transferências que ficará pendente de aprovação.
     *
     * @return array
     */
    public function transfer($params): array
    {
        return $this->http->post('/v1/companies/' . config('btg.company_id') . '/transfers', $params);
    }

    /*
     * Obtém transferência por um Id.
     *
     * @return array
     */
    public function getTransferById($transferId): array
    {
        return $this->http->get('/companies/' . config('btg.company_id') . '/transfers/' . $transferId);
    }

    /*
     * Obtém PDF do comprovante em base64.
     *
     * @return array
     */
    public function getPdfTransferById($transferId): array
    {
        return $this->http->get('/companies/' . config('btg.company_id') . '/transfers/' . $transferId . '/receipt');
    }

    /*
     * Obtem lista de transferencias
     *
     * @return array
     */
    public function list(): array
    {
        return $this->http->get('/v1/companies/' . config('btg.company_id') . '/transfers');
    }
}
