<?php

namespace App\Mail;

use App\Models\Fruit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FruitAdded extends Mailable
{
    use Queueable, SerializesModels;

    public Fruit $fruit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Fruit $fruit)
    {
        $this->fruit = $fruit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.fruit-added');
    }
}
