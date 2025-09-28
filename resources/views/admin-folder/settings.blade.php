@extends('admin-folder.layout')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">System Settings</h2>
        <p class="text-gray-600">Configure platform settings and preferences</p>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showSettingsTab('general')" id="general-tab" class="settings-tab py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    General
                </button>
                <button onclick="showSettingsTab('users')" id="users-tab" class="settings-tab py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    User Management
                </button>
                <button onclick="showSettingsTab('notifications')" id="notifications-tab" class="settings-tab py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Notifications
                </button>
                <button onclick="showSettingsTab('security')" id="security-tab" class="settings-tab py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Security
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- General Settings -->
            <div id="general-content" class="settings-content">
                <h3 class="text-lg font-medium text-gray-900 mb-6">General Settings</h3>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                            <input type="text" id="site_name" value="BizConsult" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                            <input type="email" id="site_email" value="admin@bizconsult.com" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                        <textarea id="site_description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">Professional business consulting platform connecting experts with clients worldwide.</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                            <select id="timezone" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="UTC">UTC</option>
                                <option value="America/New_York" selected>Eastern Time</option>
                                <option value="America/Chicago">Central Time</option>
                                <option value="America/Denver">Mountain Time</option>
                                <option value="America/Los_Angeles">Pacific Time</option>
                            </select>
                        </div>
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Default Currency</label>
                            <select id="currency" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="USD" selected>USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="CAD">CAD (C$)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="maintenance_mode" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                            Enable maintenance mode
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Save General Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Management Settings -->
            <div id="users-content" class="settings-content hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-6">User Management Settings</h3>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="auto_approve_consultants" class="block text-sm font-medium text-gray-700 mb-2">Consultant Approval</label>
                            <select id="auto_approve_consultants" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="manual" selected>Manual Approval Required</option>
                                <option value="auto">Auto-approve after verification</option>
                            </select>
                        </div>
                        <div>
                            <label for="max_consultants" class="block text-sm font-medium text-gray-700 mb-2">Max Consultants</label>
                            <input type="number" id="max_consultants" value="100" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="consultant_verification" class="block text-sm font-medium text-gray-700 mb-2">Verification Requirements</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="require_resume" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="require_resume" class="ml-2 block text-sm text-gray-900">Require Resume</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="require_portfolio" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="require_portfolio" class="ml-2 block text-sm text-gray-900">Require Portfolio</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="require_references" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="require_references" class="ml-2 block text-sm text-gray-900">Require References</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="user_registration" class="block text-sm font-medium text-gray-700 mb-2">Registration Settings</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="allow_registration" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="allow_registration" class="ml-2 block text-sm text-gray-900">Allow New Registrations</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="email_verification" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="email_verification" class="ml-2 block text-sm text-gray-900">Require Email Verification</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Save User Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings -->
            <div id="notifications-content" class="settings-content hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Notification Settings</h3>
                
                <form class="space-y-6">
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Email Notifications</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">New Consultant Registration</p>
                                    <p class="text-xs text-gray-500">Notify admins when new consultants register</p>
                                </div>
                                <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Consultant Approval</p>
                                    <p class="text-xs text-gray-500">Notify consultants when approved/rejected</p>
                                </div>
                                <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">New Consultation Booking</p>
                                    <p class="text-xs text-gray-500">Notify consultants about new bookings</p>
                                </div>
                                <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">System Updates</p>
                                    <p class="text-xs text-gray-500">Notify about system maintenance and updates</p>
                                </div>
                                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">SMS Notifications</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Enable SMS Notifications</p>
                                <p class="text-xs text-gray-500">Send SMS for urgent notifications</p>
                            </div>
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div id="security-content" class="settings-content hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Security Settings</h3>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                            <input type="number" id="session_timeout" value="120" min="15" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 mb-2">Max Login Attempts</label>
                            <input type="number" id="max_login_attempts" value="5" min="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Password Requirements</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="require_uppercase" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="require_uppercase" class="ml-2 block text-sm text-gray-900">Require uppercase letters</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="require_numbers" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="require_numbers" class="ml-2 block text-sm text-gray-900">Require numbers</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="require_symbols" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="require_symbols" class="ml-2 block text-sm text-gray-900">Require special characters</label>
                            </div>
                        </div>
                        <div>
                            <label for="min_password_length" class="block text-sm font-medium text-gray-700 mb-2">Minimum Password Length</label>
                            <input type="number" id="min_password_length" value="8" min="6" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Two-Factor Authentication</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Require 2FA for Admins</p>
                                <p class="text-xs text-gray-500">Force two-factor authentication for admin accounts</p>
                            </div>
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Save Security Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showSettingsTab(tabName) {
    // Hide all settings contents
    const contents = document.querySelectorAll('.settings-content');
    contents.forEach(content => content.classList.add('hidden'));
    
    // Remove active styling from all tabs
    const tabs = document.querySelectorAll('.settings-tab');
    tabs.forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active styling to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection