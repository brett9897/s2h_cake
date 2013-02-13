<?php

class WelcomeController extends AppController {

	public function isAuthorized($user = null)
	{
		//non admin pages can be accessed by anyone
		if( empty($this->request->params['admin']) )
		{
			return true;
		}

		//only admins can access admin actions
		if( isset($this->request->params['admin']) )
		{
			if($user['type'] !== 'admin' && $user['type'] !== 'superAdmin')
			{
				$this->redirect(array('action' => 'index', 'admin' => false));
			}
			else
			{
				return true;
			}
		}

		//default deny
		return false;
	}

    public function index() {
        
    }

    public function admin_index()
    {
    	$this->index();
    	$this->render("index");
    }

}

?>