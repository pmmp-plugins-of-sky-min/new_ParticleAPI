<?php
declare(strict_types = 1);

namespace skymin\particle;

use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use function atan2;
use function cos;
use function deg2rad;
use function mt_rand;
use function rad2deg;
use function sin;
use function sqrt;
use function array_merge;

function circle(int $ParticleId, Vector3 $center, float $radius, float $unit, int $color, float $slope, int $type, float $angle) :array{
	$packets = array();
	$x = $center->x;
	$y = $center->y;
	$z = $center->z;
	for ($i = 0; $i < 360; $i += $unit){
		$a = $i + $angle;
		if($type === 0){
			$vec = new Vector3($x + sin(deg2rad($a)) * $radius, $y + (sin(deg2rad($a))) * $slope, $z + cos(deg2rad($a)) * $radius);
		}
		if($type === 1){
			$vec = new Vector3($x + sin(deg2rad($a)) * $radius, $y + cos(deg2rad($a)) * $slope, $z + cos(deg2rad($a)) * $radius);
		}
		$packets[] = LevelEventPacket::standardParticle($ParticleId, $color, $vec);
	}
	return $packets;
}

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

function sendPackets(array $players, array $packets) :void{
	Server::getInstance()->broadcastPackets($players, $packets);
}

class ParticleAPI{
	
	/*circle type*/
	public const SIN = 0;
	public const COS = 1;
	
	public static function drawCircle(int $ParticleId, Vector3 $center, float $radius, float $unit, array $players, int $color = 0, float $slope = 0, int $type = self::SIN, float $angle = 0.0) :void{
		$packets = circle($ParticleId, $center, $radius, $unit, $color, $slope, $type, $angle);
		sendPackets($players, $packets);
	}
	
	public static function drawStraight(int $ParticleId, Vector3 $pos1, Vector3 $pos2, float $unit, array $players, int $color = 0) :void{
		$packets = straight($ParticleId, $pos1, $pos2, $unit, $color);
		sendPackets($players, $packets);
	}
	
	public static function drawRegular(int $ParticleId, Vector3 $center, float $radius, int $side, float $unit, float $angle, array $players, int $color = 0) :void{
		$packets = array();
		$ang = 180 * ($side - 2);
		$round = 180 - ($ang / $side);
		for($i = $angle; $i <= $angle + 360; $i += $round){
			$x1 = ($i === $angle) ? $center->getX() + $radius * (-\sin ($i / 180 * M_PI)) : $x2;
			$y1 = ($i === $angle) ? $center->getY() : $y2;
			$z1 = ($i === $angle) ? $center->getZ() + $radius * (\cos($i / 180 * M_PI)) : $z2;
			$x2 = $center->getX() + $radius * (-\sin($i / 180 * M_PI));
			$y2 = $center->getY();
			$z2 = $center->getZ() + $radius * (\cos($i / 180 * M_PI));
			if($i !== $angle){
				$vec_1 = new Vector3($x1, $y1, $z1);
				$vec_2 = new Vector3($x2, $y2, $z2);
				$packets = array_merge($packets, straight($ParticleId, $vec_1, $vec_2, $unit, $color));
			}
		}
		sendPackets($players, $packets);
	}
	
}