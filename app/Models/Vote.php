<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'slug'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'id']
            ]
        ];
    }

    // Active
    public function scopeActive($q, $take = null){
        $q->where('status', 1);
        $q->latest('id');
        if($take){
            $q->take($take);
        }
    }

    // Media
    public function Media(){
        return $this->belongsTo(Media::class);
    }

    public function getImgPathsAttribute(){
        if($this->Media){
            return $this->Media->paths;
        }else{
            return [
                'original' => asset('img/no-image.png'),
                'small' => asset('img/no-image.png'),
                'medium' => asset('img/no-image.png'),
                'large' => asset('img/no-image.png')
            ];
        }
    }

    public function Questions(){
        return $this->hasMany(VoteQuestion::class);
    }

    public function voteAnswer()
    {
        return $this->hasMany(VoteAnswer::class);
    }
}
