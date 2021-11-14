<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");


class ArticlesController extends AbstractController
{
    // Route de récupération des articles
    #[Route('/api/article', name: 'api_article_index', methods: ["GET"])]

    public function article(ArticleRepository $ArticleRepository): Response
    {

        return $this->json($ArticleRepository->findAll(), 200, []);
    }
}
