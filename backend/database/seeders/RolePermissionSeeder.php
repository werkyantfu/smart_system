<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Students
            'student.view', 'student.create', 'student.edit', 'student.delete',
            // Teachers
            'teacher.view', 'teacher.create', 'teacher.edit', 'teacher.delete',
            // Classes
            'class.view', 'class.create', 'class.edit', 'class.delete',
            // Subjects
            'subject.view', 'subject.create', 'subject.edit', 'subject.delete',
            // Attendance
            'attendance.view', 'attendance.mark', 'attendance.report',
            // Marks
            'mark.view', 'mark.enter', 'mark.report',
            // Fees
            'fee.view', 'fee.create', 'fee.edit', 'fee.delete',
            // Payments
            'payment.view', 'payment.record', 'payment.refund',
            // Announcements
            'announcement.view', 'announcement.create', 'announcement.delete',
            // Reports
            'report.view', 'report.export',
            // Dashboard
            'dashboard.view',
            // Settings
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $director = Role::firstOrCreate(['name' => 'director']);
        $director->givePermissionTo([
            'student.view', 'teacher.view', 'class.view', 'subject.view',
            'attendance.view', 'attendance.report',
            'mark.view', 'mark.report',
            'fee.view', 'payment.view',
            'announcement.view', 'report.view', 'report.export', 'dashboard.view',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'student.view', 'class.view', 'subject.view',
            'attendance.view', 'attendance.mark', 'attendance.report',
            'mark.view', 'mark.enter', 'mark.report',
            'announcement.view', 'dashboard.view',
        ]);

        $accountant = Role::firstOrCreate(['name' => 'accountant']);
        $accountant->givePermissionTo([
            'student.view', 'fee.view', 'fee.create', 'fee.edit', 'fee.delete',
            'payment.view', 'payment.record', 'payment.refund',
            'report.view', 'report.export', 'dashboard.view',
        ]);

        $librarian = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->givePermissionTo([
            'student.view', 'announcement.view', 'dashboard.view',
        ]);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'mark.view', 'attendance.view', 'announcement.view',
        ]);

        $parent = Role::firstOrCreate(['name' => 'parent']);
        $parent->givePermissionTo([
            'mark.view', 'attendance.view', 'fee.view', 'payment.record',
            'announcement.view',
        ]);

        $this->command->info('✅ Roles and permissions created!');
    }
}
