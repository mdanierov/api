<?php

use DI\ContainerBuilder;

$definitions = require dirname(__DIR__) . '/app/DependencyInjection/loader.php';
$definitions = array_merge(...array_merge(...$definitions));

$definitions['kernel.project_dir'] = dirname(__DIR__);

$builder = new ContainerBuilder();
$builder->addDefinitions($definitions);

return $builder->build();