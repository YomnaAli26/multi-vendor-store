<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductController extends Controller
{
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        ImportProducts::dispatch($request->post('count'))
            ->onQueue('import');

        return redirect()->route('dashboard.products.index')
            ->with('success','Import is running...');
    }
}
