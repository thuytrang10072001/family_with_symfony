<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\UriVariable;
use App\Entity\Producr;
use App\State\ProductProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/orders-product/{id}',
            uriVariables: [
                'id' => 'integer'
            ],
            normalizationContext: ['groups' => ['product:read']],
            provider: ProductProvider::class,
        )
    ]
)]
final readonly class ProductApi {}
