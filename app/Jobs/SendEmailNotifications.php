<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;
use App\Models\EmailNotification;

class SendEmailNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailNotification $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::whereNotNull("email_verified_at")->pluck("email");
        $emailService = new EmailService();

        foreach ($users as $user) {
            $details = [
                'title' => $this->email->title,
                'body' => $this->email->description,
            ];
            $emailService->setDetails($details);
            $emailService->setFrom("noreplay@example.com", "shop");
            $emailService->setSubject("اطلاعیه وبسایت");
            $emailService->setTo($user);

            $messageService = new MessageService($emailService);
            $messageService->send();
        }
    }
}
