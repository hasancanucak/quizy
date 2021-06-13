<?php namespace App\Database\Seeds;

/**
 * This seeder for development only.
 * When developing this platform, we need dump data.
 * This seeder for it.
 */

class DevSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		//--------------------------------------------------------------------
		
		$this->db->disableForeignKeyChecks();
		$builder = $this->db->table('teams');
		$builder->insertBatch([
			[
				'id'        => '1',
				'leader_id' => '1',
				'name'      => 'MCLee',
				'auth_code' => '22b16b0188ecc7c698fb6910cd01b825d2fd3936d331235836e9ebd1ff6284c8',
				'is_banned' => '0',
			],
			[
				'id'        => '2',
				'leader_id' => '3',
				'name'      => 'loremchecksum',
				'auth_code' => '05370ef051e0ba69e53a9cad4dd92c6cd3086337be0aaa375f9e508c59dd127f',
				'is_banned' => '0',
			],
			[
				'id'        => '3',
				'leader_id' => '4',
				'name'      => 'team3',
				'auth_code' => '7c50b8f03341d33093d2880bdbb988d611edd8422a632543415180b851af67cd',
				'is_banned' => '0',
			],
			[
				'id'        => '4',
				'leader_id' => '5',
				'name'      => 'team banned',
				'auth_code' => 'b578a3e90e3fada4595da1cb2ac2c1eb524a0de8a7566fa4abf99095cc52477b',
				'is_banned' => '1',
			],
		]);

		//--------------------------------------------------------------------

		$builder = $this->db->table('users');
		// passwords same as username
		$builder->insertBatch([
			
			[
				'id'               => '5',
				'team_id'          => '3',
				'email'            => 'user3@mail.com',
				'username'         => 'user3',
				'name'             => 'user3',
				'password_hash'    => '$argon2i$v=19$m=65536,t=4,p=1$alp2TVQyTmJXc1QyTzNFcg$88lOtXPSqCtpuhqR+FbpfyjJ2PL/klO150XNkRaDm8M',
				'active'           => '1',
				'force_pass_reset' => '0',
			],
			[
				'id'               => '6',
				'team_id'          => '4',
				'email'            => 'banned@mail.com',
				'username'         => 'banned',
				'name'             => 'banned',
				'password_hash'    => '$argon2i$v=19$m=65536,t=4,p=1$bktTUmtIMHdDa1kvM09SaQ$d9+DUXBkzENU56CESTPrvaJKIaqub/KyhgCpGAhUYX8',
				'active'           => '1',
				// this two lines gives error. probably a bug :(
				// 'status'           => 'banned',
				// 'status_message'   => 'banned message',
				'force_pass_reset' => '0',
			],
		]);
		$builder->where('id', '6')->set(['status' => 'banned', 'status_message' => 'banned message'])->update();
		$this->db->enableForeignKeyChecks();

		//--------------------------------------------------------------------

		$builder = $this->db->table('categories');
		$builder->insertBatch([
			[
				'name'        => 'Linux',
				'description' => NULL,
			],
			[
				'name'        => 'Web',
				'description' => NULL,
			],
			[
				'name'        => 'Reverse',
				'description' => NULL,
			],
			[
				'name'        => 'Crypto',
				'description' => NULL,
			],
			[
				'name'        => 'Coding',
				'description' => NULL,
			],
		]);

		//--------------------------------------------------------------------

		$builder = $this->db->table('challenges');
		$builder->insertBatch([
			// Linux
			[
				'category_id'  => '1',
				'name'         => 'linux100',
				'point'        => '100',
				'description'  => 'linux100',
				'max_attempts' => '',
				'type'         => 'static',
				'is_active'    => '1'
			],
			[
				'category_id'  => '1',
				'name'         => 'linux200',
				'point'        => '200',
				'description'  => 'linux200',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '0'
			],
			[
				'category_id'  => '1',
				'name'         => 'linux300',
				'point'        => '300',
				'description'  => 'linux300',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			// Web
			[
				'category_id'  => '2',
				'name'         => 'web100',
				'point'        => '100',
				'description'  => 'web100',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '2',
				'name'         => 'web200',
				'point'        => '200',
				'description'  => 'web200',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '2',
				'name'         => 'web300',
				'point'        => '300',
				'description'  => 'web300',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			// Reverse
			[
				'category_id'  => '3',
				'name'         => 'reverse100',
				'point'        => '100',
				'description'  => 'reverse100',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '3',
				'name'         => 'reverse200',
				'point'        => '200',
				'description'  => 'reverse200',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '3',
				'name'         => 'reverse300',
				'point'        => '300',
				'description'  => 'reverse300',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			// Crypto
			[
				'category_id'  => '4',
				'name'         => 'crypto100',
				'point'        => '100',
				'description'  => 'crypto100',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '4',
				'name'         => 'crypto200',
				'point'        => '200',
				'description'  => 'crypto200',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '4',
				'name'         => 'crypto300',
				'point'        => '300',
				'description'  => 'crypto300',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			// Coding
			[
				'category_id'  => '5',
				'name'         => 'coding100',
				'point'        => '100',
				'description'  => 'coding100',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '5',
				'name'         => 'coding200',
				'point'        => '200',
				'description'  => 'coding200',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
			[
				'category_id'  => '5',
				'name'         => 'coding300',
				'point'        => '300',
				'description'  => 'coding300',
				'max_attempts' => '',
				'type'         => 'dynamic',
				'is_active'    => '1'
			],
		]);

		//--------------------------------------------------------------------

		$builder = $this->db->table('flags');
		$builder->insertBatch([
			// Linux
			[
				'challenge_id' => '1',
				'type'         => 'static',
				'content'      => 'linux100',
			],
			[
				'challenge_id' => '2',
				'type'         => 'regex',
				'content'      => 'linux200',
			],
			[
				'challenge_id' => '3',
				'type'         => 'static',
				'content'      => 'linux300',
			],
			// Web
			[
				'challenge_id' => '4',
				'type'         => 'static',
				'content'      => 'web100',
			],
			[
				'challenge_id' => '5',
				'type'         => 'regex',
				'content'      => 'web200',
			],
			[
				'challenge_id' => '6',
				'type'         => 'static',
				'content'      => 'web300',
			],
			// Reverse
			[
				'challenge_id' => '7',
				'type'         => 'static',
				'content'      => 'reverse100',
			],
			[
				'challenge_id' => '8',
				'type'         => 'regex',
				'content'      => 'reverse200',
			],
			[
				'challenge_id' => '9',
				'type'         => 'static',
				'content'      => 'reverse300',
			],
			// Crypto
			[
				'challenge_id' => '10',
				'type'         => 'static',
				'content'      => 'crypto100',
			],
			[
				'challenge_id' => '11',
				'type'         => 'regex',
				'content'      => 'crypto200',
			],
			[
				'challenge_id' => '12',
				'type'         => 'static',
				'content'      => 'crypto300',
			],
			// Coding
			[
				'challenge_id' => '13',
				'type'         => 'static',
				'content'      => 'coding100',
			],
			[
				'challenge_id' => '14',
				'type'         => 'regex',
				'content'      => 'coding200',
			],
			[
				'challenge_id' => '15',
				'type'         => 'static',
				'content'      => 'coding300',
			],
		]);

		//--------------------------------------------------------------------

		$builder = $this->db->table('hints');
		$builder->insertBatch([
			// Linux
			[
				'challenge_id' => '1',
				'content'      => 'linux100',
				'cost'         => '50',
			],
			[
				'challenge_id' => '2',
				'content'      => 'linux200',
				'cost'         => '50',
			],
			[
				'challenge_id' => '3',
				'content'      => 'linux300',
				'cost'         => '50',
			],
			// Web
			[
				'challenge_id' => '4',
				'content'      => 'web100',
				'cost'         => '50',
			],
			[
				'challenge_id' => '5',
				'content'      => 'web200',
				'cost'         => '50',
			],
			[
				'challenge_id' => '6',
				'content'      => 'web300',
				'cost'         => '50',
			],
			// Reverse
			[
				'challenge_id' => '7',
				'content'      => 'reverse100',
				'cost'         => '50',
			],
			[
				'challenge_id' => '8',
				'content'      => 'reverse200',
				'cost'         => '50',
			],
			[
				'challenge_id' => '9',
				'content'      => 'reverse300',
				'cost'         => '50',
			],
			// Crypto
			[
				'challenge_id' => '10',
				'content'      => 'crypto100',
				'cost'         => '50',
			],
			[
				'challenge_id' => '11',
				'content'      => 'crypto200',
				'cost'         => '50',
			],
			[
				'challenge_id' => '12',
				'content'      => 'crypto300',
				'cost'         => '50',
			],
			// Coding
			[
				'challenge_id' => '13',
				'content'      => 'coding100',
				'cost'         => '50',
			],
			[
				'challenge_id' => '14',
				'content'      => 'coding200',
				'cost'         => '50',
			],
			[
				'challenge_id' => '15',
				'content'      => 'coding300',
				'cost'         => '50',
			],
		]);

		//--------------------------------------------------------------------

		$builder = $this->db->table('notifications');
		$builder->insertBatch([
			[
				'title'   => 'notf 1',
				'content' => 'Awesome Notification !!!',
			],
			[
				'title'   => 'notf 2',
				'content' => 'Awesome Notification !!!',
			],
			[
				'title'   => 'notf 3',
				'content' => 'Awesome Notification !!!',
			],
			[
				'title'   => 'notf 4',
				'content' => 'Awesome Notification !!!',
			],
			[
				'title'   => 'notf 5',
				'content' => 'Awesome Notification !!!',
			],
		]);

		//--------------------------------------------------------------------
	}
}