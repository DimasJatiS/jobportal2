<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Lamaran Baru: ' . $this->application->job->title)
            ->greeting('Halo Admin,')
            ->line('Ada lamaran baru yang masuk.')
            ->line('Pelamar: ' . $this->application->user->name)
            ->line('Posisi: ' . $this->application->job->title)
            ->line('Perusahaan: ' . $this->application->job->company)
            ->action('Lihat Detail', url('/admin/applications?job=' . $this->application->job_id))
            ->line('Terima kasih telah menggunakan sistem rekrutmen ini.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'user_name'      => $this->application->user->name,
            'job_title'      => $this->application->job->title,
            'company'        => $this->application->job->company,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
