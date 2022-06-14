<?php
namespace App\Http\Controllers;
use App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {       
        $this->categoryRepository = $categoryRepository;
        $this->middleware('auth:api');
    }

    public function getListCategory(){
        $result = $this->categoryRepository->getListCategory();
        return response()->json([
            'message' => 'Successfully get',
            'data' => $result
        ],200);
    }

    public function createCategory(){
        $input = request()->all();
        $this->categoryRepository->createCategory($input);
        return response()->json([
            'message' => 'Successfully Created ',
            'data' =>  $input
        ],201);
    }

    public function deleteCategoryById($id){
        $this->categoryRepository->deleteCategoryById($id);
        return response()->json([
            'message' => 'Successfully delete ',
        ],200);
    }
}
