<?php

namespace Src\Configurations;

class AvailableDocumentType
{
    static function get() {
        return [
            [
                'mime' => 'text/plain',
                'extension' => 'txt'
            ],
            [
                'mime' => 'image/jpeg',
                'extension' => 'jpeg'
            ],
            [
                'mime' => 'image/png',
                'extension' => 'png'
            ],
            [
                'mime' => 'image/gif',
                'extension' => 'gif'
            ],
            [
                'mime' => 'image/svg+xml',
                'extension' => 'svg'
            ],
            [
                'mime' => 'application/pdf',
                'extension' => 'pdf'
            ],
            [
                'mime' => 'application/msword',
                'extension' => 'doc'
            ],
            [
                'mime' => 'application/vnd.ms-excel',
                'extension' => 'xls'
            ],
            [
                'mime' => 'application/vnd.ms-powerpoint',
                'extension' => 'ppt'
            ],
            [
                'mime' => 'audio/mpeg',
                'extension' => 'mp3'
            ],
            [
                'mime' => 'video/mp4',
                'extension' => 'mp4'
            ],
            [
                'mime' => 'application/zip',
                'extension' => 'zip'
            ],
            [
                'mime' => 'application/x-rar-compressed',
                'extension' =>  'rar'
            ],
            [
                'mime' => 'text/csv',
                'extension' => 'csv'
            ]
        ];
    }
}
