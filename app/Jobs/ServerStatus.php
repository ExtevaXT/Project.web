<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ServerStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $GLOBALS['server_status'] = $this->status();
    }

    function status(){
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => 'https://check-host.net/check-udp?host=91.197.1.60:7777&node=ru1.node.check-host.net',
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE        => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        usleep(100);
        if(!$response) return false;
        return $this->checkResult(json_decode($response)->request_id);
    }
    function checkResult($requestId){
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => 'https://check-host.net/check-result/'.$requestId,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE        => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return collect(json_decode($response, true))->first()==null;
    }
}
