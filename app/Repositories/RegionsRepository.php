<?php


namespace App\Repositories;


use App\Region;

class RegionsRepository
{
    public function getRegion($id)
    {
        return Region::findOrFail($id);
    }

    public function getAvailableRegions()
    {
        return Region::where('avalible', '1')->get();
    }

    public function getAllRegions()
    {
        return Region::all();
    }
}
