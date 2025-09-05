<?php

return [
    'onEveryRequest' => [
        \App\Middlewares\AccessLog::class
    ],
];