<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller {
    //
    public function home() {
        $books = Book::all();
        return view('books.show', $books);
    }

    public function add(Request $request) {
        $book = $request->all();

        $rules = [
            'title' => 'required|max:255',
            'first_cover' => 'required|max:255',
            'publication_date' => 'required|max:255',
            'description' => 'required|max:500',
            'author' => 'required|max:255',
            'genre' => 'required|max:255'
        ];
        $validator = Validator::make($book, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            DB::table('book')->insert($book);
        }
        return $book;
    }
}
