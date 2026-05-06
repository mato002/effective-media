<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'admin.dashboard.view',
            'cms.homepage.manage',
            'cms.services.manage',
            'cms.portfolio.manage',
            'cms.testimonials.manage',
            'cms.statistics.manage',
            'crm.manage',
            'quotes.manage',
            'invoices.manage',
            'inventory.manage',
            'documents.manage',
            'reports.view',
            'emails.manage',
            'settings.manage',
            'users.manage',
        ];

        $permissionModels = collect();
        foreach ($permissions as $permissionName) {
            $permissionModels[$permissionName] = Permission::findOrCreate($permissionName, 'web');
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $rolesToPermissions = [
            'super_admin' => $permissions,
            'admin' => [
                'admin.dashboard.view',
                'cms.homepage.manage',
                'cms.services.manage',
                'cms.portfolio.manage',
                'cms.testimonials.manage',
                'cms.statistics.manage',
                'crm.manage',
                'quotes.manage',
                'invoices.manage',
                'inventory.manage',
                'documents.manage',
                'reports.view',
                'emails.manage',
            ],
            'sales_staff' => [
                'admin.dashboard.view',
                'crm.manage',
                'quotes.manage',
                'documents.manage',
                'reports.view',
                'emails.manage',
            ],
            'finance_user' => [
                'admin.dashboard.view',
                'invoices.manage',
                'reports.view',
                'quotes.manage',
            ],
            'inventory_manager' => [
                'admin.dashboard.view',
                'inventory.manage',
                'reports.view',
            ],
            'content_manager' => [
                'admin.dashboard.view',
                'cms.homepage.manage',
                'cms.services.manage',
                'cms.portfolio.manage',
                'cms.testimonials.manage',
                'cms.statistics.manage',
                'documents.manage',
            ],
            'client' => [],
        ];

        foreach ($rolesToPermissions as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions(
                collect($rolePermissions)
                    ->map(fn (string $permissionName) => $permissionModels[$permissionName])
                    ->all()
            );
        }

        $seedAdminEmails = ['test@example.com', 'admin@effective-media.test'];
        $seedAdmins = User::query()
            ->whereIn('email', $seedAdminEmails)
            ->get();

        foreach ($seedAdmins as $seedAdmin) {
            $seedAdmin->syncRoles(['super_admin']);
        }
    }
}
