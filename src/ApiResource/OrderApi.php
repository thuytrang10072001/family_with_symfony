<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\UriVariable;
use App\Entity\Order;
use App\State\OrderProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/order/{id}',
            uriVariables: [
                'id' => 'integer'
            ],
            normalizationContext: ['groups' => ['order:read']],
            provider: OrderProvider::class,
        )
    ]
)]
final readonly class OrderApi {}
