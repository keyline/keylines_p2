<?php

namespace App\Models;

use CodeIgniter\Model;

class ScreenshotSettingsModel extends Model
{
    protected $table            = 'screenshot_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;


    protected $allowedFields    = [
        'screenshot_resolution',
        'idle_time',
        'screenshot_time',
    ];

    // Dates
    protected $useTimestamps = false;


    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
