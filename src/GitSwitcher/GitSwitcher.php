<?php

namespace GitSwitcher;

class GitSwitcher
{
	/**
	 * Path to the git repo
	 * @var string
	 */
	private $git_path;

	/**
	 * URL path to redirect to
	 * @var string
	 */
	private $redirect;

	/**
	 * Constructor
	 * @param array $config Array containing git_path and redirect
	 */
	public function __construct(array $config){
		foreach($config as $key => $val){
            $this->$key = $val;
        }
	}	

	/**
	 * Method to switch branch
	 * 
	 * @param  string $new_branch Branch name
	 * @return mixed             Redirect or exception
	 */
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

	/**
	 * Set repository path
	 * 
	 * @param string $path Full path to repository
	 */
	protected function set_repo_path($path)
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

	/**
	 * Get list of branches in repo
	 * 
	 * @return string List of branches in repo
	 */
	protected function get_branch_list()
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

	/**
	 * Parse branches
	 * 
	 * @param  array  $branches array containing branches
	 * @return array            array containing all branches
	 */
	protected function parse_branch_list($branches = array())
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

	/**
	 * Checkout branch
	 * 
	 * @param  string $branch Name of branch to be checked out
	 * @return mixed          Something...
	 */
	protected function checkout_branch($branch)
	{
		$command = 'git checkout '. $branch .' 2>&1';
		return exec($command, $output);
	}

}
