<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Feedback extends Model {
    protected $table = 'feedback';
    protected $fillable = ['user_id','package_id','rating_overall','rating_content','rating_platform','would_recommend','liked','improve','comments'];
    public function user() { return $this->belongsTo(User::class); }
    public function package() { return $this->belongsTo(\App\Models\Academy\Package::class); }
}
