<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
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
                    if (!empty($data['title'])) {
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
       return redirect('import-excel-file');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('MasterList', $this->getBooks($request));
    }

    public function getBooks(Request $request)
    {
       return [
            'books' => Book::query()
                        ->when($request->get('search'), function ($query, $search) {
                            $query->where(function ($query) use ($search) {
                                return $query->where('title', 'like', "%{$search}%")
                                    ->orWhere('author', 'like', "%{$search}%")
                                    ->orWhere('year', 'like', "%{$search}%")
                                    ->orWhere('reference', 'like', "%{$search}%");
                            });
                        })
                        ->when($request->get('category_value'), function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                return $query->where($request->get('category'),  $request->get('category_value'));
                            });
                        })
                        ->orderBy('book_id', 'desc')
                        ->paginate(10)
                        ->withQueryString(),

            'filters' => $request->only(['search', 'category', 'category_value']),

            'category'   => Book::distinct()->whereNot('category', '=', '')->get(['category'])->toArray(),
            'track'      => Book::distinct()->whereNot('track', '=', '')->get(['track',])->toArray(),
            'type'       => Book::distinct()->whereNot('type', '=', '')->get(['type'])->toArray(),
            'status'     => Book::distinct()->whereNot('status', '=', '')->get(['status'])->toArray(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBooks(Request $request)
    {
        $request->validate([
            'title'     => 'required|unique:books',
            'year'      => 'nullable|digits:4|integer|min:1900|max:'.now()->format('Y')
        ]);

        Book::create($request->all());

        return redirect('master-list')->with('success', 'Book created successfully');
    }
}
