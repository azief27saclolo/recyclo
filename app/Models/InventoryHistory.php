<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
        'field_name',
        'notes'
    ];

    /**
     * Get the post that owns the history entry.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user who made the change.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
