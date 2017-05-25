<?php

namespace App\Models\Interfaces;

/**
 * Interface Controller.
 */
interface Controller
{
    /**
     * Register Process.
     *
     * @return mixed
     */
    public function register();

    /**
     * List Process.
     *
     * @return mixed
     */
    public function list();
}
