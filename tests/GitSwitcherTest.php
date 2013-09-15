<?php

/**
 * GitSwitcher Tests
 *
 * @package  GitSwitcher
 * @author   David Stanley <davidstanley01@gmail.com>
 */
class GitSwitcherTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $arbitraryGitPath = 'path';
        $arbitraryRedirect = 'url';

        $gitSwitcher = new GitSwitcher\GitSwitcher($arbitraryGitPath, $arbitraryRedirect);

        $this->assertInstanceOf('GitSwitcher\GitSwitcher', $gitSwitcher);
    }

    public function testMainMethod()
    {
        $arbitraryGitPath = 'path';
        $arbitraryRedirect = 'url';
        $arbitraryBranchList = 'master,dev';

        $targetBranchName = 'dev';

        $gitSwitcherMock = $this->getMockBuilder('GitSwitcher\GitSwitcher')
            ->setConstructorArgs(array($arbitraryGitPath, $arbitraryRedirect))
            ->setMethods(array('set_repo_path', 'get_branch_list', 'parse_branch_list', 'checkout_branch'))
            ->getMock();
        $gitSwitcherMock->expects($this->once())
            ->method('set_repo_path')
            ->with($this->equalTo($arbitraryGitPath))
            ->will($this->returnValue(true));
        $gitSwitcherMock->expects($this->once())
            ->method('get_branch_list')
            ->will($this->returnValue($arbitraryBranchList));

        $gitSwitcherMock->main($targetBranchName);
    }

}