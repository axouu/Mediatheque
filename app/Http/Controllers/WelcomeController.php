<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;

class WelcomeController extends Controller {
    public function welcome() {
        $books = Book::where('user_id', null)->get();
        return view('welcome', [
            'books' => $books
        ]);
    }
}
