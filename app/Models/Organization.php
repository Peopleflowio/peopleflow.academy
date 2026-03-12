<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Organization extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','email'];
    public function users() { return $this->hasMany(User::class); }
    public function purchases() { return $this->hasMany(Purchase::class); }
    public function seatLicenses() { return $this->hasMany(SeatLicense::class); }
}
