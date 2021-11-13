<?php
declare(strict_types = 1);

namespace skymin\particle\utils;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use function sqrt;
use function rad2deg;
use function atan2;

use const M_PI;

trait StraightTrait{
	
	function straight(int $ParticleId, Vector3 $pos1, Vector3 $pos2, float $unit, int $color) :array{
		$packets = array();
		$x = $pos1->getX() - $pos2->getX();
		$y = $pos1->getY() - $pos2->getY();
		$z = $pos1->getZ() - $pos2->getZ();
		$xz_sq = $x * $x + $z * $z;	
		$xz_modulus = sqrt($xz_sq);
		$yaw = rad2deg(atan2(-$x, $z));
		$pitch = rad2deg(-atan2($y, $xz_modulus));
		$distance = $pos1->distance($pos2);
		for($i = 0; $i <= $distance; $i += $unit){
			$x1 = $pos1->getX() - $i * (-sin($yaw / 180 * M_PI));
			$y1 = $pos1->getY() - $i * (-sin($pitch / 180 * M_PI));
			$z1 = $pos1->getZ() - $i * (cos($yaw / 180 * M_PI));
			$vec = new Vector3($x1, $y1, $z1);
			$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
		}
		return $packets;
	}
	
}