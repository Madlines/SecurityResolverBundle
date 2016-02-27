<?php

namespace Madlines\SecurityResolverBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class VotersAddingCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $resolverDefinition = $container->findDefinition('madlines.security_resolver.access_resolver');
        $tags = $container->findTaggedServiceIds('madlines.security_resolver.voter');

        foreach ($tags as $id => $attrs) {
            $method = isset($attrs[0]['method']) ? $attrs[0]['method'] : 'isGranted';
            $resolverDefinition->addMethodCall(
                'addVoter',
                [new Reference($id), $method]
            );
        }
    }

}
