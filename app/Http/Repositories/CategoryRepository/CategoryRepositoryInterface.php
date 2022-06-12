<?php

namespace App\Http\Repositories\CategoryRepository;

interface CategoryRepositoryInterface {
  public function createCategory($Category);

  public function deleteCategoryById($id);

  public function getListCategory();

}