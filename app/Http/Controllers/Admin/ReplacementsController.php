<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Replacement;

class ReplacementsController extends Controller
{
    
    public function index()
    {

        return view('admin.replacements.index', []);
    }

    public function datatable(Request $request)
    {

        $query = Replacement::query()->with(['user', 'house']);

        $dataTable = \DataTables::of($query);

        $dataTable->editColumn('user_id', function ($replacement) {
                return optional($replacement->user)->name;
            })
            ->editColumn('house_id', function ($replacement) {
                return optional($replacement->house)->name;
            })
            ->editColumn('id', function ($replacement) {
                return '#' . $replacement->id;
            })
            ->editColumn('date', function ($replacement) {
                return '<strong>' . e($replacement->date) . '</strong>';
            });

        $dataTable->rawColumns(['date']);


        return $dataTable->make(true);
    }

}
