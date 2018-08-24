<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(
        $slug
//        , Environment $twigEnvironment
    )
    {
        $comments = [
            'dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla',
            'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia',
            'deserunt mollit anim id est laborum.'
        ];

//        dump($slug,$this, $GLOBALS);

        // Dont do that! :D
//        $html = $twigEnvironment->render('article/show.html.twig',
//            [
//                'title' => ucwords(str_replace('-', ' ', $slug)),
//                'slug' => $slug,
//                'comments' => $comments
//            ]);
//
//        return new Response($html);


        return $this->render('article/show.html.twig',
            [
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'comments' => $comments
            ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
//        TODO - actually heart/unheart the article

//        return new JsonResponse(['hearts' => rand(5,100)]);
        $logger->info('Article is being hearted');

        return $this->json(['hearts' => rand(5, 100)]);
    }
}