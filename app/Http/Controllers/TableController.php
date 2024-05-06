<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableResourceCollection;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $tables = Table::latest()->paginate(10);
        return view('tables.index', [
            'tables' => $tables
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function listAll(): JsonResponse
    {
        $tables = Table::latest()->get();
        return $this->jsonResponse(['data' => new TableResourceCollection($tables)]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function listAllApi(): JsonResponse
    {
        $tables = Table::oldest()->get();
        return $this->jsonResponse(['data' => new TableResourceCollection($tables)]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('tables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:tables']
        ]);
        Table::create([
            'name' => $request->name
        ]);
        return Redirect::back()->with("success", "Table has been created");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('tables.edit', [
            'table' => $table
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Table $table): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('tables')->ignore($table->id)]
        ]);
        $table->update([
            'name' => $request->name
        ]);
        return Redirect::back()->with("success", "Table has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();
        return Redirect::back()->with("success", "Table has been deleted.");
    }
}
