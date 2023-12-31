<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/notes', name: 'api_notes')]
class NoteController extends AbstractController
{
    #[Route('/', name: '_get_all', methods: ['GET'])]
    public function getAll(NoteRepository $noteRepository): JsonResponse
    {
        return $this->json($noteRepository->findAll());
    }

    #[Route('/', name: '_new', methods: ['POST'])]
    public function new(
        Request                $request,
        EntityManagerInterface $em,
    ): JsonResponse
    {
        $note = new Note();
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title']) || !isset($data['body'])) {
            throw new \Exception('Missing required fields');
        }

        $note->setTitle($data['title']);
        $note->setBody($data['body']);

        $em->persist($note);
        $em->flush();

        return $this->json($note, 201);
    }

    #[Route('/{id}', name: '_get_by_id', methods: ['GET'])]
    public function getById(Note $note): JsonResponse
    {
        return $this->json($note);
    }

    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(
        Note                   $note,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $em->remove($note);
        $em->flush();

        return $this->json(null, 204);
    }

    #[Route('/{id}', name: '_update', methods: ['PUT'])]
    public function update(
        Note                   $note,
        Request                $request,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $note->setTitle($data['title']);
        $note->setBody($data['body']);
        $note->setUpdatedAt(new \DateTimeImmutable());

        $em->flush();

        return $this->json($note);
    }
}