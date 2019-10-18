<?php namespace App\Controllers\Admin;

use \App\Models\HintModel;

class HintController extends \App\Controllers\BaseController
{
	protected $challengeModel = null;

	public function __construct()
	{
		$this->hintModel = new HintModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
		
	}

	//--------------------------------------------------------------------

	public function new()
	{
		
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{
		
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
		
	}

	//--------------------------------------------------------------------

	public function create($challengeID = null)
	{
		$data = [
			'challenge_id'	=> $challengeID,
			'cost'			=> $this->request->getPost('cost'),
			'content'		=> $this->request->getPost('content'),
			'is_active'		=> $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->insert($data);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->to("/admin/challenges/$challengeID");
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}

	//--------------------------------------------------------------------

	public function delete($challengeID = null, $hintID = null)
	{
		$result = $this->hintModel->delete($hintID);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->back()->with('errors', $errors);
        }

        return redirect()->back();
	}

	//--------------------------------------------------------------------

	public function update($challengeID = null, $id = null)
	{
		$data = [
			'cost'			=> $this->request->getPost('cost'),
			'content'		=> $this->request->getPost('content'),
			'is_active'		=> $this->request->getPost('is_active'),
		];

		$result = $this->hintModel->update($id, $data);

		if (! $result)
        {
            $errors = $this->hintModel->errors();
            return redirect()->back()->with('errors', $errors);
        }

        return redirect()->to("/admin/challenges/$challengeID");
	}
}