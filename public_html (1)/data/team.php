<?php

declare(strict_types=1);

/**
 * Fallback/seed team member data, used by team_members_data() when the
 * admin database is unavailable or has not been seeded yet. Once
 * seeded, the admin panel (Team Members CRUD) is the source of truth —
 * see admin/team.php and src/Repository.php.
 */

return [
    [
        'id' => 1,
        'name' => 'Mr. Asupathi Shanmugasundaram',
        'designation' => 'Managing Director',
        'photo_path' => null,
        'display_order' => 1,
    ],
    [
        'id' => 2,
        'name' => 'Mr. Santhanavelu',
        'designation' => 'Projects Manager',
        'photo_path' => null,
        'display_order' => 2,
    ],
];
