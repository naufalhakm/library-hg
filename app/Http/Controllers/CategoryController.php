<?php

namespace App\Http\Controllers;

use App\Common\Response\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponse;
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->successResponse('Categories retrieved successfully', $categories);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve categories', 500, [$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $category = Category::create($request->only('name', 'description'));
            return $this->successResponse('Category created successfully', $category, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create category', 500, [$e->getMessage()]);
        }
    }

    public function detail($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return $this->errorResponse('Category not found', 404);
            }

            return $this->successResponse('Category retrieved successfully', $category);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve category', 500, [$e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $id,
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $category = Category::find($id);

            if (!$category) {
                return $this->errorResponse('Category not found', 404);
            }

            $category->update($request->only('name', 'description'));
            return $this->successResponse('Category updated successfully', $category);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update category', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return $this->errorResponse('Category not found', 404);
            }

            $category->delete();
            return $this->successResponse('Category deleted successfully', null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete category', 500, [$e->getMessage()]);
        }
    }
}
