@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Content Management</h1>
        <button class="bg-magenta text-white px-4 py-2 rounded-lg shadow hover:bg-magenta-700 transition flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Create New Content
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search content..." class="form-input rounded-md shadow-sm flex-grow">
            <select class="form-select rounded-md shadow-sm">
                <option>All Types</option>
                <option>Article</option>
                <option>Page</option>
                <option>News</option>
            </select>
            <select class="form-select rounded-md shadow-sm">
                <option>All Statuses</option>
                <option>Published</option>
                <option>Draft</option>
                <option>Archived</option>
            </select>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition">Filter</button>
        </div>
    </div>

    <!-- Content Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">How to Start Your Own Business</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Article</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-07-20</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-magenta-600 hover:text-magenta-900 mr-3">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">About Us Page</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Page</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-07-18</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-magenta-600 hover:text-magenta-900 mr-3">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Latest News: Innovation Summit</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">News</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-07-15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-magenta-600 hover:text-magenta-900 mr-3">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection