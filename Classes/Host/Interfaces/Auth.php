<?php


namespace MassUploader\Host\Interfaces;

// Требуется авторизация

class Auth
{
    abstract protected function auth();
}