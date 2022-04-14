<?php

namespace App\Controller;

use App\Container;
use App\Interface\ControllerInterface;
use App\Table\AreaAccountTable;
use App\Table\AccountTable;
use App\Table\AreaEarningTable;
use App\Table\AreaTable;

class AreaListController implements ControllerInterface
{

    private array $content = [];

    public function __construct(private Container $container)
    {
    }

    public function handle()
    {

        $this->get();

        echo $this->container->getTwig()->render('page/areas.html.twig', $this->content);

    }

    public function get(): void
    {

        $accountAreaTable = new AreaAccountTable($this->container->getDatabase());
        $areaTable = new AreaTable($this->container->getDatabase());
        $areaEarningTable = new AreaEarningTable($this->container->getDatabase());
        $now = new \DateTime();

        $output = [];
        $badgeData = [];
        $buttonData = [];

        foreach ($accountAreaTable->findAllByUserId($this->container->getLoginUtil()->getLoginId()) as $accountArea)
        {

            $areaData = $areaTable->findById($accountArea['areaId']);
            $title = $areaData['title'];
            $description = $areaData['description'];

            $blockedUntil = new \DateTime($accountArea['blockedUntil']);

            $blockedDiff = $blockedUntil->diff($now);
            $diffText = $blockedDiff->format('%h:%Ih');

            if($blockedDiff->d > 0) {
                $diffText = $blockedDiff->format('%dd %h:%Ih');
            }

            if($now >= $blockedUntil)
            {
                $badgeData = ['badgeType' => 'success', 'badgeContent' => 'Bereit'];
                $buttonData = ['buttonText' => 'Arbeit beginnen', 'additionalButtonClass' => ''];
            }

            if($now < $blockedUntil)
            {
                $badgeData = ['badgeType' => 'warning', 'badgeContent' => $diffText];
                $buttonData = ['buttonText' => 'Abholbar in ' . $diffText, 'additionalClass' => 'disabled'];
            }

            if($now >= $blockedUntil && count($areaEarningTable->findAllByUserAndAreaId(
                $this->container->getLoginUtil()->getLoginId(), $accountArea['id'])) > 0)
            {
                $badgeData = ['badgeType' => 'info', 'badgeContent' => 'Abholbar'];
                $buttonData = ['buttonText' => 'Abholen', 'additionalClass' => 'disabled'];
            }

            $output['areas'][] = array_merge($accountArea, ['title' => $title, 'description' => $description], $badgeData, $buttonData);

        }

        foreach ($areaTable->findUnlockableAreasByLevel($this->container->getLoginUtil()->getLevel()) as $area) {


            $areaData = $areaTable->findById($area['id']);
            $title = $areaData['title'];
            $description = $areaData['description'];

            $badgeData = ['badgeType' => 'danger', 'badgeContent' => 'Nach Freischaltung'];
            $buttonData = ['buttonText' => 'Freischaltung benötigt'];

            $output['areas'][] = array_merge(['title' => $title, 'description' => $description, 'unlockable' => true], $badgeData, $buttonData);

        }

        $this->content = $output;

    }

    public function post(): void
    {}
}