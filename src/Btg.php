<?php

namespace BeeDelivery\Btg;

class Btg
{
    public function test(String $sName): string
    {
        return 'Hi ' . $sName . '! How are you doing today?';
    }

    public function bankSlip(): BankSlip
    {
        return new BankSlip();
    }

    public function pix(): Pix
    {
        return new Pix();
    }
}
