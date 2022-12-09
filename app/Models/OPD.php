<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPD extends Model
{
    use HasFactory;
    protected $table = 'opd';
    protected $guarded = []; 
    
    public function users() { 
      return $this->hasMany(User::class);
    }
}
