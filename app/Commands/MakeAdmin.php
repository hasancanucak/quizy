<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;
use \App\Models\UserModel;

class MakeAdmin extends BaseCommand
{
	protected $group       = 'Quizy';
	protected $name        = 'quizy:makeadmin';
	protected $description = 'Make a user an admin';
	protected $usage     = "quizy:makeadmin [USERNAME | EMAIL]";
	protected $arguments = [
		'username'		=> 'Username of the user',
		'email'			=> 'Email of the user',
	];

	public function run(array $params)
	{
		$db = db_connect();
		$auth  = Services::authorization();

		if ($auth->group('admin') === null)
		{
			CLI::write('No Group Named "admin". Exiting!!!', 'light_red');
			exit(1);
		}

		// consume or prompt for group name
		$identity = array_shift($params);
		if (empty($identity))
		{
			$identity = CLI::prompt('Username OR Email', null, 'required');
		}

		$users = new UserModel();
		$user = null;

		if (filter_var($identity, FILTER_VALIDATE_EMAIL))
		{
			$user = $users->where('email', $identity)->first();
		}
		else
		{
			$user = $users->where('username', $identity)->first();
		}

		try
		{
			$auth->addUserToGroup($user->id, 'admin');
			CLI::write('Success!', 'yellow');
		}
		catch (\Exception $e)
		{
			$this->showError($e);
		}
	}
}