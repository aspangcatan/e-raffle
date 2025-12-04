<?php

namespace App\Http\Controllers;

use App\Models\RaffleEntry;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    // Show upload form and entries list
    public function showEntries(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = RaffleEntry::query();

        if ($status === 'winner') {
            $query->where('status', 1);
        } elseif ($status === 'loser') {
            $query->where('status', 0);
        }

        $entries = $query->orderBy('id')->get();

        return view('raffle.entries', compact('entries', 'status'));
    }

    // Handle CSV import
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        if (($handle = fopen($request->file('file')->getPathname(), 'r')) !== false) {
            $isHeader = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($isHeader) {
                    $isHeader = false; // skip header row
                    continue;
                }

                $name = trim($data[0] ?? '');
                if (!empty($name)) {
                    RaffleEntry::create(['name' => $name, 'status' => 0]);
                }
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', 'CSV imported successfully!');
    }

    // Draw a random winner
    public function draw()
    {
        $entries = RaffleEntry::pluck('name')->toArray();

        if (count($entries) == 0) {
            return view('raffle.draw', ['entries' => [], 'message' => 'No entries left to draw from.']);
        }

        // Limit wheel to max 30 random entries for performance
        $wheelEntries = count($entries) > 30
            ? collect($entries)->random(30)->toArray()
            : $entries;

        return view('raffle.draw', ['entries' => $wheelEntries, 'message' => null]);
    }

    public function deleteWinner(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        RaffleEntry::where('name', $request->name)->delete();

        return response()->json(['success' => true]);
    }

    public function clearEntries()
    {
        \App\Models\RaffleEntry::truncate(); // deletes all rows and resets auto-increment

        return redirect()->route('raffle.entries')->with('success', 'All raffle entries have been cleared.');
    }

    public function deleteEntry($id)
    {
        $entry = \App\Models\RaffleEntry::findOrFail($id);
        $entry->delete();

        return redirect()->route('raffle.entries')->with('success', 'Entry deleted successfully.');
    }

    public function drawWinner($id)
    {
        $entry = \App\Models\RaffleEntry::find($id);
        if (!$entry) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json(['name' => $entry->name]);
    }


    public function pickRandomWinner()
    {
        // Pick only entries that are not yet winners (status = 0)
        $winner = RaffleEntry::where('status', 0)
            ->inRandomOrder()
            ->first();

        if (!$winner) {
            return response()->json(['error' => 'No more entries available'], 404);
        }

        // Update status to 1
        $winner->status = 1;
        $winner->save();

        return response()->json([
            'id' => $winner->id,
            'name' => $winner->name,
        ]);
    }
}
