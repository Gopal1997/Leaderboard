<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by Day / Month / Year
        if ($request->filter) {
            $filter = $request->filter;
            if ($filter === 'day') {
                $query->whereHas('activities', function ($q) {
                    $q->whereDate('performed_at', now()->toDateString());
                });
            } elseif ($filter === 'month') {
                $query->whereHas('activities', function ($q) {
                    $q->whereMonth('performed_at', now()->month)
                      ->whereYear('performed_at', now()->year);
                });
            } elseif ($filter === 'year') {
                $query->whereHas('activities', function ($q) {
                    $q->whereYear('performed_at', now()->year);
                });
            }
        }

        $users = $query->orderBy('rank')->get();

        // Search by user ID
        if ($request->search_id) {
            $searchId = $request->search_id;
            $searched = $users->where('id', $searchId)->first();
            if ($searched) {
                $others = $users->filter(fn($u) => $u->id != $searchId);
                $users = collect([$searched])->merge($others);
            }
        }

        return view('leaderboard.index', [
            'users' => $users
        ]);
    }

    public function recalculate()
    {
        $perPoint = Activity::PER_POINT;
        $users = User::all();

        foreach ($users as $user) {
            $activityCount = Activity::where('user_id', $user->id)->count();
            $user->total_points = $activityCount * $perPoint;
            $user->save();
        }

        $rank = 1;
        $lastPoints = null;
        $sharedRank = $rank;
        $sortedUsers = User::orderByDesc('total_points')->get();

        foreach ($sortedUsers as $user) {
            if ($lastPoints !== null && $user->total_points === $lastPoints) { // Same rank
            } else {
                $sharedRank = $rank;
            }

            User::updateOrInsert(
                ['id' => $user->id],
                ['total_points' => $user->total_points, 'rank' => $sharedRank, 'updated_at' => now()]
            );

            $lastPoints = $user->total_points;
            $rank++;
        }

        return redirect()->route('leaderboard.index')->with('success', 'Leaderboard recalculated!');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
