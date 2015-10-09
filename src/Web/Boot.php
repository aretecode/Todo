<?php

namespace Web;

use Aura\Di\ContainerBuilder;
use Radar\Adr\Boot as RadarBoot;

class Boot extends RadarBoot
{
    // only added this so that it would auto resolve
    protected function newContainer(array $config)
    {
        $config = array_merge(['Radar\Adr\Config'], $config);
        return (new ContainerBuilder())->newConfiguredInstance($config, true);
    }
}
