<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an activity manually.
     *
     * @param string $description Natural language description of the event.
     * @param mixed|null $subject The model related to the event (optional).
     * @param array $properties Additional context data (optional).
     * @return ActivityLog
     */
    public static function log(string $description, $subject = null, array $properties = [])
    {
        $user = Auth::user();
        $branchId = null;

        // 1. Try to get Branch ID from Subject
        if ($subject && isset($subject->branch_id)) {
            $branchId = $subject->branch_id;
        }
        
        // 2. Fallback to User's Branch ID
        if (!$branchId && $user) {
            $branchId = $user->branch_id;
        }

        return ActivityLog::create([
            'user_id'      => $user ? $user->id : null, // Null allowed for system/guest actions (e.g. registration)
            'branch_id'    => $branchId,
            'action'       => 'MANUAL', // Marker that this is a manual log
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject ? $subject->id : null,
            'properties'   => $properties,
        ]);
    }
}
