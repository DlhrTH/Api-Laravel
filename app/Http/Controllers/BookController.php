<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:30',
            'description' => 'required|max:255',
        ];

        $messages = [
            'required' => 'Error',
        ];

        if ((strlen($request['title'])<=30) && (strlen($request['description'])<=255)){
            $validateD = $request->validate($rules, $messages);
            $book = Book::create($validateD);
            return response()->json(['data' => $book], 200);
        } else {
            return response()->json(['error'=> 'Incorrect lenght data introduced'], 422);
        }
        
        /*$data = $this->transformAndValidateRequest(BookResource::class, $request, $rules);
        $book= Book::create($data);
        return $this->showOne($book, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $this->showOne($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['Success'=> 'Delete correct'], 200);
    }

    public function create(Request $request)
    {   
        /*$book = Book::create([
            'title' => $request['title'],
            'description' => $request['description'],
        ]);*/
    }
}
