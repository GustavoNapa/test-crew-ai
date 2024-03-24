<?php

namespace App\http\Services;

use App\Http\Services\Celcoin;
use App\Models\AccountBusiness;
use App\Models\AccountPerson;

class AccountHelper
{
    public static function getAccountDataFromDatabaseBySession()
    {
        if(session()->get('account_accountType') === "natural-person"){
            return AccountPerson::where(['documentNumber' => session()->get('account_documentNumber')])->get()->first();
        }else{
            return AccountBusiness::where(['documentNumber' => session()->get('account_documentNumber')])->get()->first();
        }
    }

    public static function getAccountDataFromCelcoinBySession(Celcoin $celcoin)
    {
        if(session()->get('account_accountType') === "natural-person"){
            return $celcoin->fetchAccountDataNaturalPersonWithCPF(session()->get('account_documentNumber'));
        }else if(session()->get('account_accountType') === "business"){
            return $celcoin->fetchAccountDataNaturalPersonWithCNPJ(session()->get('account_documentNumber'));
        }
    }

    public static function getAccountDataObjectFromCelcoinBySession(Celcoin $celcoin)
    {
        $account = AccountHelper::getAccountDataFromCelcoinBySession($celcoin);
        return json_decode($account);
    }
    
    public static function getAccountNumberFromCelcoin(Celcoin $celcoin)
    {
        $accountObject =  AccountHelper::getAccountDataObjectFromCelcoinBySession($celcoin);

        if(session()->get('account_accountType') === "natural-person"){
            return $accountObject->body->account->account;
        }else{
            return $accountObject->body->businessAccount->account;
        }
    }
}
