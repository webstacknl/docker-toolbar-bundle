<?php

declare(strict_types=1);

namespace Webstack\DockerToolbarBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DockerDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Throwable $exception = null): void
    {
    }

    public function enabled(): bool
    {
        return '1' === getenv('SYMFONY_DOCKER_ENV');
    }

    public function services(): array
    {
        $services = [];

        foreach (getenv() as $env => $value) {
            if (str_starts_with($env, 'SYMFONY_')) {
                continue;
            }

            if (preg_match('#^(.*)_(HOST|PORT|URL)$#', $env, $match)) {
                $services[$match[1]][$match[2]] = $value;
            }
        }

        $services = array_filter($services, static function (array $service) {
            return array_key_exists('HOST', $service) && array_key_exists('PORT', $service);
        });

        $services = array_filter($services, static function (array $service) {
            return !array_key_exists('URL', $service) || str_starts_with($service['URL'], 'http');
        });

        foreach ($services as $key => $service) {
            $service['LABEL'] = $this->displayName($key);

            if (!array_key_exists('URL', $service)) {
                $service['URL'] = sprintf('%s://%s:%s', 'http', $service['HOST'], $service['PORT']);
            }
        }

        ksort($services);

        return $services;
    }

    private function displayName(string $key): string
    {
        return implode(' ', array_map('ucfirst', array_map('strtolower', explode('_', $key))));
    }

    public function getName(): string
    {
        return 'docker';
    }

    public function reset(): void
    {
        $this->data = [];
    }
}
