<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display All books
     * @return Illuminate\Http\Response;
     */

    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books);
    }

    /**
     * Store an Book
     * @param Request $request
     * @return use Illuminate\Http\Response;
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());
        $book->save();

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Show a Book
     * @param Request $request
     * @return use Illuminate\Http\Response;
     */

    public function show($bookId)
    {
        $book = Book::findOrFail($bookId);
        return $this->successResponse($book);
    }

    /**
     * Update a Book
     * @param Request $request
     * @return use Illuminate\Http\Response;
     */
    public function update(Request $request, $bookId)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];
        $this->validate($request, $rules);

        $book = Book::findOrFail($bookId);
        $book->fill($request->all());
        if ($book->isClean()) {
            return $this->errorResponse("Update At least single field", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->update();
        return $this->successResponse($book);
    }

    /**
     * Remove an Book
     * @return use Illuminate\Http\Response;
     */

    public function destroy($bookId)
    {
        $book = Book::findOrFail($bookId);
        $book->delete();

        return $this->successResponse($book);
    }
}
