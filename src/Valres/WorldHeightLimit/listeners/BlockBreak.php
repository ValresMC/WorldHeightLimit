<?php

namespace Valres\WorldHeightLimit\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use Valres\WorldHeightLimit\Main;

class BlockBreak implements Listener
{
    public function onPlace(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $worldName = $player->getWorld()->getFolderName();
        $block = $event->getBlock();
        $limitManager = Main::getInstance()->limitManager;

        if($player->hasPermission("worldheight.bypass")) return;

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
