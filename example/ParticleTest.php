<?php
/**
 * @name CircleTest
 * @main test\CircleTest
 * @author skymin
 * @version SKY
 * @api 4.0.0
 */
declare(strict_types = 1);
namespace test;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\math\Vector3;

use pocketmine\color\Color;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

use skymin\particle\ParticleAPI;

class CircleTest extends PluginBase implements Listener{
	
	public function onEnable() :void{
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	}
	
	public function onTouch(PlayerInteractEvent $ev) :void{
		$player = $ev->getPlayer();
		$color = new Color(61,203,239);
		$color = $color->toARGB();
		ParticleAPI::drawRegular(ParticleIds::DUST, $player->getPosition()->add(0, 1.0, 0), 1.7, 3, 0.3, 0, [$player], $color);
	}
	
}
