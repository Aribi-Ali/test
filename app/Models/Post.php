<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;


    protected $fillable=["title","summary","isPublished","slug","content"];


public function categories(){
    return $this->belongsToMany(Category::class);
}

public function user(){

    return $this->belongsTo(User::class);
}

public function getSuggestedArticles($limit = 8)
    {
        // Get the IDs of all categories associated with the current article
        $categoryIds = $this->categories()->pluck('categories.id')->toArray();
    
        // Get articles with any of the same categories as the current article
        $suggestedArticles = Post::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            }) ->where('isPublished', 1)
            ->where('id', '!=', $this->id)
            ->get();
        
        // If there are not enough suggested articles, retrieve more articles
        if ($suggestedArticles->count() < $limit) {
            $additionalArticles = Post::whereDoesntHave('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                })
                ->where('id', '!=', $this->id)
                ->where('isPublished', 1)
                ->inRandomOrder()
                ->limit($limit - $suggestedArticles->count())
                ->get();
            $suggestedArticles = $suggestedArticles->merge($additionalArticles);
        }
        
        // Limit the result to the specified number of articles
        $suggestedArticles = $suggestedArticles->take($limit);
        
        return $suggestedArticles;
    }
    
}
