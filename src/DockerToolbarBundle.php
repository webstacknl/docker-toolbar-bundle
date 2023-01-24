<?php

namespace Webstack\DockerToolbarBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Webstack\DockerToolbarBundle\DataCollector\DockerDataCollector;

class DockerToolbarBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services();
        $services->set(DockerDataCollector::class)
            ->tag('data_collector', [
                'id' => 'docker',
                'template' => '@DockerToolbar/Collector/template.html.twig',
                'priority' => -256, // Before symfony configuration
            ]);
    }
}
