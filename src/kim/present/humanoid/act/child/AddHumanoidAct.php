<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	InteractAct, PlayerAct
};
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;

class AddHumanoidAct extends PlayerAct implements InteractAct{
	/** @var string */
	private $name;

	/**
	 * @param Player $player
	 * @param string $name
	 */
	public function __construct(Player $player, string $name){
		parent::__construct($player);
		$this->name = $name;
	}

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onInteract(PlayerInteractEvent $event) : void{
		if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){
			$nbt = Entity::createBaseNBT($this->player, null, $this->player->yaw, $this->player->pitch);
		}else{
			$nbt = Entity::createBaseNBT($event->getBlock()->add(0.5, 1, 0.5));
			$nbt->setTag($this->player->getInventory()->getItemInHand()->nbtSerialize(-1, 'HeldItem'));
		}
		$skin = $this->player->getSkin();
		$nbt->setString('SkinData', $skin->getSkinData());
		$nbt->setString('GeometryName', $skin->getGeometryName());
		$nbt->setString('CustomName', $this->name);

		$entity = Entity::createEntity('Humanoid', $this->player->level, $nbt);
		$entity->spawnToAll();

		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-add@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}