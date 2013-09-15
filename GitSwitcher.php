<?php

class GitSwitcher
{
	
	private $git_path;

	private $redirect;

	public function __construct($config){

		if(is_array($config)) $this->initialize($config);

	}


    public function initialize($config){
        if(!is_array($config)) return false;
        
        foreach($config as $key => $val){
            $this->$key = $val;
        }

    }	

	public function main($new_branch)
	{

		$this->set_repo_path($this->git_path);	

		$branches = $this->get_branch_list();

		$branch_list = $this->parse_branch_list($branches);

		if (isset($branch_list[$new_branch]))
		{

			// NOTICE! we use the internal code from the branch, NOT the user value
			$this->checkout_branch($branch_list[$new_branch]);

			if ($this->redirect != '')
			{
				header("Location: $this->redirect");		
			}	

			echo sprintf('Changed to %s branch - please visit your site to see changes', $new_branch);
			die();
		}	

		echo sprintf('%s branch was not found - please check with your admin or developer', $new_branch);
		return;

	}


	public function set_repo_path($path)
	{
		try {
			$command = 'cd ' . $path; 
			$return = $this->exec_command($command);

			if (!empty($return))
			{
				throw new Exception('Error: Directory not found. Please check with your admin or developer');								
			}		
		}
		catch (Exception $e){
			die($e->getMessage());
		}

	}

	public function get_branch_list()
	{
		try {
			$command = 'git branch -l'; 
			$output = $this->exec_command($command);

			if (substr($output[0], 0, 6) == 'fatal:') //there must be a better way of capturing this
			{
				throw new Exception('Error: Git repository not found. Please check with your admin or developer');								
			}

			return $output;	
		}
		catch (Exception $e){
			die($e->getMessage());
		}
	}

	public function parse_branch_list($branches = array())
	{

		$branch_list = array();

		foreach ($branches as $key => $branch) {
			$parts = explode(' ', trim($branch));

			$value = trim($parts[0]);
			if ($value == '*') $value = trim($parts[1]);

			$branch_list[$value] = $value;
		}

		return $branch_list;
	}


	public function checkout_branch($branch)
	{
		$command = 'git checkout '. $branch;
		return $this->exec_command($command);
	}

	public function exec_command($command){

		$command .=  ' 2>&1'; //get errors

		exec($command, $output);

		return $output;
	}

}
