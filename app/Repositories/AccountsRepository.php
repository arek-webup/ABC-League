<?php


namespace App\Repositories;


use App\Account;

class AccountsRepository
{

    public function getAllAccounts()
    {
        return Account::all();
    }

    public function getAllAvailableAccounts()
    {
        return Account::where('quantity','>=', '1')->get();
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
