<?php

namespace Valres\WorldHeightLimit;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Valres\WorldHeightLimit\listeners\BlockBreak;
use Valres\WorldHeightLimit\listeners\BlockPlace;
use Valres\WorldHeightLimit\managers\LimitManager;

class Main extends PluginBase implements Listener
{
    public LimitManager $limitManager;

    use SingletonTrait;
    
    protected function onEnable(): void
    {
        $this->getLogger()->info("by Valres est lancé !");

        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreak(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockPlace(), $this);
        $this->limitManager = new LimitManager();
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

}
