<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Models\House;

use Illuminate\Validation\Rule;

class HousesController extends Controller
{
    public function index()
    { 
        //$systemMessage = session()->pull('system_message');
        
       // $houses = House::all();
        
        return view('admin.houses.index', [
            //'houses' => $houses,
            //'systemMessage' =>$systemMessage,
        ]);
    }
    
    public function datatable(Request $request)
    {
//         $houses = House::all();
//         
//         return response()->json([
//             
//         ]);
        
        $query = House::query();
        
        $dataTable = \DataTables::of($query);
        
        $dataTable->addColumn('actions', function ($house) {
            return view('admin.houses.partials.actions', ['house' => $house]);
        })
        ->editColumn('id', function ($house) {
            return '#' . $house->id;
        })
        ->editColumn('name', function ($house) {
            return '<strong>' . e($house->name) .'</strong>';
        });
        
        $dataTable->rawColumns(['name', 'actions']);
        
//        $dataTable->filter(function ($query) use ($request) {
//        
//            if (
//                $request->has('search')
//                && is_array($request->get('search'))
//                && isset($request->get('search')['value'])
//            ) {
//                $searchTerm = $request->get('search')['value'];
//                
//                $query->orWhere('houses.name', 'LIKE', '%' . $searchTerm  . '%');
//            }
//        });
        
        return $dataTable->make(true);
    }
    
    public function add(Request $request)
    {
       return view('admin.houses.add', [
            
        ]);
    }
    
    public function insert(Request $request)
    {
       $formData = $request->validate([
           'name' => ['required', 'string', 'max:10', 'unique:houses,name'],
       ]);
       
       $newHouse = new House();
       
       $newHouse->name = $formData['name'];
       
       $newHouse->fill($formData);
       
       $newHouse->save();
       
       session()->flash('system_message', __('New house has been saved'));
       
       return redirect()->route('admin.houses.index');
    }
    
    public function edit(Request $request, House $house)
    {
       return view('admin.houses.edit', [
            'house' => $house,
        ]);
    }
    public function update(Request $request, House $house)
    {
       $formData = $request->validate([
           'name' => ['required', 'string', 'max:10', Rule::unique('houses')->ignore($house->id),],
       ]);
       
       $house->fill($formData);
       
       $house->save();
       
       session()->flash('system_message', __('House has been saved'));
       
       return redirect()->route('admin.houses.index');
    }
    
    public function delete(Request $request)
    {
       $formData = $request->validate([
           'id' => ['required', 'numeric', 'exists:houses,id'],
       ]);
       
       $house = House::findOrFail($formData['id']);
       
       $house->delete();
       
//       if ($request->wantsJson()) {
//           return response()->json([
//               'system_message' => __('House has been deleted'),
//           ]);
//       }
//       
//       session()->flash('system_message', __('House has been deleted'));
//       
//       return redirect()->route('admin.houses.index');
       
       return response()->json([
               'system_message' => __('House has been deleted')
           ]);
    }
}
