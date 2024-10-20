<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
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


    public function showBookRentalHistory(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $book = Book::findOrFail($request->input('book_id'));

        $this->authorize('librarian', $request->user());

        return $book->rentals;
    }


    public function userRentalHistory(Book $book)
    {
        $this->authorize('librarian', auth()->user());

        return $book->rentals;
    }

    public function rentalBookChart()
    {
        $currentDate = Carbon::now();

        //Rented books but not overdue
        $totalRentedOutNotOverdue = Book::whereNotNull('user_id')
            ->whereNull('returned_at') 
            ->where('due_date', '>=', $currentDate) 
            ->count();

        //Rented and overdue
        $totalRentedOutOverdue = Book::whereNotNull('user_id')
            ->whereNull('returned_at')
            ->where('due_date', '<', $currentDate) 
            ->count();

        return response()->json([
            'totalRentedOutNotOverdue' => $totalRentedOutNotOverdue,
            'totalRentedOutOverdue' => $totalRentedOutOverdue,
        ]);
    }
}
