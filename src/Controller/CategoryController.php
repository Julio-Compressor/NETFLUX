<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends abstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
            }
        $programs= $programRepository->findby(['category' => $category], ['id' => 'DESC'], 3);
        return $this->render('category/show.html.twig', ['programs' => $programs , 'category' => $category]);

    }

}