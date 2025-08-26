<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Constants;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

#[Route('/locale')]
class LocaleController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function set(Request $request, ValidatorInterface $validator,): Response
    {
        $locale = $request->request->get('locale');


        if ($locale) {
            $violations = $validator->validate($locale, [
                new NotBlank(),
                new Choice(choices: $this->getParameter('managed_locales')),
            ]);
        }
        if (0=== $violations->count()){
            $request->getSession()->set('locale', $locale);
            return $this->redirectToRoute('app_home');
        }

        throw new UnprocessableEntityHttpException(
        sprintf(
            'Locale should be in (%s)',
            implode(', ', $this->getParameter('managed_locales'))
        )
    );

    }
}
