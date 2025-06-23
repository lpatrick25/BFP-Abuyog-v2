<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatus extends Model
{
    use HasFactory;

    public const NOTICE_COMPLY = 'Issue Notice to Comply';
    public const NOTICE_VIOLATION = 'Issue Notice to Correct Violation';
    public const ABATEMENT_ORDER = 'Issue Abatement Order';
    public const STOPPAGE_ORDER = 'Issue Stoppage of Operation';
    public const COMPLIED = 'Establishment Complied';
    public const CERTIFICATE_RELEASE = 'Establishment Complied';

    protected $fillable = ['application_id', 'status', 'remarks'];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
