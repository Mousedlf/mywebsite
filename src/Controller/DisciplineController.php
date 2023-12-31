<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('{_locale}/admin/discipline')]
class DisciplineController extends AbstractController
{
    #[Route('/', name: 'app_discipline_index', methods: ['GET'])]
    public function index(DisciplineRepository $disciplineRepository): Response
    {
        return $this->render('discipline/index.html.twig', [
            'disciplines' => $disciplineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_discipline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DisciplineRepository $disciplineRepository): Response
    {
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $disciplineRepository->save($discipline, true);

            return $this->redirectToRoute('app_discipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('discipline/new.html.twig', [
            'discipline' => $discipline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_discipline_show', methods: ['GET'])]
    public function show(Discipline $discipline): Response
    {
        return $this->render('discipline/show.html.twig', [
            'discipline' => $discipline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_discipline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Discipline $discipline, DisciplineRepository $disciplineRepository): Response
    {
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $disciplineRepository->save($discipline, true);

            return $this->redirectToRoute('app_discipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('discipline/edit.html.twig', [
            'discipline' => $discipline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_discipline_delete', methods: ['POST'])]
    public function delete(Request $request, Discipline $discipline, DisciplineRepository $disciplineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discipline->getId(), $request->request->get('_token'))) {
            $disciplineRepository->remove($discipline, true);
        }

        return $this->redirectToRoute('app_discipline_index', [], Response::HTTP_SEE_OTHER);
    }
}
