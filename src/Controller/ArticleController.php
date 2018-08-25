<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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
    public function homepage(ArticleRepository $repository)
    {
//        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() == 'khaaaan') {
            $slack->sendMessage('Khan', 'Wysyłam do slaczka wiadomość');
        }

//        the same job doing $article
//        $repository = $em->getRepository(Article::class);
//        /** @var Article $article */
//        $article = $repository->findOneBy(['slug' => $slug]);
//
//        if (!$article) {
//            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
//        }

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