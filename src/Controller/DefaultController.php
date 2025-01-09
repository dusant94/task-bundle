<?php

namespace Dusant\TaskBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @Route("/solve_x_task")
     */
    public function indexAction(Request $request): Response
    {
        return new Response('Hello world from solve_x_task');
    }
}
