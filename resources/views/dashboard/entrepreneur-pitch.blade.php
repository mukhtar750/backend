@extends('layouts.entrepreneur')
@section('title', 'Pitch Preparation')
@section('content')
<div class="max-w-5xl mx-auto mt-10 space-y-12">
    <!-- Header -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Pitch Preparation</h2>
        <p class="text-gray-500 mt-1">Access resources, practice your pitch, and explore the Idea Bank to find or share innovative business ideas.</p>
    </div>
    <!-- Learning Resources (same as dashboard) -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Learning Resources</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-book text-[#b81d8f] text-xl"></i> <span class="font-semibold">Article: Crafting a Winning Pitch</span></div>
                <div class="text-sm text-gray-500 mb-4">Step-by-step guide to creating a compelling business pitch for investors.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Read Article</a>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-youtube text-[#b81d8f] text-xl"></i> <span class="font-semibold">Video: Pitching Do’s & Don’ts</span></div>
                <div class="text-sm text-gray-500 mb-4">Watch this video to learn the best practices and common mistakes in pitching.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Watch Video</a>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-file-earmark-pdf text-[#b81d8f] text-xl"></i> <span class="font-semibold">Guide: Investor Pitch Checklist</span></div>
                <div class="text-sm text-gray-500 mb-4">Download a checklist to ensure your pitch covers all the essentials.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Download Guide</a>
            </div>
        </div>
    </div>
    <!-- Pitching Resources -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Pitching Resources</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-file-earmark-text text-[#b81d8f] text-xl"></i> <span class="font-semibold">Pitch Deck Template</span></div>
                <div class="text-sm text-gray-500 mb-4">Download a proven template to structure your pitch deck for investors.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Download</a>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-play-circle text-[#b81d8f] text-xl"></i> <span class="font-semibold">Pitching Masterclass</span></div>
                <div class="text-sm text-gray-500 mb-4">Watch a video masterclass on storytelling and effective pitching.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Watch Video</a>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-question-circle text-[#b81d8f] text-xl"></i> <span class="font-semibold">Investor Q&A Guide</span></div>
                <div class="text-sm text-gray-500 mb-4">Prepare for tough questions with this guide to common investor Q&A.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">View Guide</a>
            </div>
        </div>
    </div>
    <!-- Practice Your Pitch -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Practice Your Pitch</h3>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center gap-6">
            <div class="flex-1">
                <div class="text-gray-700 mb-2">Record a practice pitch or submit your pitch deck for feedback from mentors or peers.</div>
                <div class="flex gap-3 mb-2">
                    <button class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Record Pitch</button>
                    <button class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Request Feedback</button>
                </div>
                <div class="text-xs text-gray-400">You can view your previous practice pitches and feedback below.</div>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold mb-2">Previous Practice Pitches</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-700"><i class="bi bi-mic text-[#b81d8f]"></i> Pitch 1 - Feedback Pending</li>
                    <li class="flex items-center gap-2 text-sm text-gray-700"><i class="bi bi-mic text-[#b81d8f]"></i> Pitch 2 - Reviewed</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Idea Bank -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Idea Bank</h3>
        <div class="mb-4 flex flex-col md:flex-row md:items-center gap-4">
            <form class="flex-1 flex gap-2">
                <input type="text" class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]" placeholder="Share a new idea...">
                <button type="submit" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Submit Idea</button>
            </form>
            <div class="flex gap-2">
                <select class="border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]">
                    <option>All Categories</option>
                    <option>Fintech</option>
                    <option>Health</option>
                    <option>Education</option>
                </select>
                <input type="text" class="border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]" placeholder="Search ideas...">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-lightbulb text-yellow-400 text-xl"></i> <span class="font-semibold">Smart Health Tracker</span></div>
                <div class="text-sm text-gray-500 mb-2">A wearable device that tracks health metrics and provides real-time feedback to users and doctors.</div>
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Health</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Wearables</span>
                </div>
                <div class="flex gap-2 mt-auto">
                    <button class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Pitch This Idea</button>
                    <button class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">Like</button>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2"><i class="bi bi-lightbulb text-yellow-400 text-xl"></i> <span class="font-semibold">EduConnect Platform</span></div>
                <div class="text-sm text-gray-500 mb-2">A platform connecting students with mentors and learning resources globally.</div>
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Education</span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Platform</span>
                </div>
                <div class="flex gap-2 mt-auto">
                    <button class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Pitch This Idea</button>
                    <button class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">Like</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Recommendations -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Recommended for You</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="font-semibold mb-2">Upcoming Pitch Event: Women in Tech</div>
                <div class="text-sm text-gray-500 mb-4">Join the next pitch event focused on women-led startups in technology. Register now to secure your spot!</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Register</a>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="font-semibold mb-2">Mentor Recommendation: Grace Mwangi</div>
                <div class="text-sm text-gray-500 mb-4">Based on your interests in finance, we recommend connecting with Grace for pitch feedback.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Connect</a>
            </div>
        </div>
    </div>
</div>
@endsection 