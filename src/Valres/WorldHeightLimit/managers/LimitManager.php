<?php

namespace Valres\WorldHeightLimit\managers;

use Valres\WorldHeightLimit\Main;

class LimitManager
{
    public array $worlds = [];
    private bool $allWorld = false;
    private int $limit = 100;
    private string $message = "";

    /**
     * @return void
     */
    public function loadLimits(): void
    {
        $config = Main::getInstance()->getConfig();

        foreach($config->get("worlds") as $worldName => $limit){
            $this->worlds[$worldName] = $limit;
        }

        if($config->get("all-worlds") === "true"){
            $this->allWorld = true;
            $this->limit = $config->get("limit");
        }

        $this->message = $config->get("message");
    }

    /**
     * @param string $worldName
     * @return int
     */
    public function getLimit(string $worldName): int
    {
        return $this->worlds[$worldName];
    }

    /**
     * @return bool
     */
    public function isAllWorld(): bool
    {
        return $this->allWorld;
    }

    /**
     * @return int
     */
    public function getAllWorldLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
