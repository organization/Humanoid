<?php

namespace kim\presenthumanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\act\child\StealHumanoidSkinAct;
use kim\presenthumanoid\command\{
  SubCommand, PoolCommand
};
use kim\presenthumanoid\util\Translation;

class SkinStealSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'skinsteal');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new StealHumanoidSkinAct($sender));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}