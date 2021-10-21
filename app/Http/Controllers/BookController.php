<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller {

    public function home() {
        $books = Book::all();
        return view('books.show', ['books' => $books]);
    }

    public function addForm() {
        return view('books.add');
    }

    public function owned() {
        $books = Book::where('user_id', Auth::id())->get();
        return view('books.owned', [
            'books'=> $books
        ]);
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
            return back()->withErrors([
                'message' => 'Formulaire incorrect'
            ])->withInput();
        } else {
            DB::table('books')->insert([
                'title' => $request->input('title'),
                'first_cover' => $request->input('first_cover'),
                'publication_date' => $request->input('publication_date'),
                'description' => $request->input('description'),
                'author' => $request->input('author'),
                'genre' => $request->input('genre')
            ]);
        }
        return redirect()->intended('/admin/books/add')
            ->with('message', 'Livre ajouté');
    }
}
