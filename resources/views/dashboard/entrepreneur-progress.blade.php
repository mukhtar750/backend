@extends('layouts.entrepreneur')
@section('title', 'My Progress')
@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">My Progress</h2>
            <p class="text-gray-500 mt-1">Track your learning journey and achievements</p>
        </div>
        <div class="mt-4 md:mt-0">
            <select class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                <option>This Month</option>
                <option>Last Month</option>
                <option>This Year</option>
            </select>
        </div>
    </div>
    <div class="rounded-3xl p-4 md:p-6 bg-gradient-to-r from-[#a259c6] via-[#b81d8f] to-[#5f4b8b] shadow-lg flex flex-col md:flex-row gap-6 md:gap-8 items-stretch">
        <div class="flex-1 flex flex-col justify-between">
            <div class="text-white text-2xl font-bold mb-1 md:mb-2">Overall Progress</div>
            <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-4">
                <div class="text-white text-sm font-medium">Program Completion</div>
                <div class="flex-1 h-3 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full" style="width: 68%"></div>
                </div>
                <div class="text-white text-lg font-bold ml-2">68%</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                <div class="bg-white/10 rounded-xl p-3 md:p-4 text-white">
                    <div class="text-sm">Modules Completed</div>
                    <div class="text-2xl font-bold">5<span class="text-base font-normal">/8</span></div>
                </div>
                <div class="bg-white/10 rounded-xl p-3 md:p-4 text-white">
                    <div class="text-sm">Current Streak</div>
                    <div class="text-2xl font-bold">12 <span class="text-base font-normal">days</span></div>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col justify-between bg-white/10 rounded-2xl p-4 md:p-6 text-white">
            <div class="mb-3 md:mb-4">
                <div class="text-lg font-semibold mb-1 md:mb-2">Next Milestone</div>
                <div class="flex items-center gap-2 mb-1">
                    <i class="bi bi-bullseye text-xl"></i>
                    <span class="font-medium">Investment Ready</span>
                </div>
                <div class="text-sm text-white/80 mb-1 md:mb-2">14 days remaining</div>
            </div>
            <div class="flex flex-col gap-1 md:gap-2 mt-auto">
                <div class="text-sm">Total Points</div>
                <div class="text-xl font-bold">1250</div>
                <div class="text-sm mt-2 md:mt-4">Current Rank</div>
                <div class="text-lg font-bold">Advanced</div>
            </div>
        </div>
    </div>
    <!-- Module Progress Section -->
    <div class="mt-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Module Progress</h3>
        <!-- Completed Module Card -->
        <div x-data="{ expanded: false, showDetails: false, showReview: false }" class="bg-[#faf7fd] border-2 border-[#b81d8f] rounded-2xl p-6 mb-6 flex flex-col md:flex-row md:items-center gap-6 shadow-sm cursor-pointer transition-all duration-200" @click="expanded = !expanded; if (!expanded) { showDetails = false; showReview = false }">
            <div class="flex-1 flex flex-col gap-2">
                <div class="flex items-center gap-3 mb-1">
                    <div class="bg-green-100 rounded-full p-2"><i class="bi bi-check-circle text-2xl text-green-500"></i></div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">Business Model Canvas</div>
                        <div class="text-sm text-gray-500">Strategy</div>
                        <div class="text-xs text-gray-400">Last accessed: 2 days ago</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-2">
                    <div class="w-40">
                        <div class="text-xs text-gray-500 mb-1">Progress</div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: 100%"></div>
                        </div>
                        <div class="text-xs text-gray-700 mt-1">100%</div>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="text-xs text-gray-500">Lessons</div>
                        <div class="text-lg font-bold">8/8</div>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="text-xs text-gray-500">Time Spent</div>
                        <div class="text-lg font-bold">12 hours</div>
                    </div>
                    <div class="flex-1 flex items-center gap-2 justify-end">
                        <i class="bi bi-award text-yellow-500"></i>
                        <div class="flex text-yellow-400 text-lg">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <span class="ml-2 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">completed</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-xs text-gray-500 mb-1">Skills Developed:</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Business Strategy</span>
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Value Proposition</span>
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Customer Segments</span>
                    </div>
                </div>
                <div x-show="expanded" class="flex gap-3 mt-6" @click.stop>
                    <button @click="showDetails = !showDetails; showReview = false" class="border border-gray-300 rounded-lg px-5 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">View Details</button>
                    <button @click="showReview = !showReview; showDetails = false" class="border border-gray-300 rounded-lg px-5 py-2 text-gray-700 font-medium hover:bg-gray-100 transition flex items-center gap-2"><i class="bi bi-arrow-repeat"></i> Review</button>
                </div>
                <div x-show="expanded && showDetails" class="mt-6 bg-white border border-gray-200 rounded-lg p-4" x-transition @click.stop>
                    <div class="font-semibold text-gray-900 mb-2">Module Details</div>
                    <p class="text-gray-600 text-sm">Here you can see a summary of your progress, lessons completed, and key takeaways for the Business Model Canvas module. (Placeholder content)</p>
                </div>
                <div x-show="expanded && showReview" class="mt-6 bg-white border border-gray-200 rounded-lg p-4" x-transition @click.stop>
                    <div class="font-semibold text-gray-900 mb-2">Module Review</div>
                    <p class="text-gray-600 text-sm">Here you can review your answers, feedback, and performance for this module. (Placeholder content)</p>
                </div>
            </div>
        </div>
        <!-- In Progress Module Card -->
        <div x-data="{ expanded: false, showDetails: false }" class="bg-[#faf7fd] border-2 border-[#b81d8f] rounded-2xl p-6 flex flex-col gap-4 mb-6 shadow-sm cursor-pointer transition-all duration-200" @click="expanded = !expanded; if (!expanded) { showDetails = false }">
            <div class="flex items-center gap-3 mb-1">
                <div class="bg-blue-100 rounded-full p-2"><i class="bi bi-play-circle text-2xl text-blue-500"></i></div>
                <div>
                    <div class="text-lg font-bold text-gray-900">Financial Planning & Modeling</div>
                    <div class="text-sm text-gray-500">Finance</div>
                    <div class="text-xs text-gray-400">Last accessed: 1 day ago</div>
                </div>
                <span class="ml-auto bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">in progress</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-4 mt-2">
                <div class="w-40">
                    <div class="text-xs text-gray-500 mb-1">Progress</div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 75%"></div>
                    </div>
                    <div class="text-xs text-gray-700 mt-1">75%</div>
                </div>
                <div class="flex-1 text-center">
                    <div class="text-xs text-gray-500">Lessons</div>
                    <div class="text-lg font-bold">7/10</div>
                </div>
                <div class="flex-1 text-center">
                    <div class="text-xs text-gray-500">Time Spent</div>
                    <div class="text-lg font-bold">18 hours</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xs text-gray-500 mb-1">Skills Developed:</div>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Financial Modeling</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Cash Flow</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Budgeting</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="bg-blue-50 border-l-4 border-blue-400 rounded p-4 text-blue-800 text-sm">
                    <span class="font-semibold">Next Action:</span> <a href="#" class="underline hover:text-blue-600">Complete Lesson 8: Investment Metrics</a>
                </div>
            </div>
            <template x-if="expanded">
                <div class="flex flex-col md:flex-row gap-3 mt-6 items-center" @click.stop>
                    <button class="flex-1 bg-[#b81d8f] text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-[#a01a7d] transition">Continue Learning</button>
                    <button @click="showDetails = !showDetails" class="border border-gray-300 rounded-lg px-5 py-3 text-gray-700 font-medium hover:bg-gray-100 transition">View Details</button>
                </div>
            </template>
            <div x-show="expanded && showDetails" class="mt-6 bg-white border border-gray-200 rounded-lg p-4" x-transition @click.stop>
                <div class="font-semibold text-gray-900 mb-2">Module Details</div>
                <p class="text-gray-600 text-sm">Here you can see a summary of your progress, lessons completed, and next steps for the Financial Planning & Modeling module. (Placeholder content)</p>
            </div>
        </div>
        <!-- Not Started Module Card -->
        <div x-data="{ expanded: false, showDetails: false }" class="bg-[#faf7fd] border-2 border-[#b81d8f] rounded-2xl p-6 flex flex-col gap-4 mb-6 shadow-sm cursor-pointer transition-all duration-200" @click="expanded = !expanded; if (!expanded) { showDetails = false }">
            <div class="flex items-center gap-3 mb-1">
                <div class="bg-gray-100 rounded-full p-2"><i class="bi bi-journal-bookmark text-2xl text-gray-400"></i></div>
                <div>
                    <div class="text-lg font-bold text-gray-900">Legal Framework & Compliance</div>
                    <div class="text-sm text-gray-500">Legal</div>
                    <div class="text-xs text-gray-400">Last accessed: Never</div>
                </div>
                <span class="ml-auto bg-gray-100 text-gray-500 text-xs font-semibold px-3 py-1 rounded-full">not started</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-center gap-4 mt-2">
                <div class="w-40">
                    <div class="text-xs text-gray-500 mb-1">Progress</div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gray-300 rounded-full" style="width: 0%"></div>
                    </div>
                    <div class="text-xs text-gray-700 mt-1">0%</div>
                </div>
                <div class="flex-1 text-center">
                    <div class="text-xs text-gray-500">Lessons</div>
                    <div class="text-lg font-bold">0/8</div>
                </div>
                <div class="flex-1 text-center">
                    <div class="text-xs text-gray-500">Time Spent</div>
                    <div class="text-lg font-bold">0 hours</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xs text-gray-500 mb-1">Skills Developed:</div>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Business Registration</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">IP Protection</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Contracts</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="bg-blue-50 border-l-4 border-blue-400 rounded p-4 text-blue-800 text-sm">
                    <span class="font-semibold">Next Action:</span> <a href="#" class="underline hover:text-blue-600">Start with Lesson 1: Business Structure</a>
                </div>
            </div>
            <template x-if="expanded">
                <div class="flex flex-col md:flex-row gap-3 mt-6 items-center" @click.stop>
                    <button class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-blue-700 transition">Start Module</button>
                    <button @click="showDetails = !showDetails" class="border border-gray-300 rounded-lg px-5 py-3 text-gray-700 font-medium hover:bg-gray-100 transition">View Details</button>
                </div>
            </template>
            <div x-show="expanded && showDetails" class="mt-6 bg-white border border-gray-200 rounded-lg p-4" x-transition @click.stop>
                <div class="font-semibold text-gray-900 mb-2">Module Details</div>
                <p class="text-gray-600 text-sm">Here you can see an overview of the Legal Framework & Compliance module, including topics to be covered and your next steps. (Placeholder content)</p>
            </div>
        </div>
    </div>
    <!-- Weekly Activity & Skills Development Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
        <!-- Weekly Activity -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="text-lg font-bold mb-4">Weekly Activity</h4>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Mon</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 60%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">2.5h</div>
                    <div class="w-16 text-xs text-gray-500">3 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+150pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Tue</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 40%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">1.8h</div>
                    <div class="w-16 text-xs text-gray-500">2 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+120pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Wed</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 80%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">3.2h</div>
                    <div class="w-16 text-xs text-gray-500">4 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+200pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Thu</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 0%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">0h</div>
                    <div class="w-16 text-xs text-gray-500">0 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+0pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Fri</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 50%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">2.1h</div>
                    <div class="w-16 text-xs text-gray-500">2 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+140pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Sat</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 90%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">4.5h</div>
                    <div class="w-16 text-xs text-gray-500">5 lessons</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+280pts</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 text-gray-700">Sun</div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-3">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 20%"></div>
                    </div>
                    <div class="w-12 text-xs text-gray-500">1.5h</div>
                    <div class="w-16 text-xs text-gray-500">1 lesson</div>
                    <div class="w-14 text-xs text-[#b81d8f] font-semibold text-right">+80pts</div>
                </div>
            </div>
        </div>
        <!-- Skills Development -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="text-lg font-bold mb-4">Skills Development</h4>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Business Strategy <span class="text-gray-400 font-normal">(Strategy)</span></span>
                        <span class="font-semibold text-gray-700">85%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Financial Planning <span class="text-gray-400 font-normal">(Finance)</span></span>
                        <span class="font-semibold text-gray-700">70%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 70%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Market Research <span class="text-gray-400 font-normal">(Research)</span></span>
                        <span class="font-semibold text-gray-700">90%</span>
                    </div>
                    <div class="h-2 bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full overflow-hidden" style="width: 90%"></div>
                    
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Pitch Presentation <span class="text-gray-400 font-normal">(Communication)</span></span>
                        <span class="font-semibold text-gray-700">60%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Legal Knowledge <span class="text-gray-400 font-normal">(Legal)</span></span>
                        <span class="font-semibold text-gray-700">15%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#b81d8f] to-[#a259c6] rounded-full" style="width: 15%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Achievements Section -->
    <div class="mt-12">
        <h4 class="text-lg font-bold mb-4">Achievements</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border rounded-xl p-4 flex flex-col items-start shadow-sm">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-trophy text-yellow-500 text-xl"></i> <span class="font-semibold text-gray-800">First Module Complete</span></div>
                <div class="text-xs text-gray-500 mb-1">Common</div>
                <div class="text-sm text-gray-700 mb-2">Completed your first training module</div>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-[#b81d8f] font-semibold text-xs">+100 pts</span>
                    <span class="text-gray-400 text-xs ml-2">2025-01-10</span>
                </div>
            </div>
            <div class="bg-green-50 border-2 border-green-400 rounded-xl p-4 flex flex-col items-start shadow-sm">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-lightning-charge text-green-500 text-xl"></i> <span class="font-semibold text-gray-800">Week Warrior</span></div>
                <div class="text-xs text-green-700 mb-1">Uncommon</div>
                <div class="text-sm text-gray-700 mb-2">Maintained a 7-day learning streak</div>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-green-700 font-semibold text-xs">+150 pts</span>
                    <span class="text-gray-400 text-xs ml-2">2025-01-15</span>
                </div>
            </div>
            <div class="bg-blue-50 border-2 border-blue-400 rounded-xl p-4 flex flex-col items-start shadow-sm">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-star text-blue-500 text-xl"></i> <span class="font-semibold text-gray-800">Perfect Score</span></div>
                <div class="text-xs text-blue-700 mb-1">Rare</div>
                <div class="text-sm text-gray-700 mb-2">Achieved 100% on a module assessment</div>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-blue-700 font-semibold text-xs">+200 pts</span>
                    <span class="text-gray-400 text-xs ml-2">2025-01-18</span>
                </div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col items-start shadow-sm opacity-60">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-journal-bookmark text-gray-400 text-xl"></i> <span class="font-semibold text-gray-400">Knowledge Seeker</span></div>
                <div class="text-xs text-gray-400 mb-1">Epic</div>
                <div class="text-sm text-gray-400 mb-2">Complete 5 modules with excellence</div>
                <div class="flex items-center gap-2 mt-auto">
                    <span class="text-gray-400 font-semibold text-xs">+300 pts</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 