<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Services\UmkmService;

class DashboardController extends Controller
{
    public function __construct(private UmkmService $umkmService)
    {
    }

    public function index()
    {
        $user = auth()->user();
        $profile = $user->umkmProfile;
        
        if (!$profile) {
            return redirect()->route('umkm.profile.edit')
                ->with('info', 'Silakan lengkapi profil usaha Anda');
        }
        
        $completionService = app(\App\Services\ProfileCompletionService::class);
        
        $completion = $completionService->calculateScore($profile);
        $status = $completionService->getStatus($completion);
        $statusColor = $completionService->getStatusColor($completion);
        $missingFields = $completionService->getMissingFields($profile);
        
        // Update score in database
        $profile->update(['profile_completion_score' => $completion]);
        
        // Get active flags if any
        $flags = $profile->flags()->where('status', 'active')->with('admin')->get();
        
        return view('umkm.dashboard', compact(
            'profile',
            'completion',
            'status',
            'statusColor',
            'missingFields',
            'flags'
        ));
    }
}
