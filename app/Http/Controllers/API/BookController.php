<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\Book;

class BookController extends BaseController
{
    public function index()
    {
        $books = Book::all();


        return $this->sendResponse($books->toArray(), 'Books retrieved successfully.');
    }


    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'book_name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'cover_image' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

            $book = new Book();
            $book->book_name = $input['book_name'];
            $book->author = $input['author'];
            $book->description = $input['description'];

            if( $request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $path = public_path(). '/uploads/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                $book->cover_image = $filename;
            }
             $book->save();
             $bookid = $book->id;

           return $this->sendResponse($bookid->toArray(), 'Book created successfully.');
    }

    public function show($id)
    {
        $book = Book::find($id);


        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }


        return $this->sendResponse($book->toArray(), 'Book retrieved successfully.');
    }


    public function update(Request $request, Book $book, $id)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'book_name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'cover_image' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

            $book = Book::find($id);
            $book->book_name = $input['book_name'];
            $book->author = $input['author'];
            $book->description = $input['description'];

            if( $request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $path = public_path(). '/uploads/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);

                $book->cover_image = $filename;
            }
             $book->save();
             $bookid = $book->id;


        return $this->sendResponse($bookid->toArray(), 'Book updated successfully.');
    }


    public function destroy(Book $book)
    {
        $book->delete();
        $response = "Success";

        return $this->sendResponse($response, 'Book deleted successfully.');
    }
}
