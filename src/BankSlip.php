<?php

namespace BeeDelivery\Btg;


use BeeDelivery\Btg\Utils\BtgConnection;

class BankSlip
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
     * Cria um boleto no BTG
     *
     * @return array
     */
    public function create($params): array
    {
        return $this->http->post('/v1/bank-slips?accountId='. config('btg.account_id'), $params);
    }
}
