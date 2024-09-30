<?php
namespace App\Repositories\Mission;

interface MissionRepositoryInterface
{
    public function list($request);
    public function getRandomMission($request);
}
