<?php

namespace SolveX\TaskBundle\Service;

use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\Service;

class ProductService
{
    public function createProduct(string $sku, ?string $name, float $price): Product
    {
        $folder = Service::createFolderByPath('/Products');
        $product = new Product();
        $key = \Pimcore\Model\Element\Service::getValidKey($sku, 'object');
        $product->setParent($folder);
        $product->setKey($key);
        $product->setSku($sku);
        $product->setName($name);
        $product->setPrice($price);
        $product->setPublished(true);
        $product->save();

        return $product;
    }

    public function updateProduct(Product $product, ?string $name, float $price): Product
    {
        if ($name !== null) {
            $product->setName($name);
        }
        $product->setPrice($price);
        $product->save();

        return $product;
    }
}
