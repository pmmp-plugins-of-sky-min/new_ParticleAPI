<?php
declare(strict_types = 1);

namespace skymin\particle\utils;

use pocketmine\Server;

trait SendPacketTrait{
	
	private array $targets = [];
	
	public function onCompletion() :void{
		$server = Server::getInstance();
		$targets = array();
		foreach ($this->targets as $name){
			if(($target = $server->getPlayerExact($name)) === null) continue;
			$targets[] = $target;
		}
		$server->broadcastPackets($targets, $this->getResult());
	}
	
}