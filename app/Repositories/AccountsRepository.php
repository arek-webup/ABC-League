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

    public function getAvailableAccounts()
    {
        return Account::with(['regions'])
            ->where('quantity','>=',1)
            ->orderBy('id', 'asc')
            ->get();
    }
    public function getAvailableAccount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->where('quantity','>=',1)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getAccount($id)
    {
        return Account::findOrFail($id);
    }

    public function getAccountsCount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->count();
    }
}
