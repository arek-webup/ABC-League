<?php


namespace App\Repositories;


use App\Account;

class AccountsRepository
{
    public static function getSorted($id)
    {
        return Account::where('region_id',  $id)->orderBy('order', 'asc')->get();
    }


    public function getAllAccounts()
    {
        return Accounts::all();
    }

    public function getAllAvailableAccounts()
    {
        return Accounts::where('quantity','>=', '1')->get();
    }

    public function getAvailableAccount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->where('quantity','>=',1)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getAccount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->get();
    }

    public function getAccountsCount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->count();
    }
}
