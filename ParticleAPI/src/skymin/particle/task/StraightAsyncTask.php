<?php
declare(strict_types = 1);

namespace skymin\particle\task;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\math\Vector3;

use skymin\particle\utils\{SendPacketTrait, StraightTrait};

use function strtolower;

final class StraightAsyncTask extends AsyncTask{
	use SendPacketTrait;
	use StraightTrait;
	
	public function __construct(
		private int $ParticleId,
		private float $x1,
		private float $y1,
		private float $z1,
		private float $x2,
		private float $y2,
		private float $z2,
		private float $unit,
		array $players,
		private int $color
	){
		foreach ($players as $player){
			$this->targets[] = strtolower($player->getName());
		}
	}
	
	public function onRun() :void{
		$pos1 = new Vector3($this->x1, $this->y1, $this->z1);
		$pos2 = new Vector3($this->x2, $this->y2, $this->z2);
		$this->straight($this->particleId, $pos1, $pos2, $this->unit, $this->color);
		$this->setResult($packets);
	}
	
}