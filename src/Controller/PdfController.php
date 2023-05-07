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



    private $nbrColumn;
    private $nbrRow;
    private $currentColumn;
    private $currentRow;
    private $rectWidth;
    private $rectHeight;
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

        $this->nbrColumn =  $request->query->get('X');
        $this->nbrRow =  $request->query->get('Y');

        // Définition de la taille des rectangles
        $this->rectWidth = 210 / $this->nbrColumn;
        $this->rectHeight = 297 / $this->nbrRow;

        // Création d'un nouveau PDF
        $this->pdf = new FPDF();

        // Ajout d'une page
        $this->pdf->AddPage();

        // Paramètrage de la police
        $this->pdf->SetFont('Arial','B',16);

        $this->currentColumn = -1;
        $this->currentRow = 0;

        $this->makeRecto($cartesDeck);

        // Génération du PDF et envoi de la réponse
        $pdfContent = $this->pdf->Output('S');
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="deck.pdf"');

        return $response;
    }


    function makeRecto($cartesDeck){
            
        // Parcours du tableau et ajout de chaque élément dans un rectangle distinct
        foreach ($cartesDeck as $index => $carte) {

            $this->currentColumn++;

            if($this->currentColumn == $this->nbrColumn){
                // Rangée pleine, je commence une nouvelle rangée
                $this->currentColumn=0;
                $this->currentRow++;
                if ($this->currentRow == $this->nbrRow) {
                    // Fin de la page atteinte, je commence une nouvelle page
                    $this->currentColumn=-1;
                    $this->currentRow=0;
                    $this->pdf->AddPage();
                    $this->makeVerso($cartesDeck);
                    return;
                }
            }

            // Calcul de la position du rectangle
            $x = $this->currentColumn * $this->rectWidth;
            $y = $this->currentRow * $this->rectHeight;

            $this->drawRectangleWithCardData($this->pdf, $x, $y, $this->rectWidth, $this->rectHeight, "Question :" , $carte->getQuestion(), $carte->getImageQuestion());

            $lastCarte = $cartesDeck->last();

            if($carte === $lastCarte){
                $this->currentColumn=-1;
                $this->currentRow=0;
                $this->pdf->AddPage();
                $this->makeVerso($cartesDeck);
            }
        }
    }

    function makeVerso($cartesDeck){

        // Parcours du tableau et ajout de chaque élément dans un rectangle distinct
        foreach ($cartesDeck as $index => $carte) {

            $this->currentColumn++;

            if( $this->currentColumn == $this->nbrColumn){
                // Row full, we start a new one
                $this->currentColumn=0;
                $this->currentRow++;
                if ($this->currentRow == $this->nbrRow) {
                    // End of page reached, we start a new one
                    $this->currentColumn=-1;
                    $this->currentRow=0;
                    $this->pdf->AddPage();
                    $this->makeRecto($cartesDeck);
                    return;
                }
            }


            // Calcul de la position du rectangle
            $x = (210 - $this->rectWidth) - ( $this->currentColumn * $this->rectWidth);
            $y = $this->currentRow * $this->rectHeight;

            $this->drawRectangleWithCardData($this->pdf, $x, $y, $this->rectWidth, $this->rectHeight, "Reponse :" , $carte->getReponse(), $carte->getImageReponse());

            unset($cartesDeck[$index]);
        }
    }

    function drawRectangleWithCardData($pdf, $x, $y, $width, $height, $textHeader, $text, $image) {
        $pdf->Rect($x, $y, $width, $height);
        // Ajout du texte dans le rectangle
        $pdf->SetXY($x + 5, $y + 5);
        $pdf->MultiCell($width - 10, 10, $textHeader, 0, 'C');
        $pdf->SetXY($x + 5, $y + 5);
        $pdf->MultiCell($width - 10, 40, $text, 0, 'C');
        if($image){
            $pdf->SetXY($x, $y);
            $pdf->Image("../public/uploads/img/".$image, $x + $width/4, $y + $height / 2 , $width/2, null);
        }
    }
}
