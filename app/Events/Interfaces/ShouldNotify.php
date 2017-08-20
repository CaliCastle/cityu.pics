<?php

namespace App\Events\Interfaces;

interface ShouldNotify
{
    /**
     * Get notification attributes.
     *
     * @return mixed
     */
    public function getNotification();

    /**
     * Store the related user.
     *
     * @return mixed
     */
    public function user();

    /**
     * Gets the notification message key for translation.
     *
     * @return mixed
     */
    public function getMessageKey();

    /**
     * Determines should notify or not.
     *
     * @return bool
     */
    public function shouldNotify();
}