<?php


namespace App\Repositories;


use App\Account;
use App\Code;
use Illuminate\Support\Facades\DB;

class AccountsRepository
{

    public function getAllAccounts()
    {

        return Account::withCount(['codes'])->get();
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
        return ['acc' => Account::findOrFail($id), 'count' => Code::where('account_id',$id)->count()];
    }

    public function getAccountsCount($id)
    {
        return Account::with(['regions'])
            ->where('region_id',$id)
            ->count();
    }
}
