<?php
namespace App\Controllers;

use App\Models\Project;

class ProjectController {
    public function index() {
        header('Content-Type: application/json');
        $projectModel = new Project();
        $projects = $projectModel->getAll();
        
        echo json_encode($projects);
    }
}