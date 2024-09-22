<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Resources\CategoryResource;
use Illuminate\Validation\ValidationException;

class CategoryService {
    protected $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Authenticates the category with the given credentials.
     *
     * @param array $credentials The category's login credentials.
     * @return mixed|null The authenticated category if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $categories = $this->categoryRepository->list($request);
        return $categories;
    }

    public function fullList($request){
        $categories = $this->categoryRepository->list($request);
        return $categories;
    }

    public function create($request){
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/categories', 'public');
            $request->image = $imagePath;
        }
        $category = $this->filterData($request);
        $data = $this->categoryRepository->create($category);
        return $data;
    }

    public function show($id){
        $data = $this->categoryRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $category = $this->filterData($request);
        $data = $this->categoryRepository->update($category, $id);
        return $data; 
    }

    public function delete($id){
        $data = $this->categoryRepository->delete($id);
        return $data;
    }

    private function filterData($request): array{
        return array(
            'name' => $request->name ?? '',
            'slug' => Str::slug($request->name) ?? '',
            'parent_id' => $request->parent ?? null,
            'description' => $request->description ?? '',
            'image' => $request->image ?? '',
            'created_by' => auth()->user()->id ?? null,
        );
    }
}