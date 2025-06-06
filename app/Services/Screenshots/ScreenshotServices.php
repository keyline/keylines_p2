<?php

namespace App\Services\Screenshots;

use App\Models\UserScreenshotModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use Exception;

class ScreenshotServices
{
    protected $imageModel;
    protected $uploadDir;
    public function __construct()
    {
        $this->uploadDir = 'public/uploads/screenshot/';
        $this->imageModel = new UserScreenshotModel();
    }

    protected function generateUniqueString($orgId, $userId)
    {
        $timestamp = date('H-i-s-Y-m-d'); // hr-mm-ss-Y-m-d
        return "{$orgId}-{$userId}-{$timestamp}";
    }

    /**
     * @param array $data   The validated request data (all key=>values)
     * @return array        An array representing the inserted image record.
     * @throws Exception    If validation or storage fails.
     */
    public function upload(array $data): array
    {
        // ─────────────────────────────────────────────────────────────
        //  Determine how the “image” was passed
        // ─────────────────────────────────────────────────────────────
        $hasFile   = (isset($data['image']) && $data['image'] instanceof UploadedFile);

        $hasBase64 = (
            isset($data['image'])
            && is_array($data['image'])
            && isset($data['image']['mime'], $data['image']['data'])
        );

        if (! $hasFile && ! $hasBase64) {
            throw new Exception('“image” must be either an UploadedFile or an array with [mime, data].');
        }

        // ─────────────────────────────────────────────────────────────
        //  Build year/day‐only folder under writable/uploads/apps/YYYY/DD/
        // ─────────────────────────────────────────────────────────────
        $now    = Time::now('UTC');
        $year   = $now->getYear();
        $day    = str_pad($now->getDay(), 2, '0', STR_PAD_LEFT); // day of month, two digits

        $uploadDir = $this->uploadDir . "{$year}/{$day}/";

        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Prepare placeholders 
        $filename = '';
        $mimeType = '';
        $byteSize = 0;
        $width    = 0;
        $height   = 0;
        $fullPath = '';

        // ─────────────────────────────────────────────────────────────
        // If “image” is Base64‐encoded
        // ─────────────────────────────────────────────────────────────
        if ($hasBase64) {
            $mimeType  = $data['image']['mime'];   // e.g. "image/png"
            $base64Str = $data['image']['data'];   // e.g. "iVBORw0KGgoAAAANSUhEUgAAA…"

            // Validate MIME (only jpg/jpeg/png allowed here)
            if (! preg_match('#^image/(jpg|jpeg|png)$#i', $mimeType)) {
                throw new Exception('Invalid Base64 mime‐type. Allowed: jpg, jpeg, png');
            }

            // Decode the Base64 payload
            $binary = base64_decode($base64Str);
            if ($binary === false) {
                throw new Exception('Failed to decode Base64 image data.');
            }

            // Enforce max size ≦ 2 MB (2 * 1024 * 1024 bytes)
            $byteSize = strlen($binary);
            if ($byteSize > 2 * 1024 * 1024) {
                throw new Exception('Decoded image exceeds 2 MB.');
            }

            // Validate image and retrieve dimensions
            $imgInfo = @getimagesizefromstring($binary);
            if ($imgInfo === false) {
                throw new Exception('Decoded Base64 data is not a valid image.');
            }
            [$width, $height] = $imgInfo;

            // Derive extension from MIME
            $ext = strtolower(str_replace('image/', '', $mimeType));
            if ($ext === 'jpeg') {
                $ext = 'jpg';
            }

            // Generate a random filename
            $random   = $this->generateUniqueString($data['org_id'], $data['user_id']);
            $filename = "{$random}.{$ext}";
            $fullPath = $uploadDir . $filename;

            // Write the binary data to disk
            if (file_put_contents($fullPath, $binary) === false) {
                throw new Exception('Failed to write decoded Base64 image to disk.');
            }
        }
        // ─────────────────────────────────────────────────────────────
        // If “image” is an UploadedFile (multipart/form‐data)
        // ─────────────────────────────────────────────────────────────
        else {
            /** @var UploadedFile $uploaded */
            $uploaded = $data['image'];

            if (! $uploaded->isValid()) {
                throw new Exception('Uploaded file error: ' . $uploaded->getErrorString());
            }

            $mimeType = $uploaded->getClientMimeType(); // e.g. “image/png”
            $allowed  = ['image/jpeg', 'image/png'];
            if (! in_array($mimeType, $allowed)) {
                throw new Exception("Unsupported mime type: {$mimeType}");
            }

            // Enforce max size ≦ 2 MB
            if ($uploaded->getSize() > 2 * 1024 * 1024) {
                throw new Exception('Uploaded file exceeds 2 MB.');
            }

            // Validate image and retrieve dimensions
            $tmpPath = $uploaded->getTempName();
            $imgInfo = @getimagesize($tmpPath);
            if ($imgInfo === false) {
                throw new Exception('Uploaded file is not a valid image.');
            }
            [$width, $height] = $imgInfo;

            // Generate a random filename with original extension
            $ext      = $uploaded->getExtension();
            $random   = $this->generateUniqueString($data['org_id'], $data['user_id']);
            $filename = "{$random}.{$ext}";
            $fullPath = $uploadDir . $filename;

            // Move the uploaded file to our uploads directory
            if (! $uploaded->move($uploadDir, $filename)) {
                throw new Exception('Failed to move uploaded file to destination.');
            }

            $byteSize = $uploaded->getSize();
        }

        // ─────────────────────────────────────────────────────────────
        //  Insert record into database via AppModel
        // ─────────────────────────────────────────────────────────────

        $relativePath =  "{$year}/{$day}/{$filename}";

        $insertData = [
            'user_id'        => $data['user_id'],
            'org_id'         => $data['org_id'],
            'active_app_name' => $data['app_name'],
            'active_app_url' => $data['app_url'],
            'image_name'     => $relativePath,
            'idle_status'    => 1,
            'time_stamp'     => Time::now()->toDateTimeString(),
        ];

        $newId = $this->imageModel->insert($insertData);
        if (! $newId) {
            // If the insert failed, clean up the uploaded file
            @unlink($fullPath);
            throw new Exception('Failed to insert record into database.');
        }


        $insertData['id'] = $newId;
        return $insertData;
    }


    // get the list of all rows
    public function listAll(): array
    {
        try {
            $images = $this->imageModel->findAll();

            if (!is_array($images)) {
                return [];
            }

            return array_map(function ($image) {
                $image['image_name'] = base_url($this->uploadDir . $image['image_name']);
                return $image;
            }, $images);
        } catch (\Throwable $e) {
            log_message('error', 'Image list failed: ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Failed to retrieve images.',
                'error' => ENVIRONMENT !== 'production' ? $e->getMessage() : null,
            ];
        }
    }
}
