<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CSVFile;
use AppBundle\Form\CSVFileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $file = new CSVFile();
        $form = $this->createForm(CSVFileType::class, $file)->add('Parse', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileToParse = $file->getFile();
            $parsedFile = $this->get('csv.parser')->parseCSVFile($fileToParse);
            $validatedRecords = $this->get('record.validator')->validateRecords($parsedFile);
            $this->get('db.processor')->executeInsert($validatedRecords);
            return $this->render('default/success.html.twig');
        }

        return $this->render('default/parse.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
