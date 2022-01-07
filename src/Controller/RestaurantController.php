<?php

namespace App\Controller;

use App\Entity\Menus;
use App\Entity\Order;
use App\Repository\MenusRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddMenuType;
use App\Form\UpdateMenuType;
use App\Form\DeleteMenuType;
use App\Form\AddOrderType;
use App\Repository\OrderRepository;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param int $id
     */
    public function index(
        Request $request,
        MenusRepository $menusRepository
    ) {

        $menuList = $menusRepository->findAll();
        // dd($getMenus);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'RestaurantController',
            'menuList' => $menuList
        ]);
    }


    /**
     * @Route("order/{id}", name="order", requirements={"id"="\d+"})
     * @param int $id
     */

    public function order(
        Request $request,
        MenusRepository $menusRepository,
        OrderRepository $orderRepository,
        $id = null
    ) {

        $getOrderByMenuId = $menusRepository->findMenuById($id);


        $order = new Order;

        $getOrder = $menusRepository->findOneBy(['id' => $id]);

        $name = $getOrder->getName();
        $price = $getOrder->getPrice();
        $stock = $getOrder->getName();

        // Form to add a menu
        $formAddOrder = $this->createForm(AddOrderType::class, $order);

        $formAddOrder->handleRequest($request);

        if ($formAddOrder->isSubmitted() && $formAddOrder->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // dd($order);

            $em->persist($order);
            $em->flush();    

            return $this->redirectToRoute('home');

        }

        return $this->render('home/order.html.twig', [
            'controller_name' => 'RestaurantController',
            'orderRecap' => $getOrderByMenuId,
            'formAddOrder' => $formAddOrder->createView(),
            "name" => $name,
            "price" => $price,
            "stock" => $stock,

        ]);
    }



    /**
     * @Route("add_menu", name="add_menu")
     */

    public function addMenu(
        Request $request,
        MenusRepository $menusRepository,

    ) {

        $menu = new Menus;

        // Form to add a menu
        $formAddMenu = $this->createForm(AddMenuType::class, $menu);

        $formAddMenu->handleRequest($request);

        if ($formAddMenu->isSubmitted() && $formAddMenu->isValid()) {
            $em = $this->getDoctrine()->getManager();

            dd($menu);

            $em->persist($menu);
            $em->flush();    

            return $this->redirectToRoute('home');

        }


        return $this->render('home/add_menu.html.twig', [
            'controller_name' => 'RestaurantController',
            'formAddMenu' => $formAddMenu->createView(),
        ]);
    }



    /**
     * @Route("menu_list", name="menu_list")
     */
    public function menuList(
        Request $request,
        MenusRepository $menusRepository
    ) {

     
        // =========== Formulaire (Suppression) =========== //
        $em = $this->getDoctrine()->getManager();

        $menuList = $menusRepository->findAll();

        $formDeleteMenu = $this->createForm(DeleteMenuType::class, [
            'deleteMenus' => $menuList
        ]);

        $formDeleteMenu->handleRequest($request);

        if ($formDeleteMenu->isSubmitted()) {

            $recupIdMenu = $request->request->get('idMenu');
            $menuList = $menusRepository->findOneById($recupIdMenu);

            $delete = $menusRepository->deleteMenu($recupIdMenu);
            dd($delete);

            $em->persist($menuList);
            $em->flush();


            return $this->redirectToRoute('menu_list');
        }


        return $this->render('home/menu_list.html.twig', [
            'controller_name' => 'RestaurantController',
            'menuList' => $menuList,
            'FormDeleteMenu' => $formDeleteMenu->createView()
        ]);
    }


        /**
     * @Route("update_menu/{id}", name="update_menu", requirements={"id"="\d+"})
     * @param int $id
     */
    public function updateMenu(
        Request $request,
        MenusRepository $menusRepository,
        $id = null
    ) {


        $updateMenu = $menusRepository->findOneBy(['id' => $id]);

        $name = $updateMenu->getName();
        $price = $updateMenu->getPrice();
        $stock = $updateMenu->getName();


        // Form to update a menu
        $formUpdateMenu = $this->createForm(UpdateMenuType::class, $updateMenu);

        $formUpdateMenu->handleRequest($request);

        if ($formUpdateMenu->isSubmitted() && $formUpdateMenu->isValid()) {
            $em = $this->getDoctrine()->getManager();


    
            $em->persist($updateMenu);
            $em->flush();  
            
            return $this->redirectToRoute('menu_list');
        }


        return $this->render('home/update_menu.html.twig', [
            'controller_name' => 'RestaurantController',
            'formUpdateMenu' => $formUpdateMenu->createView(),
            "name" => $name,
            "price" => $price,
            "stock" => $stock,
            // "menu" => $getMenuById
        ]);
    }
}
