<?php

namespace Valres\WorldHeightLimit\listeners;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use Valres\WorldHeightLimit\Main;

class BlockPlace implements Listener
{
    public function onPlace(BlockPlaceEvent $event): void
    {
        $player = $event->getPlayer();
        $blocks = $event->getTransaction()->getBlocks();
        $worldName = $player->getWorld()->getFolderName();
        $limitManager = Main::getInstance()->limitManager;

        if($player->hasPermission("worldheight.bypass")) return;

        foreach ($blocks as $placed) {
            $block = $placed[3];
        }

        if($limitManager->isAllWorld()){
            if($block->getPosition()->y >= $limitManager->getAllWorldLimit()){
                $event->cancel();
                $player->sendMessage($limitManager->getMessage());
            }
        } else {
            if(array_key_exists($worldName, $limitManager->worlds)){
                if($block->getPosition()->y >= $limitManager->getLimit($worldName)){
                    $event->cancel();
                    $player->sendMessage($limitManager->getMessage());
                }
            }
        }
    }
}
