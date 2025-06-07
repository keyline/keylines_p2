<?php

namespace App\Models;

use CodeIgniter\Model;

class UserScreenshotModel extends Model
{
    protected $table            = 'user_screenshots';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // or 'object' if preferred
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'org_id',
        'active_app_name',
        'active_app_url',
        'time_stamp',
        'idle_status',
        'image_name',
    ];

    protected $useTimestamps = false; // Set to true if you use created_at/updated_at fields

    // Validation rules (optional)
    protected $validationRules    = [
        'user_id'         => 'required|integer',
        'org_id'          => 'required|integer',
        'image_name'      => 'required|string|max_length[255]',
        'time_stamp'      => 'required|valid_date',
        'idle_status'     => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
