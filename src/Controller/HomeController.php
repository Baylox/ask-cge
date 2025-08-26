<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Cache(expires: 'tomorrow midnight', maxage: 3600, public: true)]
    public function index(Request $request, CacheInterface $cache): Response
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
        $cachedData = $cache->get('key', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            usleep(500000);

            return 'the data produced by an expensive computation';
        });



        return $this->render('default/index.html.twig', [
            'data' => $cachedData,
        ]);
    }
}
