<?php

namespace App\Http\Controllers;

use App\Account;
use App\Code;
use App\Repositories\AccountsRepository;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function __construct(AccountsRepository $aR)
    {
        $this->aR = $aR;
    }

    public function accounts()
    {
        return response()->json($this->aR->getAllAccounts());
    }

    public function account($id)
    {
        return $this->aR->getAccount($id);
    }

    public function accfromregion($id)
    {
        $acc = Account::where('region_id', $id)->get();
        for($i = 0; $i<$acc->count();$i++)
        {
            $count[$i] = Code::where('account_id',$acc[$i]->id)->count();
        }
        return ['acc' => $acc, 'count' => $count];
    }

    public function getAccountsCount($id)
    {
        Return Code::where('account_id',$id)->count();
    }
}
