<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FPDF;
use App\Entity\Deck;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/{id}", name="pdf")
     */
    public function generatePdf(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $deck = $entityManager->getRepository(Deck::class)->find($id);

        // Si l'entité n'existe pas, retourne une erreur 404
        if (!$deck) {
            throw $this->createNotFoundException('L\'entité n\'existe pas.');
        }

        // Création d'un nouveau PDF
        $pdf = new FPDF();

        // Ajout d'une page
        $pdf->AddPage();

        // Ajout de texte en utilisant l'entité récupérée
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Nom du deck : '.$deck->getTitre());

        // Génération du PDF et envoi de la réponse
        $pdfContent = $pdf->Output('S');
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="deck.pdf"');

        return $response;
    }
}
