<?php

namespace App\Notifications;

use App\Models\Goal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GoalOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The goal instance.
     *
     * @var \App\Models\Goal
     */
    public $goal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Goal Deadline Passed: ' . $this->goal->title)
            ->line('You missed the deadline for your goal: ' . $this->goal->title)
            ->line('Recommendations:')
            ->line('- Break the goal into smaller steps')
            ->line('- Adjust your timeline if needed')
            ->line('- Seek help from colleagues if stuck')
            ->action('View Goal', route('goals'))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'goal_id' => $this->goal->id,
            'title' => $this->goal->title,
            'message' => 'Goal deadline passed: ' . $this->goal->title,
        ];
    }
}
