<?php

namespace App\Http\Controllers;

use App\Repositories\RegionsRepository;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    public function __construct(RegionsRepository $rR)
    {
        $this->rR = $rR;
    }

    public function regions()
    {
        return $this->rR->getAllRegions();
    }

    public function getregion($id)
    {
        return $this->rR->getRegion($id);
    }
}
