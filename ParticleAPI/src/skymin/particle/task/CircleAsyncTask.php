<?php
declare(strict_types = 1);

namespace skymin\particle\task;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\math\Vector3;

use skymin\particle\utils\{SendPacketTrait, CircleTrait};

use function strtolower;

final class CircleAsyncTask extends AsyncTask{
	use SendPacketTrait;
	use CircleTrait;
	
	private array $targets = [];
	
	public function __construct(
		private int $ParticleId,
		private float $x,
		private float $y,
		private float $z,
		private float $radius,
		private float $unit,
		array $players,
		private int $color,
		private float $slope,
		private int $type,
		private float $angle
	){
		foreach ($players as $player){
			$this->targets[] = strtolower($player->getName());
		}
	}
	
	public function onRun() :void{
		$center = new Vector3($this->x, $this->y, $this->z);
		$packets = $this->circle($this->ParticleId, $center, $this->radius, $this->unit, $this->color, $this->slope, $this->type, $this->angle);
		$this->setResult($packets);
	}
	
}