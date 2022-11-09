<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\GraphQl\Resolver\Stage;

use ApiPlatform\Metadata\GraphQl\Operation;
use ApiPlatform\Symfony\Security\ResourceAccessCheckerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Security stage of GraphQL resolvers.
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class SecurityStage implements SecurityStageInterface
{
    public function __construct(private readonly ?ResourceAccessCheckerInterface $resourceAccessChecker)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(string $resourceClass, Operation $operation, array $context): void
    {
        $isGranted = $operation->getSecurity();

        if (null !== $isGranted && null === $this->resourceAccessChecker) {
            throw new \LogicException('Cannot check security expression when SecurityBundle is not installed. Try running "composer require symfony/security-bundle".');
        }

        if (null === $isGranted || $this->resourceAccessChecker->isGranted($resourceClass, (string) $isGranted, $context['extra_variables'])) {
            return;
        }

        throw new AccessDeniedHttpException($operation->getSecurityMessage() ?? 'Access Denied.');
    }
}
