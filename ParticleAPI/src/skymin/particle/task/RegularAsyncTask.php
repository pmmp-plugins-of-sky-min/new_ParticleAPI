<?php
declare(strict_types = 1);

namespace skymin\particle\task;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\math\Vector3;

use skymin\particle\utils\{SendPacketTrait, StraightTrait};

use function strtolower;
use function array_merge;

use const M_PI;

final class RegularAsyncTask extends AsyncTask{
	use SendPacketTrait;
	use StraightTrait;
	
	private array $targets = [];
	
	public function __construct(
		private int $ParticleId,
		private float $x,
		private float $y,
		private float $z,
		private float $radius,
		private int $side,
		private float $unit,
		private float $angle,
		array $players,
		private int $color
	){
		foreach ($players as $player){
			$this->targets[] = strtolower($player->getName());
		}
	}
	
	public function onRun() :void{
		$center = new Vector3($this->x, $this->y, $this->z);
		$ParticleId = $this->ParticleId;
		$radius = $this->radius;
		$side = $this->side;
		$unit = $this->unit;
		$angle = $this->angle;
		$color = $this->color;
		$packets = array();
		$ang = 180 * ($side - 2);
		$round = 180 - ($ang / $side);
		for($i = $angle; $i <= $angle + 360; $i += $round){
			$x1 = ($i === $angle) ? $center->x + $radius * (-\sin ($i / 180 * M_PI)) : $x2;
			$y1 = ($i === $angle) ? $center->y : $y2;
			$z1 = ($i === $angle) ? $center->z + $radius * (\cos($i / 180 * M_PI)) : $z2;
			$x2 = $center->x + $radius * (-\sin($i / 180 * M_PI));
			$y2 = $center->y;
			$z2 = $center->z + $radius * (\cos($i / 180 * M_PI));
			if($i !== $angle){
				$vec_1 = new Vector3($x1, $y1, $z1);
				$vec_2 = new Vector3($x2, $y2, $z2);
				$packets = array_merge($packets, $this->straight($ParticleId, $vec_1, $vec_2, $unit, $color));
			}
		}
		$this->setResult($packets);
	}
	
}