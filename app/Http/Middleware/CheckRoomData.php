<?php

namespace App\Http\Middleware;

use App\Models\Bed;
use App\Models\Room;
use Closure;
use Illuminate\Http\Request;

class CheckRoomData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $type
     */
    public function handle(Request $request, Closure $next, $type)
    {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        // Get the authenticated user's ID
        $userId = $request->user()->id;

        // Check for existing data based on the type
        if ($type === 'room') {
            $existingCount = Room::where('user_id', $userId)->count();
            if ($existingCount > 0) {
                return redirect()->back()->with('error', 'You already have room data');
            }
        } elseif ($type === 'bed') {
            $existingCount = Bed::where('user_id', $userId)->count();
            if ($existingCount > 0) {
                return redirect()->back()->with('error', 'You already have bed data');
            }
        }

        return $next($request); // Proceed to the next middleware or request handler
    }
}