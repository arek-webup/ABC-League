<?php


namespace App\Repositories;


use App\Region;

class RegionsRepository
{
    public function getRegion($id)
    {
        return Region::findOrFail($id);
    }

    public function getAllRegions()
    {
        return Region::all();
    }
}
