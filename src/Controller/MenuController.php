<?php
// src/Controller/MenuController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'menu')]
    public function index(): Response
    {
        // Exemple de structure de données pour le menu
        $menu_columns = [
            [
                'blocks' => [
                    [
                        'id' => 51,
                        'type' => 'mm_block_type_html',
                        'title' => 'Trouvez Votre Parfum',
                        'link' => 'https://www.jovoyparis.com/fr/5-parfums-fr?order=product.date_add.desc',
                        'content' => 'TROUVEZ VOTRE PARFUM'
                    ],
                    [
                        'id' => 52,
                        'type' => 'mm_block_type_category',
                        'title' => 'Familles Olfactives',
                        'link' => 'https://www.jovoyparis.com/fr/content/6-les-familles-olfactives',
                        'categories' => [
                            ['name' => 'Boisé', 'link' => 'https://www.jovoyparis.com/fr/28-boise'],
                            ['name' => 'Fleuri', 'link' => 'https://www.jovoyparis.com/fr/31-fleuri'],
                            ['name' => 'Gourmand', 'link' => 'https://www.jovoyparis.com/fr/55-gourmand'],
                            ['name' => 'Oriental', 'link' => 'https://www.jovoyparis.com/fr/35-oriental']
                        ]
                    ]
                    // Ajoutez d'autres blocs ici...
                ]
            ]
            // Ajoutez d'autres colonnes ici...
        ];

        return $this->render('components/_menu.html.twig', [
            'menu_columns' => $menu_columns
        ]);
    }
}
