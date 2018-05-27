<?php

namespace App\Observer;

use App\Models\FeedCategory;

class FeedCategoryObserver
{
    public function created(FeedCategory $feedCategory)
    {
        $feedCategory->category->incrementsCounter();
    }

    public function deleted(FeedCategory $feedCategory)
    {
        $feedCategory->category->decrementsCounter();
    }
}
