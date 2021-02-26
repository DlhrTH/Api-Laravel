<?php

namespace App\Http\Controllers;

use App\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Borrow $borrow)
    {
        $borrows = Borrow::all();
        return response()->json(["borrows" => $borrows], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'book_id' => 'required',
            'user_id' => 'required',
        ];
        
        $messages = [
            'required' => 'Error',
        ];
        
        $data = $request->validate($rules, $messages);
        $bookD = DB::select('select * from books where id = ?', [$request["book_id"]]);
        $userD = DB::select('select * from users where id = ?', [$request["user_id"]]);
        if ($bookD && $userD){
            $borrow = Borrow::create($data);
            $book = $borrow->book;
            $user = $borrow->user;
            return response()->json(['borrow' => $borrow], 200);
        } else {
            return response()->json(['error'=> 'The user or the book doesn\'t exists'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        //
    }
}
