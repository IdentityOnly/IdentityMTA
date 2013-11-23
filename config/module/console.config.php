<?php
return array(
    'router' => array(
        'routes' => array(
            'mta-receive' => array(
                'options' => array(
                    'route' => 'mta-receive <message>',
                    'defaults' => array(
                        'controller' => 'IdentityMTA\Controller\Receiver',
                        'action' => 'receive'
                    )
                )
            )
        )
    )
);
