<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccController extends Controller
{ 
      public function absc(){
          $user = Auth::user();

          // Admins and formateurs can see and manage all presences; students only see their own
          if (in_array($user->role, ['formateur', 'admin'])) {
              $students = presence::all();
          } elseif ($user->role === 'student') {
              $students = presence::where('email', $user->email)->get();
          } else {
              abort(403, 'Unauthorized action.');
          }

     return view('absence',compact('students'));
      }

      public function delete($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully!');
}


    public function toggle($email)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['formateur', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        // use the imported `presence` model (lowercase class name in this app)
        $presence = presence::where('email', $email)->firstOrFail();

        // toggle between 'present' and the enum value 'absence'
        $presence->statut = $presence->statut === 'present' ? 'absence' : 'present';

        $presence->save();

        return redirect()->route('absence');
    }
public function schedule(){
  $schedules = Schedule::latest()->get();
  $myPresence = null;

  if (Auth::user()->role === 'student') {
    $myPresence = presence::where('email', Auth::user()->email)->first();
  }

  return view('schedule', compact('schedules', 'myPresence'));
}

}
