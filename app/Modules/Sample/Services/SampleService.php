<?php

namespace App\Modules\Sample\Services;

use App\Repositories\Sample\SampleRepositoryInterface;

class SampleService
{
    protected $sampleRepository;

    public function __construct(SampleRepositoryInterface $sampleRepository )
    {
        $this->sampleRepository = $sampleRepository;
    }

    public function pagination($request)
    {
        return $this->sampleRepository->pagination($request);
    }

    public function create($request)
    {
        try{
            $data = $this->getData($request,'create');
            $sample = $this->sampleRepository->create($data);
            return $sample;
        }catch(\Throwable $th){
            throw $th;
        }
    }

    public function find($id)
    {
        return $this->sampleRepository->find($id);
    }
    
    public function update($request, $id)
    {
        try{
            $data = $this->getData($request,'update');
            $sample = $this->sampleRepository->update($data, $id);
            return $sample;
        }catch(\Throwable $th){
            throw $th;
        }
    }
    public function delete($id){
        try{
            return $this->sampleRepository->delete($id);
        }catch(\Throwable $th){
            throw $th;
        }
    }

    public function getData($req, $action){
        $data = array(
            'name' => $req->name ?? ""
        );

        if($action == "create"){

        }
        if($action == "update"){
            
        }
        return $data;
    }
}
