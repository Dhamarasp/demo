<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Libraries\Sendpulse\RestApi\ApiClient;
use App\Libraries\Sendpulse\RestApi\Storage\FileStorage;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send email to account activation
        $API_USER_ID = env('SENDPULSE_API_USER_ID', '');
        $API_SECRET = env('SENDPULSE_API_SECRET', '');
        $SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage('../storage/sendpulse_token/'));
        $SPApiClient->smtpSendMail($this->email);
    }
}
