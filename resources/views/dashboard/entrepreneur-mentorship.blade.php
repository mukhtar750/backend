@extends('layouts.entrepreneur')
@section('title', 'Mentorship')
@section('content')
<div x-data="{ showBooking: false }" class="max-w-5xl mx-auto mt-10">
    <!-- Header and Book New Session Button -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-bold text-gray-900">Mentorship</div>
        <button @click="showBooking = true" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Book New Session</button>
    </div>
    <!-- Mentor Directory -->
    <div class="mb-10">
        <h4 class="text-lg font-bold mb-4">Available Mentors</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="h-16 w-16 rounded-full object-cover mb-2" alt="Mentor">
                <div class="font-semibold text-gray-900">Dr. Kemi Adebayo</div>
                <div class="text-xs text-gray-500 mb-1">Business Strategy</div>
                <div class="text-xs text-gray-400 mb-2">4.9 <i class="bi bi-star-fill text-yellow-400"></i></div>
                <button @click="showBooking = true" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Book</button>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-16 w-16 rounded-full object-cover mb-2" alt="Mentor">
                <div class="font-semibold text-gray-900">Grace Mwangi</div>
                <div class="text-xs text-gray-500 mb-1">Finance</div>
                <div class="text-xs text-gray-400 mb-2">4.8 <i class="bi bi-star-fill text-yellow-400"></i></div>
                <button @click="showBooking = true" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Book</button>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center">
                <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-16 w-16 rounded-full object-cover mb-2" alt="Mentor">
                <div class="font-semibold text-gray-900">Fatima Al-Rashid</div>
                <div class="text-xs text-gray-500 mb-1">Marketing</div>
                <div class="text-xs text-gray-400 mb-2">4.7 <i class="bi bi-star-fill text-yellow-400"></i></div>
                <button @click="showBooking = true" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Book</button>
            </div>
        </div>
    </div>
    <!-- Stats, Tabs, and Session Cards -->
    @include('dashboard.partials.entrepreneur.mentorship-sessions')
    <!-- Booking Modal -->
    <div x-show="showBooking" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" style="display: none;" @keydown.escape.window="showBooking = false">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto p-6 relative animate-fade-in">
            <button @click="showBooking = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h3 class="text-2xl font-bold mb-4">Book New Mentorship Session</h3>
            <form @submit.prevent="showBooking = false">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Select Mentor</label>
                    <select class="w-full border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]">
                        <option>Dr. Kemi Adebayo (Business Strategy)</option>
                        <option>Grace Mwangi (Finance)</option>
                        <option>Fatima Al-Rashid (Marketing)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Session Topic</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]" placeholder="e.g. Business Model Validation">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Date & Time</label>
                    <input type="datetime-local" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Session Type</label>
                    <select class="w-full border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]">
                        <option>Video Call</option>
                        <option>Phone Call</option>
                        <option>In Person</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showBooking = false" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-[#b81d8f] text-white font-semibold hover:bg-[#a01a7d] transition">Book Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 