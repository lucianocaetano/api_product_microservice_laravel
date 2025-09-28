<?php declare(strict_types=1);

return [
    'hosts' => [
        env('OPENSEARCH_HOST', 'http://localhost:9200'),
    ],
    'retries' => 2,
    'logging' => true,  ];
