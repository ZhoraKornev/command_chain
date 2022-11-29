<?php

namespace Zhora\CommandChainBundle;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CommandChainBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $config = [
            'handlers' => [
                'chain' => [
                    'type' => 'console',
                    'process_psr_3_messages' => true,
                    'channels' => ['chain'],
                    'formatter' => 'monolog.formatter.chain',
                    'verbosity_levels' => [
                        'VERBOSITY_NORMAL' => 'NOTICE',
                    ],
                ],
            ],
        ];

        // prepend
        $builder->prependExtensionConfig('monolog', $config);
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // load an XML, PHP or Yaml file
        $container->import('../Resources/config/services.yaml');
    }
}
