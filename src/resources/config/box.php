<?php

return [
    'modules' => [],
    'event_listeners' => true,
    'views' => [
        'namespace' => 'client'
    ],
    'routes' => [
        'prefix'     => 'client',
        'as'         => 'client.',
        'middleware' => ['web', 'auth', 'acl'],
        'files'      => ['web']
    ],
    'breadcrumbs' => true
];