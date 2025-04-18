<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;


class BookController extends Controller
{
    /**
     * Import books from excel file
     * @return
     */
    public function importBooks(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        for ($index = 1; $index <= 20; $index++) {
            $users = (new FastExcel)->sheet($index)->import($request->file('file')->, function ($data) {
                return new Book([
                    'title'     => $data['title'],
                    'strand'    => 'sample',
                    'reference' => $data['reference_no'],
                    'category'  => $data['category'],
                    'track'     => $data['track'],
                    'type'      => $data['type'],
                    'author'    => $data['author'],
                    'status'    => 'available',
                    'year'      => $data['year']
                ]);
            });
        }







//       return redirect()->back();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
