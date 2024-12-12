<?php
// src/Twig/MenuExtension.php
namespace App\Twig;

use App\Service\MenuService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_menu_items', [$this, 'getMenuItems']),
        ];
    }

    public function getMenuItems()
    {
        return $this->menuService->getMenuItems();
    }
}
