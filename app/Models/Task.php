<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'name',
        'phase_id',
        'user_id',
        'completed_at',
        'priority_id',
        'attachment',
        'description',
        'due_date'
    ];

    use HasFactory;
    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ? url('/') . $value : null,
        );
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
