<?php

namespace Madlines\SecurityResolverBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MadlinesSecurityResolverBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new VotersAddingCompilerPass());
    }
}
