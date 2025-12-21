
@php
    $breadcrumbs = [
        'Pengaturan' => null,
        'Website' => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Pengaturan Website</x-slot>

    <div class="py-12" x-data="{ activeTab: 'general' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-md shadow-sm border border-green-100 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">

                    {{-- Tabs Navigation --}}
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'general'" 
                                :class="activeTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Identitas Website
                            </button>
                            <button @click="activeTab = 'hero'" 
                                :class="activeTab === 'hero' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Hero Section
                            </button>
                            <button @click="activeTab = 'about'" 
                                :class="activeTab === 'about' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Tentang Kami
                            </button>
                            <button @click="activeTab = 'features'" 
                                :class="activeTab === 'features' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Fitur / Keunggulan
                            </button>
                            <button @click="activeTab = 'faq'" 
                                :class="activeTab === 'faq' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                FAQ
                            </button>
                            <button @click="activeTab = 'contact'" 
                                :class="activeTab === 'contact' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Kontak & Footer
                            </button>
                        </nav>
                    </div>

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Tab: General / Identity --}}
                        <div x-show="activeTab === 'general'" class="space-y-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Identitas Website</h3>
                            
                            @foreach($settings['general'] ?? [] as $setting)
                                <div>
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['site_', '_'], ['',' '], $setting->key))" />
                                    
                                    @if($setting->type === 'image')
                                        <div class="mt-2" x-data="{ preview: '{{ $setting->value ? (str_contains($setting->value, 'http') ? $setting->value : asset('storage/' . $setting->value)) : '' }}' }">
                                            <input type="file" id="{{ $setting->key }}" name="{{ $setting->key }}" 
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                                @change="preview = URL.createObjectURL($event.target.files[0])">
                                            
                                            <div class="mt-2 text-xs text-gray-500">Logo saat ini:</div>
                                            {{-- Show Preview or Default --}}
                                            <div class="mt-2 relative inline-block p-2 bg-gray-100 rounded border border-gray-200">
                                                <img :src="preview ? preview : '{{ asset('img/image.png') }}'" class="h-20 w-auto object-contain">
                                            </div>

                                            @if($setting->value)
                                                <div class="mt-2 flex items-center">
                                                    <input type="checkbox" id="delete_{{ $setting->key }}" name="delete_buttons[]" value="{{ $setting->key }}" 
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    <label for="delete_{{ $setting->key }}" class="ml-2 text-sm text-red-600 font-medium">Hapus Logo & Gunakan Default</label>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full" :value="old($setting->key, $setting->value)" />
                                    @endif

                                    @if($setting->hint)
                                        <p class="mt-1 text-sm text-gray-500">{{ $setting->hint }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Tab: Hero --}}
                        <div x-show="activeTab === 'hero'" class="space-y-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Hero Section (Halaman Depan)</h3>
                            
                            @foreach($settings['hero'] ?? [] as $setting)
                                <div>
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['hero_', '_'], ['',' '], $setting->key))" />
                                    
                                    @if($setting->type === 'textarea')
                                        <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3" 
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                    @elseif($setting->type === 'image')
                                        <div class="mt-2" x-data="{ preview: '{{ $setting->value ? (str_contains($setting->value, 'http') ? $setting->value : asset('storage/' . $setting->value)) : '' }}' }">
                                            <input type="file" id="{{ $setting->key }}" name="{{ $setting->key }}" 
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                                                @change="preview = URL.createObjectURL($event.target.files[0])">
                                            
                                            <div x-show="preview" class="mt-2 relative inline-block">
                                                <img :src="preview" class="h-40 w-auto rounded-lg shadow-sm object-cover border border-gray-200">
                                            </div>

                                            @if($setting->value && !str_contains($setting->value, 'http'))
                                                <div class="mt-2 flex items-center">
                                                    <input type="checkbox" id="delete_{{ $setting->key }}" name="delete_buttons[]" value="{{ $setting->key }}" 
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    <label for="delete_{{ $setting->key }}" class="ml-2 text-sm text-red-600 font-medium">Hapus & Reset ke Default</label>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full" :value="old($setting->key, $setting->value)" />
                                    @endif

                                    @if($setting->hint)
                                        <p class="mt-1 text-sm text-gray-500">{{ $setting->hint }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Tab: Features (New) --}}
                        <div x-show="activeTab === 'features'" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Fitur / Keunggulan (Card)</h3>
                            <p class="text-sm text-gray-500 mb-4">Mengatur teks pada 3 kartu keunggulan di halaman depan (Tentang Kami).</p>
                            
                            @foreach($settings['features'] ?? [] as $setting)
                                <div>
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['feature_', '_'], ['Fitur ',' '], $setting->key))" />
                                    
                                    @if($setting->type === 'textarea')
                                        <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3" 
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                    @else
                                        <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full" :value="old($setting->key, $setting->value)" />
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Tab: FAQ (New) --}}
                        <div x-show="activeTab === 'faq'" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Pertanyaan Umum (FAQ)</h3>
                            <p class="text-sm text-gray-500 mb-4">Mengatur daftar pertanyaan dan jawaban yang sering ditanyakan.</p>
                            
                            @foreach($settings['faq'] ?? [] as $setting)
                                <div class="border-b border-gray-100 pb-6 mb-6 last:border-0 last:mb-0 last:pb-0">
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['faq_', '_'], ['',' '], $setting->key == 'faq_data' ? 'Daftar Pertanyaan (FAQ)' : $setting->key))" />
                                    
                                    @if($setting->type === 'json_list')
                                        <div x-data="{ items: {{ $setting->value ? $setting->value : '[]' }} }">
                                            {{-- Hidden Input for Form Submission --}}
                                            <textarea name="{{ $setting->key }}" class="hidden" :value="JSON.stringify(items)"></textarea>

                                            {{-- List Items --}}
                                            <div class="space-y-4 mt-2">
                                                <template x-for="(item, index) in items" :key="index">
                                                    <div class="flex gap-4 items-start bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                        <div class="flex-1 space-y-3">
                                                            <div>
                                                                <label class="text-xs text-gray-500 font-bold uppercase">Pertanyaan</label>
                                                                <input type="text" x-model="item.question" class="block w-full text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Apakah ada garansi?">
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-500 font-bold uppercase">Jawaban</label>
                                                                <textarea x-model="item.answer" rows="2" class="block w-full text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jawaban Anda..."></textarea>
                                                            </div>
                                                        </div>
                                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 hover:text-red-700 p-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            {{-- Add Button --}}
                                            <button type="button" @click="items.push({ question: '', answer: '' })" class="mt-4 flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Tambah Pertanyaan
                                            </button>
                                        </div>
                                    @elseif($setting->type === 'textarea')
                                        <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3" 
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                    @else
                                        <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full bg-gray-50" :value="old($setting->key, $setting->value)" placeholder="Pertanyaan..." />
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Tab: About --}}
                        <div x-show="activeTab === 'about'" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Tentang Kami</h3>
                            
                            @foreach($settings['about'] ?? [] as $setting)
                                <div>
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['about_', '_'], ['',' '], $setting->key))" />
                                    
                                    @if($setting->type === 'textarea')
                                        <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="4" 
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                    @else
                                        <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full" :value="old($setting->key, $setting->value)" />
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Tab: Contact --}}
                        <div x-show="activeTab === 'contact'" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Kontak</h3>
                            
                            @foreach($settings['contact'] ?? [] as $setting)
                                <div>
                                    <x-input-label :for="$setting->key" :value="ucwords(str_replace(['contact_', '_'], ['',' '], $setting->key))" />
                                    <x-text-input id="{{ $setting->key }}" name="{{ $setting->key }}" type="text" class="mt-1 block w-full" :value="old($setting->key, $setting->value)" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-100 mt-6">
                            <x-primary-button>Simpan Perubahan</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
