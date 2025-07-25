<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartupAccessRequest extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'investor_id',
        'startup_id',
        'message',
        'status',
        'response_message',
    ];
    
    /**
     * Get the investor that made the request.
     */
    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }
    
    /**
     * Get the startup that the request is for.
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }
}