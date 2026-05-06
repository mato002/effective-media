<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDownloadRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'company_name',
        'phone',
        'email',
        'filename',
        'source',
    ];
}
