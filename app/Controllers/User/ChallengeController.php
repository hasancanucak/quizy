<?php namespace App\Controllers\User;

use App\Core\UserController;

use App\Models\ChallengeModel;
use App\Models\CategoryModel;
use App\Models\SolvesModel;
use App\Models\HintModel;
use App\Models\HintUnlockModel;
use App\Models\FileModel;
use App\Models\FlagModel;

class ChallengeController extends UserController
{
	/** @var ChallengeModel **/
	protected $challengeModel;

	/** @var CategoryModel **/
	protected $categorygeModel;

	/** @var SolvesModel **/
	protected $solvesModel;

	/** @var HintModel **/
	protected $hintModel;

	/** @var FileModel **/
	protected $fileModel;

	/** @var FlagModel **/
	protected $flagModel;

	//--------------------------------------------------------------------

	public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);
		
		$this->challengeModel  = new ChallengeModel();
		$this->categorygeModel = new CategoryModel();
		$this->solvesModel     = new SolvesModel();
		$this->hintModel       = new HintModel();
		$this->fileModel       = new FileModel();
		$this->flagModel       = new FlagModel();
	}

	//--------------------------------------------------------------------
	
	public function challenges()
	{
		$challenges = $this->challengeModel->where('is_active', '1')->findAll();
		$categories = $this->categorygeModel->findAll();
		$viewData['solves'] = $this->solvesModel->where('team_id', user()->team_id)
				->findColumn('challenge_id') ?? [];

		foreach ($categories as $c_key => $c_val) {
			$arr = array_filter($challenges, function($challenge) use ($c_val) {
				return $challenge->category_id == $c_val->id;
			});

			if(! empty($arr))
			{
				$categories[$c_key]->challenges = $arr;
			}
		}

		$viewData['categories'] = $categories;

		return $this->render('challenges', $viewData);
	}

	//--------------------------------------------------------------------

	public function challenge($id = null)
	{
		$challenge = $this->challengeModel->find($id);
		if ($challenge->is_active !== true)
		{
			return redirect('challenges');
		}

		$isSolved = $this->solvesModel->isSolved(user()->team_id, $id);
		$hints = $this->hintModel->where('challenge_id', $id)
				->where('is_active', '1')
				->orderBy('id')
				->findAll();
		$hints_unlocks = (new HintUnlockModel())
				->where('challenge_id', $id)
				->where('team_id', user()->team_id)
				->findColumn('hint_id') ?? [];
		$firstblood = $this->solvesModel
				->select(['teams.name', 'solves.created_at'])
				->from('teams')
				->where('challenge_id', $id)
				->where('solves.team_id', 'teams.id', false)
				->orderBy('solves.created_at')
				->first();
		$files = $this->fileModel->where('challenge_id', $id)->findAll();
		$solvers = $this->solvesModel
				->where('teams.id', 'solves.team_id', false)
				->select(['teams.id', 'teams.name', 'solves.created_at AS date'])
				->where('solves.challenge_id', $id)
				->orderBy('solves.created_at')
				->findAll();

		return $this->render('challenge', [
			'challenge'     => $challenge,
			'hints'         => $hints,
			'hints_unlocks' => $hints_unlocks,
			'firstblood'    => $firstblood,
			'files'         => $files,
			'solvers'       => $solvers,
			'isSolved'      => $isSolved
		]);
	}

	//--------------------------------------------------------------------

	public function flagSubmit($challengeID = null)
	{
		$flaglib = new \App\Libraries\Flag();
		$flags = $this->flagModel->where('challenge_id', $challengeID)->findAll();
		$submited_flag = $this->request->getPost('flag');

		$result = false;
		$result = $flaglib->check($submited_flag, $flags);

		$flaglib->log([
			'challenge_id' => $challengeID,
			'user_id'      => user()->id,
			'team_id'      => user()->team_id,
			'ip'           => $this->request->getIPAddress(),
			'provided'     => $submited_flag,
			'type'         => $result ? '1' : '0',
		]);

		$submission_count = (new \App\Models\SubmissionModel())->where([
			'team_id'      => user()->team_id,
			'challenge_id' => $challengeID,
		])->countAllResults();
		
		$challenge = $this->challengeModel->find($challengeID);
		if ($challenge->max_attempts != '0' && $submission_count > $challenge->max_attempts)
		{
			if (! $result)
			{
				redirect()->with('error', lang('Home.maxAttemptReached'));
			}
			return redirect()->route('challenge-detail', [$challengeID])->with('result', $result);
		}

		if (! $result)
		{
			return redirect()->to("/challenges/$challengeID")->with('result', $result);
		}

		$solved_before = $flaglib->isAlreadySolved($challengeID, user()->team_id);

		if ($solved_before === true || user()->team_id === null)
		{
			return redirect()->to("/challenges/$challengeID")->with('result', $result);
		}

		$db_result = $this->solvesModel->insert([
			'challenge_id' => $challengeID,
			'team_id'      => user()->team_id,
			'user_id'      => user()->id,
		]);

		if (! $db_result)
		{
			$errors = $this->solvesModel->errors();
			return redirect()->to("/challenges/$challengeID")->with('result', $result)->with('errors', $errors);
		}

		return redirect()->to("/challenges/$challengeID")->with('result', $result);
	}

	//--------------------------------------------------------------------

	public function hint($challengeID = null, $hintID = null)
	{
		$hintUnlockModel = new HintUnlockModel();

		$data = [
			'hint_id'      => $hintID,
			'user_id'      => user()->id,
			'team_id'      => user()->team_id,
			'challenge_id' => $challengeID,
		];

		$result = $hintUnlockModel->insert($data);

		if (! $result)
		{
			$errors = $hintUnlockModel->errors();
			return redirect()->to("/challenges/$challengeID")->with('errors', $errors);
		}

		return redirect()->to("/challenges/$challengeID");
	}

	//--------------------------------------------------------------------
}
