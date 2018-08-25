<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Tests\Fixtures\includes\HotPath\P1;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArticleController extends AbstractController
{
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('article/homepage.html.twig', [
                'articles' => $articles
            ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(
        $slug,
        SlackClient $slack,
        EntityManagerInterface $em
//        , Environment $twigEnvironment
    )
    {
        if ($slug == 'khaaaan') {
            $slack->sendMessage('Khan', 'Wysyłam do slaczka wiadomość');
        }

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        $comments = [
            'dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla',
            'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia',
            'deserunt mollit anim id est laborum.'
        ];

        return $this->render('article/show.html.twig',
            [
                'article' => $article,
                'comments' => $comments
            ]);

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