<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\Cache;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Cache(expires: 'tomorrow midnight', maxage: 3600, public: true)]
    public function index(Request $request): Response
    {
        $response = new Response();
        // The ETag is a string that must be unique for each version of the document.
        // You are completely free to calculate it as you wish.
        // We'll choose a low-cost method -
        $response->setEtag($request->getLocale());
        if ($response->isNotModified($request)) {
            // Response without body with status "304 Not Modified"
            return $response;
        }

        return $this->render('default/index.html.twig');
    }
}
