<?php

namespace App\Models;

trait RateableContent
{
    /**
     * Get all of the contents's rates.
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'content');
    }

    public function updateAverageRating()
    {
        $average = $this->ratings->avg('rate');
        $this->avg_rating = Rating::round($average);
        $this->save();
    }
}
