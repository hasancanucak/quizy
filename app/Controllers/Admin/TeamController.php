<?php namespace App\Controllers\Admin;

use App\Core\AdminController;
use App\Models\TeamModel;
use App\Models\UserModel;
use App\Models\ChallengeModel;
use App\Models\SolvesModel;

class TeamController extends AdminController
{
	/** @var TeamModel **/
	protected $teamModel;

	/** @var UserModel **/
	protected $userModel;

	/** @var ChallengeModel **/
	protected $challengeModel;

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		$this->teamModel      = new TeamModel();
		$this->userModel      = new UserModel();
		$this->challengeModel = new ChallengeModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$teams = $this->teamModel
				->select(['teams.*', 'users.username AS leader_username'])
				->join('users', 'teams.leader_id = users.id', 'left');

		return $this->render('team/index', [
			'teams' => $teams->paginate(20),
			'pager' => $teams->pager,
		]);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return $this->render('team/new');
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		$team = $this->teamModel->find($id);
		$teamMembers = $this->userModel->where('team_id', $id)->findAll();
		$challenges = $this->challengeModel
				->select(['challenges.id', 'challenges.name', 'solves.id AS solves_id', 'solves.user_id AS solves_user',
						'users.username AS solves_username', 'solves.team_id AS team_id', 'solves.created_at AS solves_at'])
				->join('solves', "(challenges.id = solves.challenge_id AND solves.team_id = $id)", 'left')
				->join('users', 'solves.user_id = users.id', 'left')
				->findAll();

		$viewData = [
			'team'        => $team,
			'teamMembers' => $teamMembers,
			'challenges'  => $challenges,
		];

		return $this->render('team/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$leader = $this->userModel
				->where('username', $this->request->getPost('leader_username'))
				->first();

		// make sure user found
		if ($leader === null)
		{
			return redirect('admin-teams-new')->withInput()->with('error', lang('admin/Team.noUserFound'));
		}

		// user dont have team
		if ($leader->team_id !== null)
		{
			$error = lang('admin/Team.userAlreadyHaveTeam');
			return redirect('admin-teams-new')->withInput()->with('error', $error);
		}

		$data = [
			'leader_id' => $leader->id,
			'name'      => $this->request->getPost('name'),
			'is_banned' => '0',
			'auth_code' => bin2hex(random_bytes(config('Quizy')->authCodeSize)),
		];

		try
		{
			$teamID = $this->teamModel->insert($data);
		}
		catch (\Exception $e)
		{
			// team exist with this name
			if ($e->getCode() === 1062)
			{
				return redirect('admin-teams-new')->withInput()->with('error', lang('admin/Team.teamExistWithThisName'));
			}

			return redirect('admin-teams-new')->withInput()->with('error', $e->getMessage());
		}

		if (! $teamID)
		{
			$errors = $this->teamModel->errors();
			return redirect('admin-teams-new')->withInput()->with('errors', $errors);
		}

		// add user to new team
		$leader->team_id = $teamID;
		$userUpdate = $this->userModel->save($leader);

		if (! $userUpdate)
		{
			$errors = $this->userModel->errors();
			return redirect('admin-teams-new')->withInput()->with('errors', $errors);
		}

		return redirect()->route('admin-teams-show', [$teamID])->with('message', lang('admin/Team.createdSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->teamModel->delete($id);

		if (! $result)
		{
			return redirect()->route('admin-teams-show', [$id])->with('errors', $this->teamModel->errors());
		}

		return redirect('admin-teams')->with('message', lang('admin/Team.deletedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$teamMembers = $this->userModel->where('team_id', $id)->findColumn('id') ?? [];

		$data = [
			'name'      => $this->request->getPost('name'),
			'leader_id' => $this->request->getPost('leader_id'),
		];

		if (! in_array($this->request->getPost('leader_id'), $teamMembers))
		{
			return redirect()->route('admin-teams-show', [$id])->with('error', lang('admin/Team.leaderMustInTeam'));
		}

		$result = $this->teamModel->update($id, $data);

		if (! $result)
		{
			return redirect()->route('admin-teams-show', [$id])->with('errors', $this->teamModel->errors());
		}

		return redirect()->route('admin-teams-show', [$id])->with('message', lang('admin/Team.updatedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function changeAuthCode($id = null)
	{
		$data = [
			'auth_code' => bin2hex(random_bytes(config('Quizy')->authCodeSize)),
		];

		$result = $this->teamModel->update($id, $data);

		if (! $result)
		{
			return redirect()->route('admin-teams-show', [$id])->with('errors', $this->teamModel->errors());
		}
		return redirect()->route('admin-teams-show', [$id])
				->with('message', lang('admin/Team.authCodeChanged'));
	}

	//--------------------------------------------------------------------

	public function markAsSolved($id = null)
	{
		$solvesModel = new SolvesModel();

		$data = [
			'team_id'      => $id,
			'challenge_id' => $this->request->getPost('challenge_id'),
			'user_id'      => $this->request->getPost('user_id'),
		];

		$result = $solvesModel->insert($data);

		if (! $result)
		{
			$errors = $solvesModel->errors();
			return redirect()->route('admin-teams-show', [$id])->with('mark-solved-errors', $errors);
		}

		return redirect()->route('admin-teams-show', [$id])
				->with('mark-solved-message', lang('admin/Team.markedAsSolved'));
	}

	//--------------------------------------------------------------------

	public function markAsUnsolved($teamID = null, $solvesID = null)
	{
		$solvesModel = new SolvesModel();

		$result = $solvesModel->delete($solvesID);

		if (! $result)
		{
			$errors = $solvesModel->errors();
			return redirect()->route('admin-teams-show', [$teamID])->with('mark-solved-errors', $errors);
		}

		return redirect()->route('admin-teams-show', [$teamID])
				->with('mark-solved-message', lang('admin/Team.markAsUnsolved'));
	}

	//--------------------------------------------------------------------

	public function ban($id = null)
	{
		$result = $this->teamModel->update($id, ['is_banned' => '1']);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->route('admin-teams-show', [$id])->with('errors', $errors);
		}

		// ban all the users
		$result = $this->userModel->where('team_id', $id)->set('status', 'banned')->update();

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->route('admin-teams-show', [$id])->with('errors', $errors);
		}

		return redirect()->route('admin-teams-show', [$id])->with('message', lang('admin/Team.bannedSuccessfully'));
	}

	//--------------------------------------------------------------------

	public function unBan($id = null)
	{
		$result = $this->teamModel->update($id, ['is_banned' => '0']);

		if (! $result)
		{
			$errors = $this->teamModel->errors();
			return redirect()->route('admin-teams-show', [$id])->with('errors', $errors);
		}

		// unban all the users
		$result = $this->userModel->where('team_id', $id)->set(['status' => null])->update();

		if (! $result)
		{
			$errors = $this->userModel->errors();
			return redirect()->route('admin-teams-show', [$id])->with('errors', $errors);
		}

		return redirect()->route('admin-teams-show', [$id])->with('message', lang('admin/Team.unbannedSuccessfully'));
	}

	//--------------------------------------------------------------------
}
