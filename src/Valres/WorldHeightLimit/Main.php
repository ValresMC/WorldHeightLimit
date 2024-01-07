<?php

namespace Valres\WorldHeightLimit;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public static string $messages = "";
    public static int $limit;
    public static array $worlds = [];

    protected function onEnable(): void
    {
        $this->getLogger()->info("by Valres est lancé !");

        $this->saveDefaultConfig();
        $config = $this->getConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        foreach($config->get("worlds") as $world){
            if(!isset(self::$worlds[$world])){
                self::$worlds[] = $world;
            }
        }

        self::$messages = $config->get("message");
        self::$limit = $config->get("limit");
    }

    public function onPlace(BlockPlaceEvent $event): void
    {
        $player = $event->getPlayer();
        $blocks = $event->getTransaction()->getBlocks();
        $world = $player->getWorld()->getFolderName();

        if(!$player->hasPermission("worldheight.bypass")){
            if(in_array($world, self::$worlds)){
                foreach ($blocks as $placed){
                    $block = $placed[3];
                    if($block->getPosition()->y >= self::$limit){
                        $event->cancel();
                        $player->sendMessage(self::$messages);
                    }
                }
            }
        }
    }

    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $world = $player->getWorld()->getFolderName();

        if(!$player->hasPermission("worldheight.bypass")){
            if(in_array($world, self::$worlds)){
                if($block->getPosition()->y >= self::$limit){
                    $event->cancel();
                    $player->sendMessage(self::$messages);
                }
            }
        }
    }
}