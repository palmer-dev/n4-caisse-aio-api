<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "updated" event.
     * Remove the old image on update to clean the server from unused files
     */
    public function updated(Category $category): void
    {
        if ($category->isDirty( "image" )) {
            $oldImage = $category->getOriginal( "image" );
            if (!empty( $oldImage ))
                \Storage::disk( "public" )->delete( $oldImage );
        }
    }

    /**
     * Handle the Category "force deleted" event.
     * Remove the image on delete to clean the server from unused files
     */
    public function forceDeleted(Category $category): void
    {
        $oldImage = $category->image;

        if (!empty( $oldImage ))
            \Storage::disk( "public" )->delete( $oldImage );
    }
}
