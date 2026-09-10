<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CalendarEvent extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'calendar_events';

    protected $fillable = [
        'user_id', 'title', 'category', 'date', 'start_time', 'end_time', 'location', 'description'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('calendar_events');
    }
}
