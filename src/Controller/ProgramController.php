<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }
    #[Route('/newProgram', name: 'new_program')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();
            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new_program.html.twig', [
            'form' => $form,
        ]);

    }
    #[Route('/{id}', requirements: ['id'=>'\d+'], methods: ['GET'], name: 'show')]
    public function show(Program $program, $id):Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        $seasons = $program->getSeasons();
        return $this->render('program/show.html.twig', [
        'program' => $program,
        'seasons' => $seasons,
        ]);
    }

    #[Route('/{program}/season/{season}', requirements: ['programId'=>'\d+', 'seasonId'=>'\d+'], methods: ['GET'], name: 'season_show')]
    public function SeasonShow(Program $program, Season $season): Response
    {
        $program = $season->getProgram();
        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'program' => $program,
        ]);
    }
    #[Route('/{program}/season/{season}/episode/{episode}', requirements: ['programId'=>'\d+', 'seasonId'=>'\d+'], methods: ['GET'], name: 'episode_show')]
    public function EpisodeShow(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render('program/episode_show.html.twig', [
            'episode' => $episode,
            'program' => $program,
            'season' => $season,
        ]);
    }
}