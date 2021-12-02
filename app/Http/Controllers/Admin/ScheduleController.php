<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Models\House;


class ScheduleController extends Controller
{
    public function index()
    {

        return view('admin.schedule.index', []);
    }

    public function datatable(Request $request)
    {

        $query = Schedule::query()->with(['user', 'house']);

        $dataTable = \DataTables::of($query);

        $dataTable->addColumn('actions', function ($schedule) {
            return view('admin.schedule.partials.actions', ['schedule' => $schedule]);
        })
            ->editColumn('user_id', function ($schedule) {
                return optional($schedule->user)->name;
            })
            ->editColumn('house_id', function ($schedule) {
                return optional($schedule->house)->name;
            })
            ->editColumn('id', function ($schedule) {
                return '#' . $schedule->id;
            })
            ->editColumn('date', function ($schedule) {
                return '<strong>' . e($schedule->date) . '</strong>';
            });

        $dataTable->rawColumns(['date', 'actions']);


        return $dataTable->make(true);
    }



    public function add(Request $request)
    {
        return view('admin.schedule.add', []);
    }

    public function insert(Request $request)
    {
        $formData = $request->validate([
            'date' => ['required', 'date'],
            'house_id' => ['required', 'exists:houses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $existingSchedule = Schedule::where('house_id', $formData['house_id'])
            ->where('date', $formData['date'])
            ->first();


        if ($existingSchedule) {
            throw ValidationException::withMessages([
                'date' => __('Schedule has been created for selected date')
            ]);
        }

        $newSchedule = new Schedule();

        $newSchedule->fill($formData);

        $newSchedule->save();

        session()->flash('system_message', __('New schedule has been saved'));

        return redirect()->route('admin.schedule.index');
    }

    public function edit(Request $request, Schedule $schedule)
    {

        return view('admin.schedule.edit', [
            'schedule' => $schedule,
        ]);
    }
    public function update(Request $request, Schedule $schedule)
    {

        $formData = $request->validate([
            'date' => ['required', 'date'],
            'house_id' => ['required', 'exists:houses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $existingSchedule = Schedule::where('id', '!=', $schedule->id)
            ->where('house_id', $formData['house_id'])
            ->where('date', $formData['date'])
            ->first();


        if ($existingSchedule) {
            throw ValidationException::withMessages([
                'date' => __('Schedule has been created for selected date')
            ]);
        }

        $schedule->fill($formData);

        $schedule->save();

        session()->flash('system_message', __('Schedule has been saved'));

        return redirect()->route('admin.schedule.index');
    }
    
    public function delete(Request $request)
    {
       $formData = $request->validate([
           'id' => ['required', 'numeric', 'exists:schedule,id'],
       ]);
       
       $schedule = Schedule::findOrFail($formData['id']);
       
       $schedule->delete();
       
       return response()->json([
               'system_message' => __('Schedule has been deleted')
           ]);
    }
    
   public function getUser(House $house)
   {
       $user = User::orderBy('name')
               ->select('id', 'name')
               ->where('status', 1)
               ->where('house_id', $house->id)
               ->get();
       
       return response()->json($user);
   }
}
