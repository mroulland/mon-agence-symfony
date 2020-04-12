<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 11/04/2020
 * Time: 14:02
 */

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
	/**
	 * @var PropertyRepository
	 */
	private $repository;
	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	public function __construct(PropertyRepository $repository, EntityManagerInterface $em){
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	 * @Route("/biens", name="property.index")
	 * @return Response
	 */
	public function index():Response{
		// Autre manière d'appeler le repository approprié :
		//$repository = $this->getDoctrine()->getRepository(Property::class);

//		$property[0]->setSold(true);
//		dump($property);
//		// Le flush va détecter qu'une entité a été modifiée
//		$this->em->flush();
		return $this->render('property/index.html.twig', [
			'current_menu' => 'properties'
		]);
	}

	/**
	 * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
	 * @param Property $property
	 * @return Response
	 * En injectant le property directement, il se charge de faire un find à notre place
	 */
	public function show(Property $property, string $slug):Response{
		if($property->getSlug() !== $slug){
			return $this->redirectToRoute('property.show', [
				'id' => $property->getId(),
				'slug' => $property->getSlug()
			], 301);
		}
		return $this->render('property/show.html.twig', [
			'property' => $property,
			'current_menu' => 'properties'
		]);
	}
}