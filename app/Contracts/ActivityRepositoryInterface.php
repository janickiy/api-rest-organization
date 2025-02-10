<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ActivityRepositoryInterface
{
    public function getAll(): Collection;
    public function getTree(): Collection|array;
}