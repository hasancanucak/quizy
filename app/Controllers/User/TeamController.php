<?php namespace App\Controllers\User;


use App\Core\UserController;
use App\Models\TeamModel;
use App\Models\UserModel;


class TeamController extends UserController
{
	/** @var TeamModel **/
	protected $teamModel;

	/** @var UserModel **/
	protected $userModel;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->teamModel = new TeamModel();
		$this->userModel = new UserModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		if (user()->team_id === null)
		{
			return $this->render('noteam');
		}

		$team = $this->teamModel->find(user()->team_id);
		$team_members = $this->userModel->where('team_id', user()->team_id)->findAll();

		$viewData['team'] = $team;
		$viewData['team_members'] = $team_members;

		return $this->render('team', $viewData);
	}

	//--------------------------------------------------------------------

	public function createTeam()
	{
		if (user()->team_id !== null)
		{
			return redirect('team')->with('message', lang('Home.alreadyHaveTeam'));
		}

		$data = [
			'leader_id' => user()->id,
			'name'      => $this->request->getPost('name'),
			'is_banned' => '0',
			'auth_code' => bin2hex(random_bytes(config('Quizy')->authCodeSize)),
		];

		$team_id = $this->teamModel->insert($data);
		if (! $team_id)
		{
			return redirect('team')->withInput()->with('createteam-errors', $this->teamModel->errors());
		}

		$result = $this->userModel->update(user()->id, ['team_id' => $team_id]);
		if (! $result)
		{
			return redirect('team')->withInput()->with('createteam-errors', $this->userModel->errors());
		}

		return redirect('team')->with('message', lang('Home.teamCreated'));
	}

	//--------------------------------------------------------------------

	public function joinTeam()
	{
		if (user()->team_id !== null)
		{
			return redirect('team')->with('message', lang('Home.alreadyHaveTeam'));
		}

		$auth_code = $this->request->getPost('auth_code');

		$team = $this->teamModel->where('auth_code', $auth_code)->first();

		if ($team === null)
		{
			return redirect('team')->withInput()->with('jointeam-error', lang('Home.teamNotFound'));
		}

		$teamMemberCount = $this->userModel->where('team_id', $team->id)->countAllResults();
		if ($teamMemberCount >= ss()->team_member_limit)
		{
			return redirect('team')->with('jointeam-error', lang('Home.teamMaxMember'));
		}

		$result = $this->userModel->update(user()->id, ['team_id'=> $team->id]);
		if (! $result)
		{
			return redirect('team')->withInput()->with('jointeam-errors', $this->userModel->errors());
		}

		return redirect('team')->with('message', lang('Home.joinedTeam'));
	}

	//--------------------------------------------------------------------
}
