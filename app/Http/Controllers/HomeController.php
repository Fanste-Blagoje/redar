<?php

namespace App\Http\Controllers;

use App\Models\Replacement;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = auth()->user();

        $mySchedule = Schedule::with(['user', 'house', 'replacements'])
                ->where('user_id', $user->id)
                ->where('date', '>=', date('Y-m-d'))
                ->orderBy('date')
                ->get();

        return view('home', [
            'mySchedule' => $mySchedule,
        ]);
    }

    public function replacement(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'exists:schedule,id']
        ]);

        $schedule = Schedule::findOrFail($formData['id']);
        
        $user = auth()->user();

        if ($schedule['user_id'] != $user->id) {
            throw ValidationException::withMessages(['id' => 'Schedule does not belong to you']);
        }

        $existingReplacement = Replacement::where('schedule_id', $schedule->id)
                ->where('user_id', $user->id)
                ->first();

        if ($existingReplacement) {
            throw ValidationException::withMessages(['id' => 'You have already asked for replacement for this schedule']);
        }

        $replacement = new Replacement();

        $replacement->fill([
            'schedule_id' => $schedule->id,
            'user_id' => $user->id,
            'house_id' => $schedule->house_id,
            'date' => $schedule->date,
        ]);

        $replacement->save();

        $nextUser = User::where('status', 1)
                //->where('house_id', $schedule->house_id)
                ->where('id', '>', $user->id)
                ->first();

        if ($nextUser) {
            $schedule->user_id = $nextUser->id;

            $schedule->save();
        }

        session()->flash('system_message', __('Replacement has been saved'));

        return redirect()->route('home');
    }

}
