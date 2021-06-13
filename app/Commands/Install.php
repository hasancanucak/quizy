<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;


class Install extends BaseCommand
{
	protected $group       = 'Quizy';
	protected $name        = 'quizy:install';
	protected $description = 'Install quizy from command line.';
	protected $usage       = "quizy:install";

	public function run(array $params)
	{
		$db = db_connect();

		// install check
		// if settings table exist, platform already installed
		if ($db->tableExists('settings'))
		{
			CLI::write('QUIZY already installed. Please go to admin panel', 'yellow');
			exit(0);
		}

		// read user creds
		$users = new \Myth\Auth\Models\UserModel();
		CLI::write('Please enter user credentials', 'light_cyan');
		$username = CLI::prompt('Username', null, 'required|string');
		$email    = CLI::prompt('Email', null, 'required|valid_email');
		$password = CLI::prompt('Password', null, 'required');

		// run database migratios
		$migrate = \Config\Services::migrations();
		try
		{
			CLI::write('Running migrations', 'cyan');
			$migrate->latest();
		}
		catch (\Exception $e)
		{
			CLI::error('There was an error while running migrations');
			$this->showError($e);
			die(1);
		}

		// run seeds
		$seeder = \Config\Database::seeder();
		try {
			CLI::write('Running seeds', 'cyan');
			$seeder->call('InstallSeeder');
		} catch (\Exception $e) {
			CLI::error('There was an error while running seeds');
			$this->showError($e);
			die(1);
		}

		// create admin user
		$user = new \Myth\Auth\Entities\User();
		$user->fill([
			'username' => $username,
			'email'    => $email,
			'password' => $password,
		]);
		$user->activate();

		// save admin user
		CLI::write('Saving user', 'cyan');
		if (! $admin_id = $users->save($user))
		{
			CLI::error('User can not be saved!');
			exit(1);
		}

		// add user to admin group
		$auth  = Services::authorization();
		try
		{
			CLI::write('Adding user to "admin" group', 'cyan');
			$auth->addUserToGroup($admin_id, 'admin');
		}
		catch (\Exception $e)
		{
			CLI::error('User can not added to "admin" group!');
			$this->showError($e);
			exit(1);
		}

		CLI::write('QUIZY installed successfully!', 'light_green');
		CLI::write('Please go to the admin panel', 'light_green');
	}
}