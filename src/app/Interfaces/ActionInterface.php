<?php

namespace Game\App\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface ActionInterface
{
    /**
     * Handle request action
     */
    public function handle(Request $request): array;
}