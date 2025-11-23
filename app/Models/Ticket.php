<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'department_id',
        'subject',
        'message',
        'priority',
        'status',
        'assigned_to',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    // Ticket owner
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Ticket replies
    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    // Ticket category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ticket department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Assigned admin/user
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
