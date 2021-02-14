<?php

declare(strict_types=1);

namespace App\Simulator\UI\Web\Controller;

use App\Simulator\Application\Query\Report\GetReportQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    use HandleTrait;

    /**
     * HomeController constructor.
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @Route(
     *     "/{date}",
     *     name="home",
     *     methods={"GET"}
     * )
     */
    public function home(string $date): Response
    {
        try {
            $date = new \DateTime($date);
        } catch (\Exception $e) {
            return $this->render('home/index.html.twig', ['error' => 'Invalid format date. Expected => "2020-02-13"']);
        }

        $reports = $this->handle(new GetReportQuery($date, 'Building1'));
        return $this->render('home/index.html.twig', ['reports' => $reports]);
    }
}
