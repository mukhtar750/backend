@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Content Management</h1>
    </div>

    <!-- Tabs (Alpine.js) -->
    <div x-data="{
        tab: 'alpha',
        showUpload: false,
        alphaTypeTab: 'all',
        uploadForm: {
            title: '',
            type: 'document',
            category_id: '',
            visibility: 'public',
            description: '',
            tags: '',
            file: null,
            status: 'published',
        },
        uploadLoading: false,
        uploadError: '',
        uploadSuccess: '',
        resetUploadForm() {
            this.uploadForm = { title: '', type: 'document', category_id: '', visibility: 'public', description: '', tags: '', file: null, status: 'published' };
            this.uploadError = '';
            this.uploadSuccess = '';
        },
        async submitUpload() {
            this.uploadLoading = true;
            this.uploadError = '';
            this.uploadSuccess = '';
            try {
                let formData = new FormData();
                formData.append('title', this.uploadForm.title);
                formData.append('type', this.uploadForm.type);
                formData.append('category_id', this.uploadForm.category_id);
                formData.append('visibility', this.uploadForm.visibility);
                formData.append('description', this.uploadForm.description);
                formData.append('tags', this.uploadForm.tags);
                formData.append('status', this.uploadForm.status);
                if (this.uploadForm.file) formData.append('file', this.uploadForm.file);
                const response = await fetch('{{ route('admin.contents.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    this.uploadSuccess = 'Content uploaded successfully!';
                    setTimeout(() => { this.showUpload = false; this.resetUploadForm(); }, 1200);
                } else {
                    this.uploadError = 'Upload failed.';
                }
            } catch (e) {
                this.uploadError = 'Upload failed.';
            } finally {
                this.uploadLoading = false;
            }
        },
        showEdit: false,
        editForm: {
            id: null,
            title: '',
            type: 'document',
            category_id: '',
            visibility: 'public',
            description: '',
            tags: '',
            status: 'published',
            file: null
        },
        editLoading: false,
        editError: '',
        editSuccess: '',
        openEditContent(id) {
            fetch(`/admin/contents/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    Object.assign(this.editForm, data.content);
                    this.editForm.id = id;
                    this.editForm.file = null;
                    this.showEdit = true;
                });
        },
        async submitEdit() {
            this.editLoading = true;
            this.editError = '';
            this.editSuccess = '';
            try {
                let formData = new FormData();
                formData.append('title', this.editForm.title);
                formData.append('type', this.editForm.type);
                formData.append('category_id', this.editForm.category_id);
                formData.append('visibility', this.editForm.visibility);
                formData.append('description', this.editForm.description);
                formData.append('tags', this.editForm.tags);
                formData.append('status', this.editForm.status);
                if (this.editForm.file) formData.append('file', this.editForm.file);
                const response = await fetch(`/admin/contents/${this.editForm.id}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    this.editSuccess = 'Content updated successfully!';
                    setTimeout(() => { this.showEdit = false; window.location.reload(); }, 1200);
                } else {
                    this.editError = 'Update failed.';
                }
            } catch (e) {
                this.editError = 'Update failed.';
            } finally {
                this.editLoading = false;
            }
        },
        deleteContent(id) {
            if (!confirm('Are you sure you want to delete this content?')) return;
            fetch(`/admin/contents/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Delete failed.');
                }
            })
            .catch(() => alert('Delete failed.'));
        }
    }" class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button type="button" @click="tab = 'alpha'" :class="tab === 'alpha' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Alpha</button>
            <button type="button" @click="tab = 'resources'" :class="tab === 'resources' ? 'border-b-2 border-purple-600 text-purple-700' : 'text-gray-500 hover:text-purple-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Learning Resources</button>
            <button type="button" @click="tab = 'ideas-bank'" :class="tab === 'ideas-bank' ? 'border-b-2 border-purple-600 text-purple-700' : 'text-gray-500 hover:text-purple-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Ideas Bank</button>
            <button type="button" @click="tab = 'practice-pitches'" :class="tab === 'practice-pitches' ? 'border-b-2 border-blue-600 text-blue-700' : 'text-gray-500 hover:text-blue-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Practice Pitches</button>
        </nav>

        <!-- Alpha Tab -->
        <div x-show="tab === 'alpha'" class="pt-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-6 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Total Content</span>
                    <span class="text-2xl font-bold text-purple-700 mt-2">5</span>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Published</span>
                    <span class="text-2xl font-bold text-green-600 mt-2">4</span>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Drafts</span>
                    <span class="text-2xl font-bold text-yellow-500 mt-2">1</span>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Total Views</span>
                    <span class="text-2xl font-bold text-blue-600 mt-2">11,200</span>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Downloads</span>
                    <span class="text-2xl font-bold text-purple-500 mt-2">4,240</span>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                    <span class="text-lg font-semibold text-gray-700">Avg. Rating</span>
                    <span class="text-2xl font-bold text-orange-500 mt-2">3.8</span>
                </div>
            </div>
            <!-- Controls -->
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <div class="flex items-center gap-2 flex-1">
                    <input type="text" placeholder="Search content..." class="form-input rounded-md shadow-sm flex-grow max-w-xs">
                    <select class="form-select rounded-md shadow-sm">
                        <option>All Categories</option>
                        <option>Business Strategy</option>
                        <option>Finance</option>
                        <option>Pitch Deck</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="showUpload = true" class="bg-pink-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-pink-700 transition">+ Upload Content</button>
                    <button class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Grid</button>
                    <button class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">List</button>
                    <button class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Export</button>
                </div>
            </div>
            <!-- Upload Modal -->
            <div x-show="showUpload" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div @click.away="showUpload = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-8 relative">
                    <h2 class="text-2xl font-bold mb-6">Upload New Content</h2>
                    <form @submit.prevent="submitUpload">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Content Title</label>
                                <input type="text" class="form-input w-full rounded-md" placeholder="Enter content title" x-model="uploadForm.title" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Content Type</label>
                                <select class="form-select w-full rounded-md" x-model="uploadForm.type">
                                    <option value="document">Document</option>
                                    <option value="video">Video</option>
                                    <option value="image">Image</option>
                                    <option value="template">Template</option>
                                    <option value="article">Article</option>
                                    <option value="announcement">Announcement</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Category</label>
                                <select class="form-select w-full rounded-md" x-model="uploadForm.category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Visibility</label>
                                <select class="form-select w-full rounded-md" x-model="uploadForm.visibility">
                                    <option value="public">Public</option>
                                    <option value="entrepreneurs">Entrepreneurs Only</option>
                                    <option value="mentors">Mentors Only</option>
                                    <option value="investors">Investors Only</option>
                                    <option value="admin">Admin Only</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1">Description</label>
                            <textarea class="form-input w-full rounded-md" rows="3" placeholder="Describe the content and its purpose" x-model="uploadForm.description"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1">Tags (comma separated)</label>
                            <input type="text" class="form-input w-full rounded-md" placeholder="e.g., business, strategy, template" x-model="uploadForm.tags">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-1">Upload File</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m5 4v8m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                <span class="text-gray-500 text-sm mb-2">Drag and drop your file here, or click to browse</span>
                                <input type="file" class="hidden" x-ref="fileInput" @change="uploadForm.file = $event.target.files[0]">
                                <button type="button" class="mt-2 bg-pink-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-pink-700 transition" @click="$refs.fileInput.click()">Choose File</button>
                                <span x-text="uploadForm.file ? uploadForm.file.name : ''" class="block text-xs text-gray-500 mt-1"></span>
                                <span class="block text-xs text-gray-400 mt-2">Supports PDF, DOC, MP4, JPG, PNG (Max 100MB)</span>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 mb-2">
                            <button type="button" @click="showUpload = false; resetUploadForm();" class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
                            <button type="button" @click="uploadForm.status = 'draft'; submitUpload();" :disabled="uploadLoading" class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Save as Draft</button>
                            <button type="button" @click="uploadForm.status = 'published'; submitUpload();" :disabled="uploadLoading" class="px-4 py-2 rounded-lg font-semibold bg-pink-600 text-white hover:bg-pink-700">Publish</button>
                        </div>
                        <template x-if="uploadLoading">
                            <div class="text-center text-sm text-gray-500">Uploading...</div>
                        </template>
                        <template x-if="uploadError">
                            <div class="text-center text-sm text-red-600" x-text="uploadError"></div>
                        </template>
                        <template x-if="uploadSuccess">
                            <div class="text-center text-sm text-green-600" x-text="uploadSuccess"></div>
                        </template>
                    </form>
                </div>
            </div>
            <!-- End Upload Modal -->
            <!-- Tabs for Content Types -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-8" aria-label="Content Types">
                    <button @click="alphaTypeTab = 'all'" :class="alphaTypeTab === 'all' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">All ({{ $contents->count() }})</button>
                    <button @click="alphaTypeTab = 'document'" :class="alphaTypeTab === 'document' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Documents ({{ $contents->where('type', 'document')->count() }})</button>
                    <button @click="alphaTypeTab = 'video'" :class="alphaTypeTab === 'video' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Videos ({{ $contents->where('type', 'video')->count() }})</button>
                    <button @click="alphaTypeTab = 'image'" :class="alphaTypeTab === 'image' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Images ({{ $contents->where('type', 'image')->count() }})</button>
                    <button @click="alphaTypeTab = 'template'" :class="alphaTypeTab === 'template' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Templates ({{ $contents->where('type', 'template')->count() }})</button>
                    <button @click="alphaTypeTab = 'announcement'" :class="alphaTypeTab === 'announcement' ? 'border-b-2 border-pink-600 text-pink-700' : 'text-gray-500 hover:text-pink-700'" class="px-4 py-2 text-sm font-medium focus:outline-none">Announcements ({{ $contents->where('type', 'announcement')->count() }})</button>
                </nav>
            </div>
            <!-- Content Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($contents as $content)
                    <div x-show="alphaTypeTab === 'all' || alphaTypeTab === '{{ $content->type }}'" class="bg-white rounded-xl shadow p-4 flex flex-col">
                        <div class="flex items-center gap-2 mb-2">
                            @if($content->is_featured)
                                <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Featured</span>
                            @endif
                            @if($content->status === 'published')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">published</span>
                            @elseif($content->status === 'draft')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">draft</span>
                            @elseif($content->status === 'pending')
                                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">pending</span>
                            @elseif($content->status === 'rejected')
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">rejected</span>
                            @endif
                        </div>
                        @if($content->file_path && Str::startsWith($content->file_type, 'image'))
                            <img src="{{ asset('storage/' . $content->file_path) }}" alt="{{ $content->title }}" class="rounded-lg mb-3 h-32 object-cover">
                        @else
                            <div class="rounded-lg mb-3 h-32 bg-gray-100 flex items-center justify-center text-gray-400">
                                <i class="bi bi-file-earmark-text" style="font-size:2rem;"></i>
                            </div>
                        @endif
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded mb-2 self-start">{{ $content->type }}</span>
                        <h3 class="font-bold text-lg mb-1">{{ $content->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($content->description, 80) }}</p>
                        <div class="flex items-center gap-2 mb-2">
                            @if($content->user && $content->user->name)
                                <img src="{{ asset('images/default-avatar.png') }}" onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';" class="h-6 w-6 rounded-full" alt="{{ $content->user->name }}">
                                <span class="text-xs text-gray-700">{{ $content->user->name }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach(explode(',', $content->tags ?? '') as $tag)
                                @if(trim($tag))
                                    <span class="bg-purple-50 text-purple-700 text-xs font-semibold px-2 py-1 rounded">{{ trim($tag) }}</span>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                            <span><i class="bi bi-eye"></i> {{ $content->views }}</span>
                            <span><i class="bi bi-download"></i> {{ $content->downloads }}</span>
                            <span><i class="bi bi-star-fill text-yellow-400"></i> {{ $content->rating }}</span>
                            <span><i class="bi bi-chat"></i> {{ $content->comments_count }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <span>{{ $content->created_at->format('Y-m-d') }}</span>
                            <i class="bi bi-pencil-square cursor-pointer text-blue-600 hover:text-blue-800"
                               @click="openEditContent({{ $content->id }})"></i>
                            <i class="bi bi-eye cursor-pointer"></i>
                            <i class="bi bi-trash cursor-pointer text-red-600 hover:text-red-800"
                               @click="deleteContent({{ $content->id }})"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-400 py-12">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <div class="mt-2">No content uploaded yet.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Ideas Bank Tab -->
        <div x-show="tab === 'ideas-bank'" class="pt-8">
            @include('admin.ideas_bank')
        </div>

        <!-- Learning Resources Tab -->
        <div x-show="tab === 'resources'" class="pt-8">
            <!-- Filter by Status -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form method="GET" class="flex items-center space-x-4">
                    <select name="status" onchange="this.form.submit()" class="form-select rounded-md shadow-sm">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>All Statuses</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                    <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition">Filter</button>
                </form>
            </div>

            <!-- Resources Table -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploader</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($resources as $resource)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $resource->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($resource->description, 60) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resource->bdsp ? $resource->bdsp->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $resource->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($resource->is_approved)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        @if(!$resource->is_approved)
                                            <form action="{{ route('admin.resources.approve', $resource->id) }}" method="POST" onsubmit="return confirm('Approve this resource?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.resources.reject', $resource->id) }}" method="POST" onsubmit="return confirm('Reject this resource?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">Reject</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Delete this resource?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                        <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No resources found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $resources->links() }}</div>
                </div>
            </div>
        </div>

        <!-- Practice Pitches Tab -->
        <div x-show="tab === 'practice-pitches'" class="pt-8" x-data="{ pitchTab: 'pending' }">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold mb-6">Practice Pitch Submissions</h2>
                <div class="mb-6 flex gap-4 border-b pb-2">
                    <button @click="pitchTab = 'pending'" :class="pitchTab === 'pending' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Pending</button>
                    <button @click="pitchTab = 'approved'" :class="pitchTab === 'approved' ? 'border-b-2 border-green-600 text-green-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Approved</button>
                    <button @click="pitchTab = 'rejected'" :class="pitchTab === 'rejected' ? 'border-b-2 border-red-600 text-red-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Rejected</button>
                    <button @click="pitchTab = 'reviewed'" :class="pitchTab === 'reviewed' ? 'border-b-2 border-blue-600 text-blue-700' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Reviewed</button>
                </div>
                
                <!-- Pending Pitches -->
                <div x-show="pitchTab === 'pending'">
                    @php $pendingPitches = \App\Models\PracticePitch::with('user')->where('status', 'pending')->orderByDesc('created_at')->get(); @endphp
                    @include('admin.practice-pitches.partials.table', ['pitches' => $pendingPitches, 'status' => 'pending'])
                </div>
                
                <!-- Approved Pitches -->
                <div x-show="pitchTab === 'approved'">
                    @php $approvedPitches = \App\Models\PracticePitch::with('user')->where('status', 'approved')->orderByDesc('created_at')->get(); @endphp
                    @include('admin.practice-pitches.partials.table', ['pitches' => $approvedPitches, 'status' => 'approved'])
                </div>
                
                <!-- Rejected Pitches -->
                <div x-show="pitchTab === 'rejected'">
                    @php $rejectedPitches = \App\Models\PracticePitch::with('user')->where('status', 'rejected')->orderByDesc('created_at')->get(); @endphp
                    @include('admin.practice-pitches.partials.table', ['pitches' => $rejectedPitches, 'status' => 'rejected'])
                </div>
                
                <!-- Reviewed Pitches -->
                <div x-show="pitchTab === 'reviewed'">
                    @php $reviewedPitches = \App\Models\PracticePitch::with('user')->where('status', 'reviewed')->orderByDesc('created_at')->get(); @endphp
                    @include('admin.practice-pitches.partials.table', ['pitches' => $reviewedPitches, 'status' => 'reviewed'])
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Content Modal -->
    <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div @click.away="showEdit = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-8 relative">
            <h2 class="text-2xl font-bold mb-6">Edit Content</h2>
            <form @submit.prevent="submitEdit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Content Title</label>
                        <input type="text" class="form-input w-full rounded-md" x-model="editForm.title" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Content Type</label>
                        <select class="form-select w-full rounded-md" x-model="editForm.type">
                            <option value="document">Document</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                            <option value="template">Template</option>
                            <option value="article">Article</option>
                            <option value="announcement">Announcement</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Category</label>
                        <select class="form-select w-full rounded-md" x-model="editForm.category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Visibility</label>
                        <select class="form-select w-full rounded-md" x-model="editForm.visibility">
                            <option value="public">Public</option>
                            <option value="entrepreneurs">Entrepreneurs Only</option>
                            <option value="mentors">Mentors Only</option>
                            <option value="investors">Investors Only</option>
                            <option value="admin">Admin Only</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Description</label>
                    <textarea class="form-input w-full rounded-md" rows="3" x-model="editForm.description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Tags (comma separated)</label>
                    <input type="text" class="form-input w-full rounded-md" x-model="editForm.tags">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1">Replace File (optional)</label>
                    <input type="file" class="form-input w-full rounded-md" @change="editForm.file = $event.target.files[0]">
                </div>
                <div class="flex justify-end gap-2 mb-2">
                    <button type="button" @click="showEdit = false" class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button type="submit" :disabled="editLoading" class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700">Update</button>
                </div>
                <template x-if="editLoading">
                    <div class="text-center text-sm text-gray-500">Updating...</div>
                </template>
                <template x-if="editError">
                    <div class="text-center text-sm text-red-600" x-text="editError"></div>
                </template>
                <template x-if="editSuccess">
                    <div class="text-center text-sm text-green-600" x-text="editSuccess"></div>
                </template>
            </form>
        </div>
    </div>
@endsection