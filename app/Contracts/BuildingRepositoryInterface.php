<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BuildingRepositoryInterface
{
    public function getAll(): Collection;
}