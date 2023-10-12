<?php

namespace App\Repositories\Client;


use App\Models\Client;

interface IClientRepository
{
    public function getAll();

    public function get(Client $client);
}
