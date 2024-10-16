<?php

namespace App\Models;

use MongoDB\Client;

class mongoAntojito
{
    protected $collection;

    public function __construct()
    {
        $client = new Client(env('MONGO_DB_HOST'));
        $this->collection = $client->selectCollection(env('MONGO_DB_DATABASE'), 'antojitos');
    }

    public function insertMany(array $data)
    {
        return $this->collection->insertMany($data);
    }
}