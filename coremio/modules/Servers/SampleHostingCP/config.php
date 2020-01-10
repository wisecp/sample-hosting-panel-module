<?php
    return [
        'type'                          => "hosting",
        'access-hash'                   => false,
        'server-info-checker'           => false,
        'server-info-port'              => true,
        'server-info-not-secure-port'   => 2082,
        'server-info-secure-port'       => 2083,
        'supported' => [
            'disk-bandwidth-usage',
            'change-password',
        ],
        'configurable-option-params'    => [
            'sample1',
            'sample2',
        ],
    ];