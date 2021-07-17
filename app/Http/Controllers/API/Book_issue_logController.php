<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use App\Book;
use App\Book_issue_log;
use App\User;

class Book_issue_logController extends BaseController
{
    public function index()
    {
        $book_issue_log = Book_issue_log::all();


        return $this->sendResponse($book_issue_log->toArray(), 'Book_issue_logs retrieved successfully.');
    }


    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'book_issue_id' => 'required',
            'student_id' => 'required',
            'issue_by' => 'required',
            'issued_at' => 'required',
            //'return_time' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

            $book_issue_log = new Book_issue_log();
            $book_issue_log->book_issue_id = $input['book_issue_id'];
            $book_issue_log->student_id = $input['student_id'];
            $book_issue_log->issue_by = $input['issue_by'];
            $book_issue_log->issued_at = $input['issued_at'];
            $book_issue_log->return_time = $input['return_time'];
            $book_issue_log->save();
            $book_issue_logid = $book_issue_log->id;

           return $this->sendResponse($book_issue_log->toArray(), 'Book_issue_log created successfully.');
    }

    public function show($id)
    {
        $book_issue_log = Book_issue_log::find($id);


        if (is_null($book_issue_log)) {
            return $this->sendError('Book_issue_log not found.');
        }


        return $this->sendResponse($book_issue_log->toArray(), 'Book_issue_log retrieved successfully.');
    }


    public function update(Request $request, Book_issue_log $book_issue_log, $id)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'book_issue_id' => 'required',
            'student_id' => 'required',
            // 'issue_by' => 'required',
            // 'issue_at' => 'required',
            // 'return_time' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

            $book_issue_log = Book_issue_log::find($id);
            $book_issue_log->book_issue_id = $input['book_issue_id'];
            $book_issue_log->student_id = $input['student_id'];
            $book_issue_log->issue_by = $input['issue_by'];
            $book_issue_log->issued_at = $input['issued_at'];
            $book_issue_log->return_time = $input['return_time'];
            $book_issue_log->save();
             $book_issue_logid = $book_issue_log->id;


        return $this->sendResponse($book_issue_log->toArray(), 'Book_issue_log updated successfully.');
    }


    public function destroy(Book_issue_log $book_issue_log, $id)
    { 
        $book_issue_log = Book_issue_log::find($id);
        $book_issue_log->delete();
        $response = "Success";

        return $this->sendResponse($response, 'Book_issue_log deleted successfully.');
    }

    public function showuserwisebook(Request $request)
    {
        $book_issue_log = Book_issue_log::where('student_id', '=', $request->student_id)->get();

        if (is_null($book_issue_log)) {
            return $this->sendError('Book_issue_log not found.');
        }


        return $this->sendResponse($book_issue_log->toArray(), 'Book_issue_log retrieved successfully.');
    }
}
