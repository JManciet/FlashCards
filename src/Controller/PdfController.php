<?php

namespace App\Controller;

use FPDF;
use App\Entity\Deck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{



    private $nbrColonne;
    private $nbrLigne;
    private $colonneEnCour;
    private $ligneEnCour;
    private $rectWidth;
    private $rectHeight;
    private $rectX;
    private $rectY;
    private $pdf;



    /**
     * @Route("/pdf/{id}", name="pdf", methods={"GET"})
     */
    public function generatePdf(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $deck = $entityManager->getRepository(Deck::class)->find($id);

        $cartesDeck = $deck->getCartes();

        // Si l'entité n'existe pas, retourne une erreur 404
        if (!$deck) {
            throw $this->createNotFoundException('L\'entité n\'existe pas.');
        }


        $this->nbrColonne =  $request->query->get('X');
        $this->nbrLigne =  $request->query->get('Y');


        // Définition de la taille et de la position des rectangles
        $this->rectWidth = 210 / $this->nbrColonne;
        $this->rectHeight = 297 / $this->nbrLigne;
        $this->rectX = 0;
        $this->rectY = 0;


        // Création d'un nouveau PDF
        $this->pdf = new FPDF();

        // Ajout d'une page
        $this->pdf->AddPage();


        // Ajout de texte en utilisant l'entité récupérée
        $this->pdf->SetFont('Arial','B',16);

        // foreach($cartesDeck as $carte){

        // $pdf->Cell(50,0,'Question de la carte: '.$carte->getQuestion());

        // }


        $this->colonneEnCour = -1;
        $this->ligneEnCour = 0;

        $this->faireRecto($cartesDeck);

        // Génération du PDF et envoi de la réponse
        $pdfContent = $this->pdf->Output('S');
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="deck.pdf"');

        return $response;
    }


    function faireRecto($cartesDeck){
            
        // Parcours du tableau et ajout de chaque élément dans un rectangle distinct
        foreach ($cartesDeck as $index => $carte) {


            $this->colonneEnCour++;

            if($this->colonneEnCour == $this->nbrColonne){
                // Rangée pleine, je commence une nouvelle rangée
                $this->colonneEnCour=0;
                $this->ligneEnCour++;
                if ($this->ligneEnCour == $this->nbrLigne) {
                    // Fin de la page atteinte, je commence une nouvelle page
                    $this->colonneEnCour=-1;
                    $this->ligneEnCour=0;
                    $this->pdf->AddPage();
                    $this->faireVerso($cartesDeck);
                    return;
                }
            }


            $x = $this->rectX + $this->colonneEnCour * $this->rectWidth;
            $y = $this->rectY + $this->ligneEnCour * $this->rectHeight;

            $this->dessinerRectangleAvecText($this->pdf, $x, $y, $this->rectWidth, $this->rectHeight, $carte->getQuestion());

            $lastCarte = $cartesDeck->last();

            if($carte === $lastCarte){
                $this->colonneEnCour=-1;
                $this->ligneEnCour=0;
                $this->pdf->AddPage();
                $this->faireVerso($cartesDeck);
            }
        }
    }

    function faireVerso($cartesDeck){

        // Parcours du tableau et ajout de chaque élément dans un rectangle distinct
        foreach ($cartesDeck as $index => $carte) {


            $this->colonneEnCour++;

            if( $this->colonneEnCour == $this->nbrColonne){
                // Row full, we start a new one
                $this->colonneEnCour=0;
                $this->ligneEnCour++;
                if ($this->ligneEnCour == $this->nbrLigne) {
                    // End of page reached, we start a new one
                    $this->colonneEnCour=-1;
                    $this->ligneEnCour=0;
                    $this->pdf->AddPage();
                    $this->faireRecto($cartesDeck);
                    return;
                }
            }


            // // Calcul de la position du rectangle
            // $x = $rectX + ($index % 3) * $rectWidth;
            // $y = $rectY + floor($index / 3) * $rectHeight;

            
            $x = (210 - $this->rectWidth) - ($this->rectX + $this->colonneEnCour * $this->rectWidth);
            $y = $this->rectY + $this->ligneEnCour * $this->rectHeight;

            $this->dessinerRectangleAvecText($this->pdf, $x, $y, $this->rectWidth, $this->rectHeight, $carte->getReponse());

            unset($cartesDeck[$index]);
        }
    }

    function dessinerRectangleAvecText($pdf, $x, $y, $width, $height, $text) {
        $pdf->Rect($x, $y, $width, $height);
        // Ajout du texte dans le rectangle
        $pdf->SetXY($x + 5, $y + 5);
        $pdf->MultiCell($width - 10, 10, $text, 0, 'C');
    }
}
