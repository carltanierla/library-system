<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrower;
use Carbon\Carbon;
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
                            'year' => $data['year'],
                            'image' => isset($data['image']) ?: 'book' . rand(1,4) . '.png'
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
            'books' => Inertia::defer(fn () => Book::query()
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
                        ->withQueryString()
            ),

            'filters' => Inertia::defer(fn () => $request->only(['search', 'category', 'category_value'])),

            'category'   => Inertia::defer(fn () => Book::distinct()->whereNot('category', '=', '')->get(['category'])->toArray()),
            'track'      => Inertia::defer(fn () => Book::distinct()->whereNot('track', '=', '')->get(['track',])->toArray()),
            'type'       => Inertia::defer(fn () => Book::distinct()->whereNot('type', '=', '')->get(['type'])->toArray()),
            'status'     => Inertia::defer(fn () => Book::distinct()->whereNot('status', '=', '')->get(['status'])->toArray())
        ];
    }

    public function getAllBooks()
    {
        return ['books' => Book::all()];
    }

    public function fetchFrontBooks()
    {
        return Inertia::render('Welcome', $this->getAllBooks());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBook(Request $request)
    {
        $request->validate([
            'title'     => 'required|unique:books',
            'year'      => 'nullable|digits:4|integer|min:1900|max:'.now()->format('Y')
        ]);

        Book::create($request->all());

        return redirect('master-list')->with('success', 'Book created successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateBook(Request $request)
    {
        $request->validate([
            'title'     => 'required|unique:books,title,'. $request->get('book_id'). ',book_id',
            'year'      => 'nullable|digits:4|integer|min:1900|max:'.now()->format('Y')
        ]);

        Book::where('book_id', $request->get('book_id'))->update($request->all());

        return redirect('master-list')->with('success', 'Book updated successfully');
    }

    public function deleteBook(Request $request)
    {
        Book::where('book_id', $request->get('book_id'))->delete();

        return redirect('master-list')->with('success', 'Book updated successfully');
    }

    public function getBooksBorrowHistory(Request $request)
    {
        return Inertia::render('BorrowHistory', $this->getBorrowHistory($request));
    }

    public function getBorrowHistory(Request $request)
    {
        return [
            'borrow_history' => Inertia::defer(fn () => Borrower::query()
                ->whereHas('books', function ($query) use ($request) {
                    $query->when($request->get('search'), function ($query, $search) {
                        return $query->where('title', 'like', "%{$search}%");
                    });
                })
                ->when($request->get('search'), function ($query, $search) {
                    return $query
                        ->orWhere('borrower_name', 'like', "%{$search}%")
                        ->orWhere('borrower_section', 'like', "%{$search}%");
                })
                ->when($request->get('start_date'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        return $query->orWhereBetween('borrowed_at', [
                            Carbon::createFromFormat('m/d/Y', $request->get('start_date'))->startOfDay(),
                            Carbon::createFromFormat('m/d/Y', $request->get('end_date'))->endOfDay()
                            ])
                            ->orWhereBetween('returned_at', [
                                Carbon::createFromFormat('m/d/Y', $request->get('start_date'))->startOfDay(),
                                Carbon::createFromFormat('m/d/Y', $request->get('end_date'))->endOfDay()
                            ]);
                    });
                })
                ->with('books:book_id,title')
                ->paginate(10)
                ->withQueryString()
            ),

            'filters' => Inertia::defer(fn () =>$request->only(['search', 'start_date', 'end_date']))
        ];
    }

    public function exportBookBorrowHistory(Request $request)
    {
        $histories = [];
        $data = $this->getBorrowHistory($request)['borrow_history']->toArray()['data'];
        foreach ($data as $borrowHistory) {
            $histories[] =  [
                'Book Title' => $borrowHistory['books']['title'],
                'Borrower Name' => $borrowHistory['borrower_name'],
                'Borrower Section' => $borrowHistory['borrower_section'],
                'Borrowed Date' => $borrowHistory['borrowed_at'],
                'Returned Date' => $borrowHistory['returned_at'],
            ];
        }

        return (new FastExcel($histories))->download('History-'. now()->toDateString() . '.xlsx');
    }
}
