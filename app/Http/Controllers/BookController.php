<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function rent(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id', function ($value, $fail) {
                $user = User::findOrFail($value);
                if ($user->user_type != User::USER_TYPE_STUDENT) {
                    return $fail('The user is not a student');
                }
            }],
            'librarian_id' => ['required', 'exists:users,id', function ($value, $fail) {
                $user = User::findOrFail($value);
                if ($user->user_type != User::USER_TYPE_LIBRARIAN) {
                    return $fail('The user is not a librarian');
                }
            }],
        ]);

        $book = Book::findOrFail($request->input('book_id'));

        if ($book->available_copies == 0) {
            return response()->json([
                'error' => 'All copies rented out',
            ], 422);
        }

        $book->available_copies -= 1;
        $book->save();

        return Book::create([
            'user_id' => $request->input('user_id'),
            'librarian_id' => $request->input('librarian_id'),
            'book_id' => $request->input('book_id'),
        ]);
    }
}
