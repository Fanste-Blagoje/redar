<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            
        ]);
    }
    public function datatable(Request $request)
    {
        
        $query = User::query()
                ->with(['house'])
               // ->join('houses', 'users.house_id', '=', 'houses.id')
                //->select(['users.*', 'houses.name AS house_name'])
                ;
        
        $dataTable = \DataTables::of($query);
        
        $dataTable->addColumn('actions', function ($user) {
            return view('admin.users.partials.actions', ['user' => $user]);
        })
        ->editColumn('status', function ($user) {
            return view('admin.users.partials.status', ['user' => $user]);
        })
        ->editColumn('id', function ($user) {
            return '#' . $user->id;
        })
        ->editColumn('name', function ($user) {
            return '<strong>' . e($user->name) .'</strong>';
        })
        ->editColumn('house_id', function ($user) {
                return optional($user->house)->name;
         });
        
        $dataTable->rawColumns(['name', 'actions']);
        
        
        return $dataTable->make(true);
    }
    
    public function add(Request $request)
    {
       return view('admin.users.add', [
            
        ]);
    }
    
    public function insert(Request $request)
    {
       $formData = $request->validate([
           'name' => ['required', 'string', 'max:255', ],
           'email' => ['required', 'email', 'max:255', 'unique:users,email'],
           'house_id' => ['required', 'exists:houses,id'],
       ]);
       
       $formData['status'] = User::STATUS_ENABLED;
       
       $formData['password'] = \Hash::make('12345');
       
       $newUser = new User();
       
       $newUser->fill($formData);
       
       $newUser->save();
       
       session()->flash('system_message', __('New user has been saved'));
       
       return redirect()->route('admin.users.index');
    }
    
    public function edit(Request $request, User $user)
    {
       
       return view('admin.users.edit', [
            'user' => $user,
        ]);
    }
    public function update(Request $request, User $user)
    {
       $formData = $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
           'house_id' => ['required', 'exists:houses,id'],
       ]);
       
       $user->fill($formData);
       
       $user->save();
       
       session()->flash('system_message', __('User has been saved'));
       
       return redirect()->route('admin.houses.index');
    }
    
    public function delete(Request $request)
    {
       $formData = $request->validate([
           'id' => ['required', 'numeric', 'exists:users,id'],
       ]);
       
       $user = User::findOrFail($formData['id']);
       
       $user->delete();
       
       return response()->json([
               'system_message' => __('User has been deleted')
           ]);
    }

    public function disable(Request $request)
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        
        $user = User::findOrFail($formData['id']);
        
        $user->status = User::STATUS_DISABLED;
        
        $user->save();
        
        return response()->json([
               'system_message' => __('User has been disabled')
           ]);
    }
    
    public function enable(Request $request)
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        
        $user = User::findOrFail($formData['id']);
        
        $user->status = User::STATUS_ENABLED;
        
        $user->save();
        
        return response()->json([
               'system_message' => __('User has been enabled')
           ]);
    }
}
