<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binaries
    |--------------------------------------------------------------------------
    |
    | Paths to ffmpeg nad ffprobe binaries
    |
    */

    'binaries' => [
        'ffmpeg'  => env('FFMPEG', 'ffmpeg/bin/ffmpeg'),
        'ffprobe' => env('FFPROBE', 'ffmpeg/bin/ffprobe')
    ]
];