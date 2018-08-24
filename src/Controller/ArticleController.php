<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function homepage()
    {
        return new Response('first page!!!');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $comments = [
            'dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla',
            'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia',
            'deserunt mollit anim id est laborum.'
        ];

//        dump($slug,$this, $GLOBALS);

        return $this->render('article/show.html.twig',
            [
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'comments' => $comments
            ]);
    }
}