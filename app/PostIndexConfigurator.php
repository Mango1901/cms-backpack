<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class PostIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var array
     */
    protected $name = 'posts_index_write';

    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'analysis' => [
            'analyzer' => [
                'es_std' => [
                    'type' => 'standard',
                    'stopwords' => '_spanish_'
                ]
            ]
        ]
    ];
}
