<?php

namespace App\Models\Academy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageModule extends Model
{
    use HasFactory;

    protected $table = 'package_modules';

    protected $fillable = [
        'package_id','title','description','emoji_icon','sort_order',
    ];

    protected $casts = ['sort_order' => 'integer'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'module_id')->orderBy('sort_order');
    }

    public function publishedLessons()
    {
        return $this->lessons()->where('is_published', true);
    }
}