<?php

namespace App\Calendar\UI\HTTP\Controller;


use App\Calendar\UI\Form\CreateCalendarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    private $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @param Request $request
     */
    public function createCalendarAction(Request $request)
    {
        $form = $this->createForm(new CreateCalendarType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $calendar = $this->get('')
        }
    }
}