<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Gitrepomodel;
use App\Models\Gitrepoitemmodel;
use App\Models\User;
use Auth;

class GetGithubIssueThird implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $last_id;

    protected $repo_name;

    public function __construct($last_id,$repo_name)
    {
        $this->last_id = $last_id;
        $this->repo_name = $repo_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $last_id=$this->last_id;
        $repo_name=$this->repo_name;
        $api='https://api.github.com/repos/'.$repo_name.'/issues?per_page=100&page=3';
        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.github.v3+json',
            'Authorization: token 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',
            'User-Agent: GitHub-kamalrajs65'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($json);
        foreach($data as $row){
            $title= $row->title;
            $user=$row->user;
            $labels=$row->labels;
            $state=$row->state;
            $Gitrepoitemmodel = new Gitrepoitemmodel;
            $Gitrepoitemmodel->gitrepo_id = $last_id;        
            $Gitrepoitemmodel->title = $title;
            $Gitrepoitemmodel->status = $state;
            if(empty($labels)){
                $Gitrepoitemmodel->tags=' ';
            }else{
                $tags=array();
                foreach($labels as $row_label){
                    $tags[]= $row_label->name;                    
               }
               $string = implode(',', $tags);
               $Gitrepoitemmodel->tags = $string;
            }
            $save=$Gitrepoitemmodel->save();

        }
    }
}
