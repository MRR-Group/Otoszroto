<?php

declare(strict_types=1);

namespace Otoszroto\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $code,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ["mail"];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return new MailMessage()
            ->subject("(MRRGroup) Otoszroto - Password Reset Code")
            ->view("emails.forgotPassword", [
                "code" => $this->code,
                "user" => $notifiable,
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
