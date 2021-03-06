<?php namespace App\Entities;

use CodeIgniter\Entity;

class Flag extends Entity
{
	protected $attributes = [
		'challenge_id' => null,
		'type'         => null,
		'content'      => null,
	];

	protected $casts = [
		'id'           => 'int',
		'challenge_id' => 'int',
	];
}
