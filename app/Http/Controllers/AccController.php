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

    if ($user->role === 'formateur') {
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
  if (!Auth::check() || Auth::user()->role !== 'formateur') {
    abort(403, 'Unauthorized action.');
  }

    $presence = Presence::where('email', $email)->firstOrFail();

    $presence->statut = $presence->statut === 'present' ? 'absence' : 'present';

    $presence->save();
  return  redirect('absence');
   
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
