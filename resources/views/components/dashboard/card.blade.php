<div class="bg-white p-6 rounded-lg shadow flex items-center">
    <div class="bg-{{ $color }}-100 text-{{ $color }}-700 p-3 rounded-full mr-4"><i class="bi bi-{{ $icon }} text-2xl"></i></div>
    <div>
        <div class="text-2xl font-bold">{{ $value }}</div>
        <div class="text-gray-500">{{ $label }}</div>
        @if(isset($change))
            <div class="text-green-600 text-xs mt-1">{{ $change }}</div>
        @endif
    </div>
</div>