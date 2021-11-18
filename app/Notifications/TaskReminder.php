<?php

namespace App\Notifications;

use App\Models\Task;
use http\Client\Curl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskReminder extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Task
     */
    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = \App\Models\User::find($this->task->user_id);

        $timeleft = date_diff(
            date_create(strtotime($this->task->datetime)),
            date_create(now($user->timezone))
        )->format('%h hours');

        dd($timeleft);

        return (new MailMessage)
            ->line('You have ' . $timeleft . ' left for ' . $this->task->title)
            ->action('Notification Action', url(route('task.show', $this->task)))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
