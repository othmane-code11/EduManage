<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\presence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Show the upload form.
     */
    public function index(): View
    {
        // For the upload/list page we need the list of uploaded schedules.
        $schedules = Schedule::latest()->get();

        return view('schedule', compact('schedules'));
    }

    /**
     * Handle the PDF upload, persist the record, and redirect.
     *
     * Validation rules:
     *   - title : required string, max 255 chars
     *   - file  : required PDF, max 2 MB (2048 KB)
     *
     * Storage:
     *   - Disk   : public  → storage/app/public/
     *   - Folder : schedules/
     *   - Name   : {uuid}.pdf  (unique, collision-proof)
     *
     * Only the relative path is saved in the database.
     * The full URL is resolved via Storage::url() in the model accessor.
     */
    public function upload(Request $request): RedirectResponse
    {
        // ── 1. Validate ────────────────────────────────────────────────────────
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file'  => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'file.mimes' => 'Only PDF files are accepted.',
            'file.max'   => 'The PDF must not exceed 2 MB.',
        ]);

        // ── 2. Generate a unique file name and store the file ──────────────────
        $uniqueName = Str::uuid() . '.pdf';

        // putFileAs returns the stored path relative to the disk root,
        // e.g. "schedules/550e8400-e29b-41d4-a716-446655440000.pdf"
        $path = $request->file('file')->storeAs(
            'schedules',   // folder inside storage/app/public/
            $uniqueName,
            'public'       // disk
        );

        // ── 3. Persist only the path in the database, record uploader ─────────
        Schedule::create([
            'title'       => $validated['title'],
            'file_path'   => $path,
            'uploaded_by' => auth()->id(),
        ]);

        // ── 4. Redirect with success flash ─────────────────────────────────────
        return redirect()
            ->route('schedules.index')
            ->with('success', 'Schedule "' . $validated['title'] . '" uploaded successfully.');
    }

    /**
     * Update the schedule title.
     */
    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        if (auth()->id() !== $schedule->uploaded_by && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $schedule->update(['title' => $validated['title']]);

        return redirect()->route('schedules.index')->with('success', 'Schedule title updated.');
    }

    /**
     * Delete a schedule and its file.
     */
    public function destroy(Request $request, Schedule $schedule): RedirectResponse
    {
        if (auth()->id() !== $schedule->uploaded_by && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Remove file from storage if exists
        if ($schedule->file_path && \Storage::disk('public')->exists($schedule->file_path)) {
            \Storage::disk('public')->delete($schedule->file_path);
        }

        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted.');
    }
}