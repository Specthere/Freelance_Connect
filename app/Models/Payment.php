<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $fillable = [
        'detail_project_id',
        'payment_date',
        'status',
        'confirm'
    ];

    // Pastikan enum values didefinisikan
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    public function detailProject()
    {
        return $this->belongsTo(DetailProject::class, 'detail_project_id');
    }

    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            DetailProject::class,
            'id', // Foreign key on detail_projects table
            'id', // Foreign key on projects table
            'detail_project_id', // Local key on payments table
            'project_id' // Local key on detail_projects table
        );
    }
}
