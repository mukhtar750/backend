<?php

namespace App\Notifications;

trait RoleBasedUrlTrait
{
    protected function generateActionUrl($notifiable, $baseRoute)
    {
        $role = $notifiable->role;
        switch ($role) {
            case 'bdsp':
                return route('bdsp.' . $baseRoute);
            case 'mentor':
                return route('mentor.' . $baseRoute);
            case 'entrepreneur':
                return route($baseRoute);
            case 'investor':
                if ($baseRoute === 'dashboard') {
                    return route('dashboard.investor');
                }
                return route('investor.' . $baseRoute);
            case 'admin':
                return route('admin.' . $baseRoute);
            default:
                return route($baseRoute);
        }
    }
}