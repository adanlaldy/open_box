<?php

namespace App\Models;

use App\Models\category;
use App\Models\user;
use App\Models\attachment;
use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'sender_user_id',
        'receiver_user_id',
        'cc_user_id',
        'bcc_user_id',
        'object',
        'content',
        'sent_at',
        'starred',
        'attachment',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    public function cc()
    {
        return $this->belongsTo(User::class, 'cc_user_id');
    }

    public function bcc()
    {
        return $this->belongsTo(User::class, 'bcc_user_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
