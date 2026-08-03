<?php
namespace App\Models;

use App\Config\Database;

class Project {
    private $collection;

    public function __construct() {
        $db = Database::getConnection();
        $this->collection = $db->Projects;
    }

    public function getAll() {
        $cursor = $this->collection->find([], [
            'sort' => ['display_order' => 1],
            'typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']
        ]);
        return $cursor->toArray();
    }
}