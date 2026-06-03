<?php

namespace App\Services;

use App\Models\UmkmProfile;

class ProfileCompletionService
{
    /**
     * Calculate profile completion score (0-100%)
     * 
     * Scoring breakdown:
     * - Nama usaha: 15%
     * - Kategori: 15%
     * - Kecamatan: 15%
     * - Deskripsi (min 50 chars): 15%
     * - WhatsApp: 15%
     * - Logo/Foto: 15%
     * - Lokasi (optional): 10%
     */
    public function calculateScore(UmkmProfile $profile): int
    {
        $score = 0;
        
        // Nama usaha (15%)
        if (!empty(trim($profile->nama_usaha ?? ''))) {
            $score += 15;
        }
        
        // Kategori (15%)
        if ($profile->kategori_id) {
            $score += 15;
        }
        
        // Kecamatan (15%)
        if ($profile->kecamatan_id) {
            $score += 15;
        }
        
        // Deskripsi min 50 chars (15%)
        $deskripsi = trim($profile->deskripsi ?? '');
        if (!empty($deskripsi) && strlen($deskripsi) >= 50) {
            $score += 15;
        }
        
        // WhatsApp (15%)
        if (!empty(trim($profile->whatsapp ?? ''))) {
            $score += 15;
        }
        
        // Logo atau foto (15%)
        if ($profile->logo_path || (!empty($profile->photos) && count($profile->photos) > 0)) {
            $score += 15;
        }
        
        // Lokasi - optional (10%)
        if ($profile->latitude && $profile->longitude) {
            $score += 10;
        }
        
        return $score;
    }
    
    /**
     * Get profile status based on completion score
     * 
     * @param int $score Completion score (0-100)
     * @return string Status label in Indonesian
     */
    public function getStatus(int $score): string
    {
        if ($score < 50) {
            return 'Profil Dasar';
        } elseif ($score < 80) {
            return 'Profil Lengkap';
        } else {
            return 'Profil Optimal';
        }
    }
    
    /**
     * Get status color based on completion score
     * 
     * @param int $score Completion score (0-100)
     * @return string Color class (red, yellow, green)
     */
    public function getStatusColor(int $score): string
    {
        if ($score < 50) {
            return 'red';
        } elseif ($score < 80) {
            return 'yellow';
        } else {
            return 'green';
        }
    }
    
    /**
     * Get list of missing fields with friendly messages
     * 
     * @param UmkmProfile $profile
     * @return array Array of missing field messages
     */
    public function getMissingFields(UmkmProfile $profile): array
    {
        $missing = [];
        
        if (empty(trim($profile->nama_usaha ?? ''))) {
            $missing[] = 'Nama usaha belum diisi';
        }
        
        if (!$profile->kategori_id) {
            $missing[] = 'Kategori belum dipilih';
        }
        
        if (!$profile->kecamatan_id) {
            $missing[] = 'Kecamatan belum dipilih';
        }
        
        $deskripsi = trim($profile->deskripsi ?? '');
        if (empty($deskripsi) || strlen($deskripsi) < 50) {
            $missing[] = 'Deskripsi terlalu singkat (minimal 50 karakter)';
        }
        
        if (empty(trim($profile->whatsapp ?? ''))) {
            $missing[] = 'Nomor WhatsApp belum diisi';
        }
        
        if (!$profile->logo_path && (empty($profile->photos) || count($profile->photos) === 0)) {
            $missing[] = 'Belum ada foto usaha (minimal 1 foto dianjurkan)';
        }
        
        if (!$profile->latitude || !$profile->longitude) {
            $missing[] = 'Lokasi usaha belum ditambahkan (opsional)';
        }
        
        return $missing;
    }
}
