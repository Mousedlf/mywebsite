<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\DisciplineRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    #[Route('/d/{name}', name: 'app_project_discipline', priority: 3)]
    public function index(ProjectRepository $projectRepository, DisciplineRepository $disciplineRepository, Discipline $discipline=null): Response
    {
        $disciplines = $disciplineRepository->findAll();

        if($discipline){
            $projects=$projectRepository->findBy(['discipline' => $discipline]);
        }else{$projects=$projectRepository->findAll();}

        return $this->render('project/index.html.twig', [
            'projects'=>$projects,
            'disciplines'=>$disciplines

        ]);
    }

    #[Route('/{id}', name: 'show_project')]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project'=>$project,
        ]);
    }



    #[Route('/new', name: 'new_project' , priority: 2)]
    #[Route('/edit/{id}', name: 'edit_project', priority: 2)]
    public function create(Request $request, EntityManagerInterface $manager, Project $project=null): Response
    {
        $edit= false;
        $title = "new";

        if($project){
            $edit = true;
            $title = "edit";
        }
        if(!$edit){$project= new Project();}

        $formProject = $this->createForm(ProjectType::class, $project);
        $formProject->handleRequest($request);
        if($formProject->isSubmitted() && $formProject->isValid()){

            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute('app_project');
        }


        return $this->renderForm('project/new.html.twig', [
            'formProject'=>$formProject,
            'edit'=>$edit,
            'title'=>$title
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_project')]
    public function delete(EntityManagerInterface $manager, Project $project): Response
    {
        if($project){
            $manager->remove($project);
            $manager->flush();

        }
        return $this->redirectToRoute('app_project');

    }

}
