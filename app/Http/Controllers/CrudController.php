<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Book;


class CrudController extends Controller
{
    public function index(){
        $data = Book::paginate(5);
        return Inertia::render('Crud/Index', compact('data'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'publisher' => 'required',
            'year' => 'integer|required',
        ]);
        
        Book::create($validated);

        return redirect()->route('index')->with('message', 'Book created successfully');
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'publisher' => 'required',
            'year' => 'integer|required',
        ]);

        $data = Book::find($id);
        $data->title = $request->title;
        $data->writer = $request->writer;
        $data->publisher = $request->publisher;
        $data->year = $request->year;

        $data->update();

        return redirect()->route('index')->with('message', 'Book edited successfully');
    }

    public function destroy(Book $book){
        $book->delete();

        return redirect()->route('index')->with('message', 'Book deleted successfully');
    }

    public function destroyAll(){
        Book::truncate();
        return redirect()->route('index')->with('message', 'All books deleted successfully');
    }
}
