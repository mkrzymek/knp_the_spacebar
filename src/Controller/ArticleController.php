<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
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
        $slug,
        MarkdownHelper $markdownHelper
//        , Environment $twigEnvironment
    )
    {
        $comments = [
            'dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla',
            'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia',
            'deserunt mollit anim id est laborum.'
        ];

        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident beef ribs
aute enim veniam ut cillum pork chuck **picanha**. Dolore reprehenderit labore minim pork belly spare ribs cupim short 
loin in. [Elit exercitation](https://baconipsum.com/) eiusmod dolore cow turkey shank eu pork belly meatball non cupim.

Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur laboris sunt 
venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder, capicola biltong frankfurter boudin
cupim officia. Exercitation fugiat consectetur ham. Adipisicing picanha shank et filet mignon pork belly ut ullamco
. Irure velit turducken ground round doner incididunt occaecat lorem meatball prosciutto quis strip steak.

Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak mollit quis 
officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon strip steak pork belly 
aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur cow est ribeye adipisicing. 
Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck fugiat.
EOF;

        $articleContent = $markdownHelper->parse($articleContent);

        return $this->render('article/show.html.twig',
            [
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'articleContent' => $articleContent,
                'slug' => $slug,
                'comments' => $comments
            ]);

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