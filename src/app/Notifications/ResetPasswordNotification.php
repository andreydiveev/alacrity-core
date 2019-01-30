<?php

namespace Alacrity\Core\app\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(trans('alacrity::core.password_reset.subject'))
            ->greeting(trans('alacrity::core.password_reset.greeting'))
            ->line([
                trans('alacrity::core.password_reset.line_1'),
                trans('alacrity::core.password_reset.line_2'),
            ])
            ->action(trans('alacrity::core.password_reset.button'), route('alacrity.auth.password.reset.token', $this->token).'?email='.urlencode($notifiable->getEmailForPasswordReset()))
            ->line(trans('alacrity::core.password_reset.notice'));
    }
}
