<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gitrepomodel;
use App\Models\Gitrepoitemmodel;
use App\Models\User;
use Auth;
use App\Jobs\GetGithubIssues;
use App\Jobs\GetGithubIssueSecond;
use App\Jobs\GetGithubIssueThird;


class Githubcontroller extends Controller
{
    

    public function index(){
        return view('github/github_form');
    }

    public function list(){
        $data = Gitrepomodel::orderby('id','desc')->paginate(10);
        return view('github/list', compact('data'));
    }

    public function IssueList($id){
        $data = Gitrepoitemmodel::where('gitrepo_id',$id)->orderby('id','desc')->paginate(10);
        return view('github/issue-list', compact('data'));
    }

    

    public function GetGitData(Request $request){
        $string= $request->github_url;
        $omit_words = array('https://github.com/','.git');   
        rsort($omit_words); 
        $repo_name=str_replace($omit_words,'',$string);
        
        $Gitrepomodel = new Gitrepomodel;        
        $Gitrepomodel->name = $repo_name;
        $Gitrepomodel->status = 'Active';
        $Gitrepomodel->created_by = Auth::user()->id;    
        $save=$Gitrepomodel->save();
        $last_id=$Gitrepomodel->id;
        GetGithubIssues::dispatch($last_id,$repo_name);
        GetGithubIssueSecond::dispatch($last_id,$repo_name);
        GetGithubIssueThird::dispatch($last_id,$repo_name);

        
        if($save){
            return redirect('/list')->with(['class' => 'success_font','message'=>'Fetching data from API are in progress']);
        } else {           
            return redirect()->back()->with(['class' => 'error_font','message'=>'Something went wrong']);
        }
        
    }
}
