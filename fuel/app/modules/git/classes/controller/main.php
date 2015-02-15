<?php

namespace Git;

use \Response;
use \View;
use \Asset;

class Controller_Main extends \Controller_Main {

    private $repo;
    private $shell;

    public function before() {

        parent::before();

        $this->repo = \Input::post('repo');

        $this->shell = new \Shell();
        $this->shell->save_wd = false;
        \Config::load('git::config');
    }

    public function action_index() {

        $asset = Asset::forge('git', array('paths' => array('assets/git'), 'auto_render' => false));
        $asset->js('scripts.js');
        $asset->css('style.css');

        return Response::forge(View::forge('index'));
    }

    public function action_repositories() {

        $projects_dir = realpath(\Config::get('projects_dir'));
        
        $git_projects = $this->shell->exec('cd ' . $projects_dir . ';find ./ -type d -name ".git";');
        $git_projects = explode("/.git", $git_projects);

        $git_projects_texts = $git_projects = array_reverse($git_projects);
        $used_keys = array();

        foreach ($git_projects as $key1 => $git_project1) {

            $git_project1 = trim($git_project1);
            if (empty($git_project1)) {
                continue;
            }

            $git_projects[$key1] = $git_project1;
            $git_project1 = str_replace('/', '\/', $git_project1);

            foreach ($git_projects as $key2 => $git_project2) {
                $git_project2 = trim($git_project2);
                if (empty($git_project2)) {
                    unset($git_projects[$key2]);
                    continue;
                }
                if (!in_array($key2, $used_keys) && preg_match('/' . $git_project1 . '\//', $git_project2)) {
                    $nbsp = count(explode('/', $git_project1));
                    $nbsp_str = '';
                    for ($i = 0; $i <= $nbsp; $i++) {
                        $nbsp_str .= '&nbsp;';
                    }
                    $git_projects_texts[$key2] = preg_replace('/' . $git_project1 . '\//', $nbsp_str . '-&nbsp;/', $git_project2);
                    $used_keys[] = $key2;
                }
            }
        }

        $git_projects = array_reverse($git_projects);
        $git_projects_texts = array_reverse($git_projects_texts);

        $git_projects_arr = array();
        foreach ($git_projects as $key => $git_project) {
            $git_projects_texts[$key] = str_replace(DOCROOT, '', $git_projects_texts[$key]);
            $git_projects_arr[] = array($git_project, $git_projects_texts[$key]);
        }

        echo json_encode($git_projects_arr);
    }

    public function action_repository_details() {

        $data = array();

        $cd = 'cd ' . $this->repo . ';';

        $branches_str = $this->shell->exec($cd . 'git branch -a');
        $branches_arr = explode(PHP_EOL, $branches_str);

        foreach ($branches_arr as $branch) {
            $branch = trim($branch);

            if (preg_match('/^\*/', $branch)) {
                $branch = trim($branch, '* ');
                $data['branches']['active'] = $branch;
            }

            if (preg_match('/^remotes/', $branch)) {
                $data['branches']['remotes'][] = $branch;
            } else {
                $data['branches']['local'][] = $branch;
            }
        }

        $remote_str = $this->shell->exec($cd . 'git remote -v');
        $remote = explode(PHP_EOL, $remote_str);
        $data['remote']['fetch'] = trim($remote[0]);
        $data['remote']['push'] = trim($remote[1]);

        $remote = $this->shell->exec($cd . 'git remote show origin');
        $remote = explode(':', $remote);
        $data['branches']['status'] = end($remote);

        $log_str = $this->shell->exec($cd . 'git log -n 50');
        $data['log'] = $log_str;

        return Response::forge(View::forge('repository_info', $data));
    }

    public function action_pull() {

        $cd = 'cd ' . $this->repo . ';';

        $branch = explode('/', \Input::post('branch'));
        $branch = end($branch);
        $cmd = $cd . 'git pull origin ' . $branch;

        $output = $this->shell->exec($cmd);

        echo $output;
    }

    public function action_switch() {

        $cd = 'cd ' . $this->repo . ';';
        $branch = explode('/', \Input::post('branch'));
        $branch = end($branch);

        $cmd = $cd . 'git checkout ' . $branch;

        $output = $this->shell->exec($cmd);

        echo $output;
    }

    public function action_fetch() {

        $cd = 'cd ' . $this->repo . ';';
        $cmd = $cd . 'git fetch';

        $output = $this->shell->exec($cmd);

        echo $output;
    }

    public function action_showCommit() {

        $cd = 'cd ' . $this->repo . ';';
        $cmd = $cd . 'git show ' . trim(\Input::post('commit'));

        $output = $this->shell->exec($cmd);

        $output = htmlspecialchars($output);

        $output_arr = explode(PHP_EOL, $output);

        foreach ($output_arr as &$output_str) {

            if (preg_match('/^-(.*)/', $output_str)) {
                $output_str = '<span class="removed" >' . $output_str . '</span>';
            } elseif (preg_match('/^\+(.*)/', $output_str)) {
                $output_str = '<span class="added" >' . $output_str . '</span>';
            } elseif (preg_match('/^\@@(.*)@@/', $output_str)) {
                $output_str = preg_replace('/^@@(.*)@@(.*)/', '<span class="info" >@@$1@@</span> $2', $output_str);
            } elseif (preg_match('/^diff(.*)/', $output_str)) {
                $output_str = '<span class="diff" >' . $output_str . '</span>';
            } elseif (preg_match('/^commit(.*)/', $output_str)) {
                $output_str = str_replace('commit', 'Commit:', $output_str);
            }
        }
        $output = implode(PHP_EOL, $output_arr);

        echo $output;
    }

}
