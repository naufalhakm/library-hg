<?php

namespace App\Http\Controllers;

use App\Common\Response\ApiResponse;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $books = Book::with(['category:id,name,description'])->get();
            return $this->successResponse('Books retrieved successfully', $books);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve books', 500, [$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {

            $book = Book::create($validator->validated());

            return $this->successResponse('Book created successfully', $book, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create book', 500, [$e->getMessage()]);
        }
    }

    public function detail($id)
    {
        try {
            $book = Book::with(['category:id,name,description'])->find($id);

            if (!$book) {
                return $this->errorResponse('Book not found', 404);
            }

            return $this->successResponse('Book retrieved successfully', $book);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve book', 500, [$e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $book = Book::find($id);

            if (!$book) {
                return $this->errorResponse('Book not found', 404);
            }

            $book->update($request->only('name', 'description', 'category_id'));
            return $this->successResponse('Book updated successfully', $book);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update book', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::find($id);

            if (!$book) {
                return $this->errorResponse('Book not found', 404);
            }

            $book->delete();
            return $this->successResponse('Book deleted successfully', null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete book', 500, [$e->getMessage()]);
        }
    }
}
