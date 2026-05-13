<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $userEmail;
    protected $userName;
    protected $userId;

    /**
     * Create a new notification instance.
     */
    public function __construct($userEmail, $userName, $userId)
    {
        $this->userEmail = $userEmail;
        $this->userName = $userName;
        $this->userId = $userId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Pengguna {$this->userName} ({$this->userEmail}) telah meminta reset password. Silakan buatkan password baru untuk mereka.",
            'email' => $this->userEmail,
            'name' => $this->userName,
            'user_id' => $this->userId,
            'type' => 'password_reset',
            'action_url' => route('users.edit', $this->userId)
        ];
    }
}
