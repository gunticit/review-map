<?php

namespace App\Http\Controllers;

use App\Exceptions\ProcessException;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;
    
    public function __construct(TagService $tagService){
        $this->tagService = $tagService;
    }

    public function index(Request $request): JsonResponse
    {
        try{
            $data = $this->tagService->list($request);
            $data = TagResource::collection($data)->resource;
            return $this->sendResponse($data, __('common.action_success.list'));
        } catch(\Exception $e){
            throw new ProcessException($e);
        }
    }
}
