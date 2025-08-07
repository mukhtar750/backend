<?php

namespace App\Helpers;

class RoleHelper
{
    /**
     * Convert role to proper display format
     * 
     * @param string $role
     * @return string
     */
    public static function displayRole($role)
    {
        $roleMap = [
            'bdsp' => 'BDSP',
            'entrepreneur' => 'Entrepreneur',
            'investor' => 'Investor',
            'mentor' => 'Mentor',
            'mentee' => 'Mentee',
            'admin' => 'Admin'
        ];

        return $roleMap[strtolower($role)] ?? ucfirst($role);
    }

    /**
     * Get the full name for BDSP
     * 
     * @return string
     */
    public static function getBDSPFullName()
    {
        return 'Business Development Service Provider';
    }
}
