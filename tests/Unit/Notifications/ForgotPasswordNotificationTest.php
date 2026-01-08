<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ForgotPasswordNotificationTest extends TestCase
{
    public function test_notification_is_sent_via_mail(): void
    {
        $notification = new ForgotPasswordNotification('123456');

        $this->assertSame(['mail'], $notification->via(new User()));
    }

    public function test_mail_message_contains_correct_subject_and_view_data(): void
    {
        $user = User::factory()->make([
            'password' => Hash::make('secret123'),
        ]);

        $code = 'ABC123';
        $notification = new ForgotPasswordNotification($code);

        $mailMessage = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);

        $this->assertSame(
            '(MRRGroup) Otoszroto - Password Reset Code',
            $mailMessage->subject
        );

        $this->assertSame('emails.forgotPassword', $mailMessage->view);

        $this->assertSame($code, $mailMessage->viewData['code']);
        $this->assertSame($user, $mailMessage->viewData['user']);
    }
}
