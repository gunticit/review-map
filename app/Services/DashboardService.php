<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Validation\ValidationException;

class DashboardService {
    protected $projectRepositoryInterface;

    public function __construct(ProjectRepositoryInterface $projectRepositoryInterface)
    {
        $this->projectRepositoryInterface = $projectRepositoryInterface;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function info($request){
        $total_projects = $this->projectRepositoryInterface->countData(array());
        $total_working = $this->projectRepositoryInterface->countData(array('status' => Project::COMPLETED_PROJECT));
        $total_stopped = $this->projectRepositoryInterface->countData(array('status' => Project::STOPPED_PROJECT));
        $data = array(
            'projects' => [
                'total' => $total_projects,
                'total_working' => $total_working,
                'total_stopped' => $total_stopped
            ],
        );
        return $data;
    }

    public function getProjectsCompleted(){
        return $this->projectRepositoryInterface->countDataGroupMonth(array('status' => Project::COMPLETED_PROJECT));
    }
    
    // Dự án đã phân phối
    public function getProjectsDistributed(){
        return $this->projectRepositoryInterface->countDataGroupMonth(array('list_status' => array(Project::COMPLETED_PROJECT, Project::WORKING_PROJECT)));
    }

    public function getMoneySpents(){
        $spents = array();
        for($i = 1; $i <= 12; $i++){
            $spents[] = array(
                "label" => "Tháng $i",
                "y" => rand(0, 100),
            );
        }
        return $spents; // Làm sau
    }

    private function filterData($request){
    }
}