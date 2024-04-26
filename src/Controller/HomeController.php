<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    #[Route('/')]
    public function indexNoLocale(): Response
    {
       return $this->redirectToRoute('app_home', ['_locale' => 'en']);
    }



    #[Route('{_locale}/', name: 'app_home')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $nonDevProjects = [];
        $devProjects = [];
        //dd($projectRepository->findAll());


        foreach ($projectRepository->findAll() as $project) {
            if($project->getDiscipline()->getName() != "web development") {
                $nonDevProjects[] = $project;
            }
            else {
                $devProjects[] = $project;
            }
        }


        return $this->render('home/index.html.twig', [
            'nonDevProjects' => $nonDevProjects,
            'devProjects' => $devProjects,
        ]);
    }


}
