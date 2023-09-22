<?php
return [
    'STATUS' => [
        "PENDING" => 'En cours',
        "ACTIVE" => 'ACTIVE',
        "BLOCK" => 'BLOCK',
        "REJECT" => 'Rejeté',
        "APPROVED" => 'Vérifié',
    ],
    'GLOBAL_PERMISSIONS' => [ //permission is = permission=>label of permission
        'USERS' => [
            'create users' => 'créer',
            'read users' => 'consulter',
            'update users' => 'modifier',
            'delete users' => 'supprimer',
            'user manage permission' => 'gestion de permission',
        ],
        'TAGS' => [
            'create tags' => 'créer',
            'read tags' => 'consulter',
            'update tags' => 'modifier',
            'delete tags' => 'supprimer',
        ],
        'DOCUMENTS' => [
            'create documents' => 'créer',
            'read documents' => 'consulter',
            'update documents' => 'modifier',
            'delete documents' => 'supprimer',
            // 'verify documents' => 'vérifier',
        ]
    ],
    'TAG_LEVEL_PERMISSIONS' => [
        'read documents in tag ' => 'read',
        'create documents in tag ' => 'create',
        'update documents in tag ' => 'update',
        'delete documents in tag ' => 'delete',
        // 'verify documents in tag ' => 'vérifier',
    ],
    'DOCUMENT_LEVEL_PERMISSIONS' => [
        'read document ' => 'consulter',
        'update document ' => 'modifier',
        'delete document ' => 'supprimer',
        // 'verify document ' => 'vérifier',
    ]
];
