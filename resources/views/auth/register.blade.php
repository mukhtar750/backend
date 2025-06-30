@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Register for an account
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register.role') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Name" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div class="mt-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">I am a:</label>
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="entrepreneur">Entrepreneur</option>
                        <option value="bdsp">BDSP</option>
                        <option value="investor">Investor</option>
                    </select>
                </div>

                <div id="entrepreneur-fields" class="role-fields mt-4 hidden">
                    <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" name="business_name" id="business_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <!-- Other entrepreneur-specific fields -->
                </div>

                <div id="bdsp-fields" class="role-fields mt-4 hidden">
                    <label for="service_offering" class="block text-sm font-medium text-gray-700">Service Offering</label>
                    <input type="text" name="service_offering" id="service_offering" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <!-- Other BDSP-specific fields -->
                </div>

                <div id="investor-fields" class="role-fields mt-4 hidden">
                    <label for="investment_focus" class="block text-sm font-medium text-gray-700">Investment Focus</label>
                    <input type="text" name="investment_focus" id="investment_focus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <!-- Other investor-specific fields -->
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Password">
                </div>
                <div>
                    <label for="password-confirm" class="sr-only">Confirm Password</label>
                    <input id="password-confirm" name="password_confirmation" type="password" autocomplete="new-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Confirm Password">
                </div>
            </div>

            @if ($errors->any())
                <div class="text-red-500 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>
        <div class="text-center text-sm text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const roleFields = document.querySelectorAll('.role-fields');

        function toggleRoleFields() {
            const selectedRole = roleSelect.value;
            roleFields.forEach(function (fieldDiv) {
                if (fieldDiv.id === selectedRole + '-fields') {
                    fieldDiv.classList.remove('hidden');
                } else {
                    fieldDiv.classList.add('hidden');
                }
            });
        }

        // Initial call to set visibility based on default selection
        toggleRoleFields();

        // Listen for changes to the role dropdown
        roleSelect.addEventListener('change', toggleRoleFields);
    });
</script>
@endsection