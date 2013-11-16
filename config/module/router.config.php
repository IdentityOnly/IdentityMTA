<?php
return array(
    'routes' => array(
        'mta' => array(
            'type' => 'Literal',
            'may_terminate' => false,
            'options' => array(
                'route' => '/mta',
                'defaults' => array(
                    'controller' => 'IdentityMTA\Controller\Receiver',
                ),
            ),
            'child_routes' => array(
                'receive' => array(
                    'type' => 'Literal',
                    'may_terminate' => true,
                    'options' => array(
                        'route' => '/receive',
                        'defaults' => array(
                            'action' => 'receive'
                        )
                    )
                )
            )
        )
    )
);
