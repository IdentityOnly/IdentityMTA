<?php
return array(
    'mta' => array(
        'type' => 'Zend\Mvc\Router\Http\Literal',
        'may_terminate' => false,
        'options' => array(
            'route' => '/mta',
            'defaults' => array(
                'controller' => 'IdentityMTA\Controller\Receiver',
            ),
            'child_routes' => array(
                'receive' => array(
                    'may_terminate' => true,
                    'options' => array(
                        'action' => 'receive'
                    )
                )
            )
        )
    )
);
