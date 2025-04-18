<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Rap2hpoutre\FastExcel\FastExcel;


class BookController extends Controller
{
    private string $error;

    /**
     * Import books from excel file
     * @return
     * @throws Exception
     */
    public function importBooks(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($request->file('file'));
        $sheets = $spreadsheet->getAllSheets();

        foreach ($sheets as $index => $sheet) {
            $index = $index + 1;
            try {
                (new FastExcel)->sheet($index)->import($request->file('file'), function ($data) use ($sheet) {
                    $data = array_change_key_case($data, CASE_LOWER);
                    if ($data['title']) {
                        return Book::create([
                            'title' => $data['title'],
                            'strand' => $sheet->getTitle(),
                            'reference' => $data['reference no.'],
                            'category' => $data['category'],
                            'track' => $data['track'],
                            'type' => $data['type'],
                            'author' => $data['author'],
                            'status' => 'available',
                            'year' => $data['year']
                        ]);
                    }
                });
            } catch (IOException $e) {
                $this->error .= $e->getMessage();
            } catch (UnsupportedTypeException $e) {
                $this->error .= $e->getMessage();
            } catch (ReaderNotOpenedException $e) {
                $this->error .= $e->getMessage();
            }
        }
       return redirect('/dashboard');
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
