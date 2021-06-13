<?php namespace App\Database\Seeds;

class InstallSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// default settings
		$builder = $this->db->table('settings');
		$builder->insertBatch([
			[
				'key'   => 'ctf_name',
				'value' => 'QUIZY',
			],
			[
				'key'   => 'ctf_logo',
				'value' => NULL,
			],
			[
				'key'   => 'theme',
				'value' => 'default',
			],
			[
				'key'   => 'ctf_timer',
				'value' => 'off',
			],
			[
				'key'   => 'ctf_start_time',
				'value' => NULL,
			],
			[
				'key'   => 'ctf_end_time',
				'value' => NULL,
			],
			[
				'key'   => 'allow_register',
				'value' => 'true',
			],
			[
				'key'   => 'home_page',
				'value' => NULL,
			],
			[
				'key'   => 'need_hash',
				'value' => 'false',
			],
			[
				'key'   => 'team_member_limit',
				'value' => 4,
			],
			[
				'key'   => 'hash_secret_key',
				'value' => NULL,
			],
		]);

		// create admin group
		$builder = $this->db->table('auth_groups');
		$builder->insert([
			'name'        => 'admin',
			'description' => 'Admin Group',
		]);
	}
}