<?php

use Illuminate\Support\Facades\Storage;



if (!function_exists('getImageOrPlaceholder')) {
    /**
     * Return the image URL or a placeholder if the image does not exist
     *
     * @param string|null $path
     * @param string|null $size (optional, for example '329x203')
     * @return string
     */
    function getImageOrPlaceholder($path = null, $size = '800x600')
    {
        if ($path) {
            if (str_starts_with($path, 'data:image')) {
                return $path;
            }
            // Allow public assets directly
            if (str_contains($path, '/assets/')) {
                return $path;
            }
            $candidate = $path;
            // Normalize to public disk relative path
            $prefix = asset('storage/');
            if (str_starts_with($candidate, $prefix)) {
                $candidate = substr($candidate, strlen($prefix));
            } elseif (str_starts_with($candidate, '/storage/')) {
                $candidate = substr($candidate, strlen('/storage/'));
            }
            if (Storage::disk('public')->exists($candidate)) {
                return $path;
            }
        }

        // You can customize your placeholder URL here
        // return asset('assets/images/thumbnil.png');
        
        return "https://placehold.co/{$size}?text={$size}";
        
    }
}