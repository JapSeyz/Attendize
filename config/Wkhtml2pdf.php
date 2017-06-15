<?php

return [

    'debug'       => env('APP_DEBUG_PDF', false),
    'binpath'     => env('WKHTML2PDF_BIN_PATH', 'lib/'),
    'binfile'     => env('WKHTML2PDF_BIN_FILE', 'wkhtmltopdf-amd64'),
    'output_mode' => 'I',
];
