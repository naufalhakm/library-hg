<?php

namespace App\Http\Controllers;

use App\Common\Response\ApiResponse;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    use ApiResponse;

    public function borrowBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        try {
            $borrow = Borrow::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'borrowed_at' => now(),
            ]);

            return $this->successResponse('Book borrowed successfully', $borrow, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Borrowing failed', 500, [$e->getMessage()]);
        }
    }

    public function returnBook($id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            return $this->errorResponse('Borrow record not found', 404);
        }

        if ($borrow->returned_at) {
            return $this->errorResponse('Book already returned', 400);
        }

        try {
            $borrow->update(['returned_at' => now()]);
            return $this->successResponse('Book returned successfully', $borrow);
        } catch (\Exception $e) {
            return $this->errorResponse('Returning failed', 500, [$e->getMessage()]);
        }
    }

    public function borrowedBooks()
    {
        $userID = auth()->id();
        $borrowedBooks = Borrow::where('user_id', $userID)->with(['book:id,title,description'])->get();

        return $this->successResponse('Borrowed books retrieved successfully', $borrowedBooks);
    }
}
