<?php

namespace kim\presenthumanoid\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\{
  PlayerAct, ClickHumanoidAct, InteractAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /**
     * @priority LOW
     *
     * @param PlayerClickHumanoidEvent $event
     */
    public function onPlayerClickHumanoidEvent(PlayerClickHumanoidEvent $event) : void{
        if (!$event->isCancelled()) {
            $task = PlayerAct::getAct($player = $event->getPlayer());
            if ($task instanceof ClickHumanoidAct) {
                $task->onClickHumanoid($event);
            }
        }
    }

    /**
     * @priority LOW
     *
     * @param PlayerInteractEvent $event
     */
    public function onPlayerInteractEvent(PlayerInteractEvent $event) : void{
        if (!$event->isCancelled()) {
            $task = PlayerAct::getAct($player = $event->getPlayer());
            if ($task instanceof InteractAct) {
                $task->onInteract($event);
            }
        }
    }
}