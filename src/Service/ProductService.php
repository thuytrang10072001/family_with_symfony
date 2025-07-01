<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->findAll();
    }

    public function getProductById(int $id): ?object
    {
        return $this->productRepository->find($id);
    }

    public function getAllOrdersByProductId(int $productId)
    {
        return $this->productRepository->getAllOrdersByProductId($productId);
    }
}