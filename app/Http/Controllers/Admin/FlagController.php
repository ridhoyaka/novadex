<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ProfileFlag;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class FlagController extends Controller
{
    public function store(Request $request, UmkmProfile $profile)
    {
        $validated = $request->validate([
            'flag_type' => 'required|in:inappropriate,duplicate,incomplete,quality',
            'reason' => 'nullable|string|max:500',
        ]);
        
        ProfileFlag::create([
            'umkm_profile_id' => $profile->id,
            'admin_user_id' => auth()->id(),
            'flag_type' => $validated['flag_type'],
            'reason' => $validated['reason'],
            'status' => 'active',
        ]);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'flag_profile',
            'description' => "Flagged profile: {$profile->nama_usaha}",
        ]);
        
        return back()->with('success', 'Profil berhasil ditandai untuk review');
    }
    
    public function resolve(ProfileFlag $flag)
    {
        $flag->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
        
        return back()->with('success', 'Flag berhasil diselesaikan');
    }
    
    public function dismiss(ProfileFlag $flag)
    {
        $flag->update([
            'status' => 'dismissed',
        ]);
        
        return back()->with('success', 'Flag berhasil dibatalkan');
    }
}
