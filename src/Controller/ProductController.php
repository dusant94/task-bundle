<?php

namespace SolveX\TaskBundle\Controller;

use SolveX\TaskBundle\Service\ProductService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Product;

class ProductController extends FrontendController
{
    #[Route(
        '/product/create-or-update',
        'create-or-update-product',
        methods: ['POST']
    )]
    public function createOrUpdateProduct(Request $request, ProductService $productService): Response
    {
        try{
            $data = json_decode($request->getContent(), true);

            $sku = isset($data['sku']) ?  $data['sku'] : null;
            $name = isset($data['name']) ?  $data['name'] : null;
            $price = isset($data['price']) ? $data['price'] : null;
            if(!$sku || !is_string($sku)){
                return $this->json(['error' => 'sku is missing or is not valid string'], Response::HTTP_BAD_REQUEST);
            }
            if(!$price || !is_numeric($price)){
                return $this->json(['error' => 'price is missing or is not valid number'], Response::HTTP_BAD_REQUEST);
            }

            $product = Product::getBySku($sku, 1);

            if ($product) {
                $productService->updateProduct($product, $name, $price);
                $message = "Product updated successfully.";
            } else {
                $productService->createProduct($sku, $name, $price);
                $message = "Product created successfully.";
            }

            return $this->json([
                'success' => true,
                'message' => $message
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
