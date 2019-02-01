<?php

namespace Alacrity\Core\app\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage)
            ->subject(trans('Verify Email Address'))
            ->line(trans('Please click the button below to verify your email address.'))
            ->action(
                trans('Verify Email Address'),
                $this->verificationUrl($notifiable)
            )
            ->line(trans('If you did not create an account, no further action is required.'));
    }
}
