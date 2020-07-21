<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //

    public function add()
    {
        return view('books.addbook');
    }

    public function store(Request $request)
    {

        $rules = Book::getBookRules('edit');
        $messages = Book::getRuleMessages();

        $validInput = Validator::make($request->all(), $rules, $messages);

        if ($validInput->passes()) {
            $newBook = Book::create(['isbn' => $request->isbn, 'bookTitle' => $request->booktitle, 'bookAuthor' => $request->bookauthor]);
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors($validInput)->withInput();
        }

        // return redirect()->to(url('/books/add'));

    }

    public function list()
    {
        $allBooks = Book::getAllBooks();

        return view('books.listBooks', compact('allBooks'));
        // return view('listBooks')->with(['allBooks'=>$allBooks]);
    }
    public function show(Request $request)
    {

        $isbn = decrypt($request->isbn);

        $book = Book::searchBookID($isbn);


        return view('books.showbook', compact('book'));
    }


    public function edit(Request $request)
    {
        $isbn = decrypt($request->isbn);

        $book = Book::searchBookID($isbn);

        return view('books.editbook', compact('book'));
    }

    public function save(Request $request)
    {
        $rules = Book::getBookRules('edit');

        // dd($rules);

        $messages = Book::getRuleMessages();

        $validInput = Validator::make($request->all(), $rules, $messages);

        if ($validInput->passes()) {
            $bookToUpdate = Book::searchBookID($request->isbn);

            $bookToUpdate->bookTitle = $request->booktitle;
            $bookToUpdate->bookAuthor = $request->bookauthor;

            $bookToUpdate->save();

            return redirect()->to(url('/books/list'));
        } else {
            return redirect()->back()->withErrors($validInput)->withInput();
        }
    }
    public function remove(Request $request)
    {
        $bookremoved = Book::searchBookID(decrypt($request->isbn));

        $bookremoved->delete();
        return redirect()->to(url('/books/list'))->with(['message' => 'Deletion Successful!!']);
    }
}
