@extends('layouts.bdsp')
@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-900">Reports & Analytics</h2>
        <div class="flex gap-2">
            <input type="date" class="border rounded-lg px-3 py-2 text-sm" placeholder="Start date">
            <input type="date" class="border rounded-lg px-3 py-2 text-sm" placeholder="End date">
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i class="bi bi-download"></i> Export PDF</button>
        </div>
    </div>
    <!-- Overview Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-purple-600">12</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-people"></i> Total Mentees</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-blue-500">28</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-calendar-event"></i> Sessions</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-green-500">4.7</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-star"></i> Avg. Rating</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-orange-500">9</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-upload"></i> Resources Shared</div>
        </div>
    </div>
    <!-- Session Analytics (Placeholder Chart) -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Sessions Over Time</h3>
        <div class="h-40 flex items-center justify-center text-gray-400">[Chart Placeholder]</div>
    </div>
    <!-- Mentee Progress Table -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Mentee Progress</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left font-semibold">Name</th>
                        <th class="px-4 py-2 text-left font-semibold">Company</th>
                        <th class="px-4 py-2 text-left font-semibold">Progress</th>
                        <th class="px-4 py-2 text-left font-semibold">Last Session</th>
                        <th class="px-4 py-2 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 font-medium">Sarah Johnson</td>
                        <td class="px-4 py-2">EcoTech Solutions</td>
                        <td class="px-4 py-2"><div class="w-32 h-2 bg-gray-200 rounded-full"><div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" style="width: 85%"></div></div> <span class="ml-2">85%</span></td>
                        <td class="px-4 py-2">2 days ago</td>
                        <td class="px-4 py-2"><span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">on track</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-medium">Michael Chen</td>
                        <td class="px-4 py-2">FinanceFlow</td>
                        <td class="px-4 py-2"><div class="w-32 h-2 bg-gray-200 rounded-full"><div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" style="width: 70%"></div></div> <span class="ml-2">70%</span></td>
                        <td class="px-4 py-2">1 week ago</td>
                        <td class="px-4 py-2"><span class="bg-orange-100 text-orange-600 px-2 py-1 rounded-full text-xs">needs attention</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-medium">Aisha Patel</td>
                        <td class="px-4 py-2">HealthTech Hub</td>
                        <td class="px-4 py-2"><div class="w-32 h-2 bg-gray-200 rounded-full"><div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" style="width: 95%"></div></div> <span class="ml-2">95%</span></td>
                        <td class="px-4 py-2">1 day ago</td>
                        <td class="px-4 py-2"><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">excellent</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Feedback & Ratings -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Feedback & Ratings</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 border">
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-semibold text-gray-900">Aisha Patel</span>
                    <span class="flex items-center text-yellow-400 text-sm">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </span>
                    <span class="text-xs text-gray-500">5/5</span>
                </div>
                <div class="italic text-gray-700 text-sm mb-1">"Excellent guidance on business model canvas. Very insightful session!"</div>
                <div class="text-xs text-gray-400">1 day ago</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border">
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-semibold text-gray-900">David Wilson</span>
                    <span class="flex items-center text-yellow-400 text-sm">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </span>
                    <span class="text-xs text-gray-500">4/5</span>
                </div>
                <div class="italic text-gray-700 text-sm mb-1">"Very helpful session on market research methodologies."</div>
                <div class="text-xs text-gray-400">3 days ago</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border">
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-semibold text-gray-900">Sarah Johnson</span>
                    <span class="flex items-center text-yellow-400 text-sm">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </span>
                    <span class="text-xs text-gray-500">5/5</span>
                </div>
                <div class="italic text-gray-700 text-sm mb-1">"Clear explanations on financial projections. Thank you!"</div>
                <div class="text-xs text-gray-400">1 week ago</div>
            </div>
        </div>
    </div>
    <!-- Resource Engagement -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Resource Engagement</h3>
        <ul class="list-disc pl-6 text-gray-700">
            <li>Business Model Canvas.pdf <span class="text-xs text-gray-400 ml-2">12 downloads</span></li>
            <li>Financial Planning Guide.docx <span class="text-xs text-gray-400 ml-2">8 downloads</span></li>
            <li>Pitch Deck Template.pptx <span class="text-xs text-gray-400 ml-2">15 downloads</span></li>
        </ul>
    </div>
</div>
@endsection 