<?php


namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarStation;
use App\Entity\Station;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarStationController extends AbstractController
{
    /**
     * @Route("/api/car_station", methods={"GET"})
     * @param Request $req
     * @return JsonResponse
     */
    public function getCarStation(Request $req) :JsonResponse
    {
        $page = (int) $req->get('page');
        $page = $page ? $page : 1;
        $items = $this->getDoctrine()->getRepository(CarStation::class)->getCarStation($page);
        $total = (int) $this->getDoctrine()->getRepository(CarStation::class)->getCount();

        return $this->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/api/car_station", methods={"POST"})
     * @param Request $req
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(Request $req) :JsonResponse
    {
        $data = $req->getContent();
        $data = json_decode($data, true);

        $datetime = new \DateTimeImmutable($data['date']);

        $em = $this->getDoctrine()->getManager();
        try {
            $add = new CarStation();
            $add->setCars($em->getReference(Car::class, (int) $data['car']));
            $add->setStations($em->getReference(Station::class, (int) $data['station']));
            $add->setQuantity((int) $data['quantity']);
            $add->setDate($datetime->modify('+1 day'));
            $em->persist($add);
            $em->flush();

            $message = [
                'id' => $add->getId(),
                'quantity' => $add->getQuantity(),
                'date' => $add->getDate(),
                'mark' => $add->getCars()->getMark(),
                'number' => $add->getCars()->getNumber(),
                'type' => $add->getCars()->getType(),
                'name' => $add->getStations()->getName(),
                'address' => $add->getStations()->getAddress(),
            ];
        }
        catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return $this->json($message);
    }
}