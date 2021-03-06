<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\SettingModel;
use PhpZip\ZipFile;

class SettingsController extends AdminController
{
	/** @var SettingModel */
	protected $SettingModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->SettingModel = new SettingModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		return redirect('admin-settings-general');
	}

	//--------------------------------------------------------------------

	public function general()
	{
		helper('filesystem');
		$settings = ss();

		$themes = \App\Core\ThemeTrait::list();

		return $this->render('settings/general', [
			'settings' => $settings,
			'themes'   => $themes,
		]);
	}

	//--------------------------------------------------------------------

	public function generalUpdate()
	{
		$rules = [
			'ctf_name' => [
				'label' => lang('admin/Settings.ctfName'),
				'rules' => 'required|min_length[3]'
			],
			'team_member_limit' => [
				'label' => lang('admin/Settings.memberLimit'),
				'rules' => 'required|integer|max_length[10]'
			],
			'theme' => [
				'label' => lang('admin/Settings.theme'),
				'rules' => 'required'
			],
			'allow_register' => [
				'label' => lang('admin/Settings.allowRegister'),
				'rules' => 'required|in_list[true,false]'
			],
			'need_hash' => [
				'label' => lang('admin/Settings.needHashTitle'),
				'rules' => 'required|in_list[true,false]'
			],
			'hash_secret_key' => [
				'label' => lang('admin/Settings.hashSecretKey'),
				'rules' => 'permit_empty|in_list[on,off]'
			],
		];

		$data = [
			[
				'key'   => 'ctf_name',
				'value' => $this->request->getPost('ctf_name')
			],
			[
				'key'   => 'team_member_limit',
				'value' => $this->request->getPost('team_member_limit')
			],
			[
				'key'   => 'theme',
				'value' => $this->request->getPost('theme')
			],
			[
				'key'   => 'allow_register',
				'value' => $this->request->getPost('allow_register')
			],
			[
				'key'   => 'need_hash',
				'value' => $this->request->getPost('need_hash')
			],
		];

		if ($this->request->getPost('hash_secret_key') === 'on')
		{
			$data[] = [
				'key'   => 'hash_secret_key',
				'value' => bin2hex(random_bytes(8)),
			];
		}

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-general')->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->SettingModel->skipValidation()->updateBatch($data, 'key');

		if(! $result)
		{
			return redirect('admin-settings-general')->with('errors', $this->SettingModel->errors());
		}

		cache()->delete("settings");
		return redirect('admin-settings-general')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function timer()
	{
		$settings = ss();

		return $this->render('settings/timer', ['settings' => $settings]);
	}

	//--------------------------------------------------------------------

	public function timerUpdate()
	{
		$rules = [
			'ctf_timer' => [
				'label' => lang('admin/Settings.timer'),
				'rules' => 'required|in_list[on,off]'
			],
		];

		if ($this->request->getPost('ctf_timer') === 'on')
		{
			$rules = array_merge($rules, [
				'ctf_start_time' => [
					'label' => lang('admin/Settings.startTime'),
					'rules' => 'required|valid_date'
				],
				'ctf_end_time' => [
					'label' => lang('admin/Settings.endTime'),
					'rules' => 'required|valid_date'
				]
			]);
		}

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-timer')->withInput()->with('errors', $this->validator->getErrors());
		}

		$updateData = [
			[
				'key' => 'ctf_timer',
				'value' => $this->request->getPost('ctf_timer')
			],
		];

		if (isset($_POST['ctf_start_time']) && isset($_POST['ctf_end_time']))
		{
			$updateData = array_merge($updateData, [
				[
					'key' => 'ctf_start_time',
					'value' => $this->request->getPost('ctf_start_time')
				],
				[
					'key' => 'ctf_end_time',
					'value' => $this->request->getPost('ctf_end_time')
				],
			]);
		}

		$result = $this->SettingModel->skipValidation()->updateBatch($updateData, 'key');

		if (! $result)
		{
			return redirect('admin-settings-timer')->with('errors', $this->SettingModel->errors());
		}

		cache()->delete("settings");
		return redirect('admin-settings-timer')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function data()
	{
		helper('filesystem');

		$backups = directory_map(WRITEPATH.'backups'.DIRECTORY_SEPARATOR);

		if (($key = array_search('index.html', $backups)) !== false)
		{
			unset($backups[$key]);
		}

		return $this->render('settings/data', ['backups' => $backups]);
	}

	//--------------------------------------------------------------------

	public function backupData()
	{
		$zipfile = new ZipFile();
		$db = db_connect();
		$db_backup = [];

		// fetch all database
		foreach ($db->listTables() as $table)
		{
			$table_data = $db->table($table)->get()->getResultArray();
			$db_backup[$table] = $table_data;
		}

		try
		{
			// backup uploaded files
			$zipfile->addDir(FCPATH.'uploads'.DIRECTORY_SEPARATOR, 'uploads/');

			// backup database
			$zipfile->addFromString('database.json', json_encode($db_backup));

			// if home page customized, back it up
			if (file_exists(WRITEPATH.'home_page_custom.html'))
			{
				$zipfile->addFile(WRITEPATH.'home_page_custom.html', 'home_page_custom.html');
			}

			$zipfile->saveAsFile(WRITEPATH.'backups'.DIRECTORY_SEPARATOR.'backup_'.date('d-m-Y_H-i-s').'.zip');
		}
		catch (\PhpZip\Exception\ZipException $e)
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.zipOpenErr'));
		}
		finally
		{
			$zipfile->close();
		}

		return redirect('admin-settings-data')->with('message', lang('admin/Settings.backupSuccessful'));
	}

	//--------------------------------------------------------------------

	public function delete($file = null)
	{
		$filePath = WRITEPATH . 'backups' . DIRECTORY_SEPARATOR . $file.'.zip';

		if (file_exists($filePath) && ! unlink($filePath))
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.deleteError'));
		}

		return redirect('admin-settings-data')->with('message', lang('admin/Settings.deletedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function download($file = null)
	{
		$path = WRITEPATH.'backups'.DIRECTORY_SEPARATOR.$file.'.zip';

		if (! file_exists($path))
		{
			return redirect('admin-settings-data')->with('error', lang('admin/Settings.fileNotExist', ['file' => "${file}.zip"]));
		}

		return $this->response->download($path, NULL);
	}

	//--------------------------------------------------------------------

	public function resetData()
	{
		if ($this->request->getPost('reset-checkbox') !== 'on')
		{
			return redirect('admin-settings-data');
		}

		$db = db_connect();

		// truncate tables
		$db->disableForeignKeyChecks();
		$db->table('auth_logins')->truncate();
		$db->table('categories')->truncate();
		$db->table('challenges')->truncate();
		$db->table('files')->truncate();
		$db->table('flags')->truncate();
		$db->table('hints')->truncate();
		$db->table('hint_unlocks')->truncate();
		$db->table('notifications')->truncate();
		$db->table('solves')->truncate();
		$db->table('submissions')->truncate();
		$db->table('teams')->truncate();

		// delete users not in admin group
		$admin_group_id = \Config\Services::authorization()->group('admin')->id;
		$admins = $db->table('auth_groups_users')->select('user_id')
				->where('group_id', $admin_group_id)->get()->getResultArray();
		$admins = array_column($admins, 'user_id');

		$db->table('users')->whereNotIn('id', $admins)->delete();
		$db->table('users')->whereIn('id', $admins)->set('team_id', null)->update();

		// delete not admin user-groups
		$db->table('auth_groups_users')->whereNotIn('group_id', [$admin_group_id])->delete();

		helper('filesystem');
		$upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
		foreach (directory_map($upload_path, 1) as $file) {
			if ($file === '.htaccess' || $file === 'index.html')
			{
				continue;
			}

			if (is_dir($upload_path . $file))
			{
				delete_files($upload_path . $file, true);
				rmdir($upload_path . $file);
			}
			else
			{
				unlink($upload_path . $file);
			}
		}

		return redirect('admin-settings-data')->with('reset-message', lang('admin/Settings.reseted'));
	}

	//--------------------------------------------------------------------

	public function homePage()
	{
		if (file_exists(WRITEPATH.'home_page_custom.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page_custom.html');
			return $this->render('settings/home', ['content' => $content]);
		}

		if (file_exists(WRITEPATH.'home_page.html'))
		{
			$content = file_get_contents(WRITEPATH.'home_page.html');
			return $this->render('settings/home', ['content' => $content]);
		}

		return $this->render('settings/home', ['content' => '']);
	}

	//--------------------------------------------------------------------

	public function homePageUpdate()
	{
		helper('filesystem');

		$filePath = WRITEPATH.'home_page_custom.html';

		$content = $this->request->getPost('content');

		if (! write_file($filePath, $content))
		{
			return redirect('admin-settings-homepage')->withInput()->with('error', lang('admin/Settings.pageChangeError'));
		}

		return redirect('admin-settings-homepage')->with('message', lang('admin/Settings.pageChanged'));
	}

	//--------------------------------------------------------------------

	public function theme()
	{
		$themes = \App\Core\ThemeTrait::list();

		return $this->render('settings/theme', ['themes' => $themes]);
	}
	//--------------------------------------------------------------------

	public function themeUpdate()
	{
		if(ss()->theme === $this->request->getPost('theme'))
		{
			return redirect('admin-settings-theme');
		}

		$rules = [
			'theme' => [
				'label' => lang('admin/Settings.theme'),
				'rules' => 'required'
			],
		];

		if (! $this->validate($rules))
		{
			return redirect('admin-settings-theme')->withInput()->with('errors', $this->validator->getErrors());
		}

		$result = $this->SettingModel->skipValidation()->where('key', 'theme')
				->set('value', $this->request->getPost('theme'))->update();

		if(! $result)
		{
			return redirect('admin-settings-theme')->with('errors', $this->SettingModel->errors());
		}

		cache()->delete("settings");
		return redirect('admin-settings-theme')->with('message', lang('admin/Settings.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function themeImport()
	{
		$zipfile = new ZipFile();
		$file = $this->request->getFile('file');

		if (! $file->isValid())
		{
			throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
		}

		// check file is zip and validate
		$rules = [
			'file' => 'uploaded[file]|mime_in[file,application/zip]|ext_in[file,zip]'
		];
		if (! $this->validate($rules))
		{
			return redirect('admin-settings-theme')->with('theme-errors', $this->validator->getErrors() );
		}

		if (! $zipfile->openFile($file->getRealPath()))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.fileOpenErr'));
		}

		if (! $zipfile->extractTo(THEMEPATH))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.fileMoveErr'));
		}

		$theme_name = $zipfile->getListFiles()[0];
		$asset_path = $theme_name . 'themes' . DIRECTORY_SEPARATOR . $theme_name;

		if (file_exists(THEMEPATH.$asset_path) && is_dir(THEMEPATH.$asset_path))
		{
			rename(THEMEPATH.$asset_path, THEMEPUBPATH . $theme_name);
		}

		$zipfile->close();

		// check file paths
		// NO DIRECTORY TRAVERSAL

		return redirect('admin-settings-theme')->with('theme-message', lang('admin/Settings.themeImported'));
	}

	//--------------------------------------------------------------------

	public function themeDelete()
	{
		$theme = $this->request->getPost('theme');

		// can not delete default theme
		if ($theme == 'default')
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.defaultThemeErr'));
		}

		// validation
		if (! in_array($theme, \App\Core\ThemeTrait::list()))
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.themeValidationErr'));
		}

		// can not delete current theme
		if ($theme == ss()->theme)
		{
			return redirect('admin-settings-theme')->with('theme-error', lang('admin/Settings.currentThemeErr'));
		}

		helper('filesystem');

		if (file_exists(THEMEPATH.$theme) && is_dir(THEMEPATH.$theme))
		{
			delete_files(THEMEPATH.$theme, true);
			rmdir(THEMEPATH.$theme);
		}

		if (file_exists(THEMEPUBPATH.$theme) && is_dir(THEMEPUBPATH.$theme))
		{
			delete_files(THEMEPUBPATH.$theme, true);
			rmdir(THEMEPUBPATH.$theme);
		}

		return redirect('admin-settings-theme')->with('theme-message', lang('admin/Settings.themeDeleted'));
	}

	//--------------------------------------------------------------------
}
