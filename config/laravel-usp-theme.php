<?php

$menu = [
    [
        'text' => '<i class="fa fa-user-clock"></i> Registrar ponto',
        'url' => '/registros/create',
    ],
    [
        'text' => '<i class="fa fa-user-tie"></i> Pessoas',
        'can'  => 'admin',
  
        'submenu' => [
            [
                'text' => 'Pessoas',
                'url'  => '/pessoas',
                'can' => 'logado', 
            ],
            [
                'type' => 'divider',
            ],
            [
                'text' => 'Grupos',
                'url'  => '/grupos',
                'can' => 'logado', 
            ],
        ],
    ],
    [
        'text' => '<i class="fa fa-building"></i> Locais',
        'url'  => '/places',
        'can'  => 'admin'
    ],
    [
        'text' => 'Ocorrências',
        'can' => 'logado', 
    
            'submenu' => [
                [
                    'text' => 'Registrar ocorrência',
                    'url'  => '/ocorrencias/create',
                    'can' => 'logado', 
                ],
                [
                    'type' => 'divider',
                ],
                [
                    'text' => 'Registradas',
                    'url'  => '/ocorrencias',
                    'can' => 'logado', 
                ],
                [
                    'type' => 'divider',
                ],
                [
                    'text' => 'Resolvidas',
                    'url'  => '/ocorrencias/solved',
                    'can' => 'logado', 
                ],
            ],
    ],
        
];

$right_menu = [
    [
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
];

return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title' => config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação
    'skin' => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key' => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url' => config('app.url'),

    # login e logout
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',

    # menus
    'menu' => $menu,
    'right_menu' => $right_menu,
];
