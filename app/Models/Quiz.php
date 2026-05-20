<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Quiz extends Model {
    protected $fillable = ['package_id','title','description','pass_percent','is_active'];
    public function package() { return $this->belongsTo(\App\Models\Academy\Package::class); }
    public function questions() { return $this->hasMany(QuizQuestion::class)->orderBy('sort_order'); }
    public function attempts() { return $this->hasMany(QuizAttempt::class); }
}
