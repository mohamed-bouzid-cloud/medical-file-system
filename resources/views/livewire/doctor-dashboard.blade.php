<div class="min-h-screen w-full flex bg-gray-900 text-white font-sans overflow-hidden">

    <!-- Enhanced Sidebar -->
    <aside class="w-72 bg-gradient-to-br from-gray-800 to-gray-900 p-6 border-r border-gray-700/50 flex flex-col transform transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Patients</h1>
            <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        </div>

        <div class="relative mb-6 group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500 group-focus-within:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text"
                wire:model="searchTerm"
                placeholder="Search patients..."
                class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-700/80 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:bg-gray-700 transition-all duration-200 shadow-sm"
            />
        </div>

        <ul class="space-y-3 flex-1 overflow-y-auto custom-scrollbar">
            @forelse($filteredPatients as $patient)
                <li class="group">
                    <button
                        wire:click="selectPatient('{{ $patient->ipp }}')"
                        class="w-full text-left px-4 py-3 rounded-xl flex justify-between items-center transition-all duration-200
                               {{ $selectedPatient === $patient->ipp ? 
                                  'bg-gradient-to-r from-blue-600/80 to-blue-800 shadow-lg' : 
                                  'hover:bg-gray-700/50 hover:shadow-md group-hover:translate-x-1' }} 
                               transform hover:scale-[1.02]">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-gray-600 flex items-center justify-center overflow-hidden">
                                <span class="text-xs font-bold uppercase">
                                    {{ substr($patient->name, 0, 2) }}
                                </span>
                            </div>
                            <span class="font-medium">{{ $patient->name }}</span>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-700/50 text-gray-300">{{ $patient->ipp }}</span>
                    </button>
                </li>
            @empty
                <li class="text-center py-6 text-gray-400/80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    No assigned patients found
                </li>
            @endforelse
        </ul>

        <div class="mt-auto pt-4 border-t border-gray-700/50">
            <div class="flex items-center justify-between text-gray-400 text-sm">
                <span>Total Patients</span>
                <span class="font-mono bg-gray-800/50 px-2 py-1 rounded">{{ count($filteredPatients) }}</span>
            </div>
        </div>
    </aside>

    <!-- Enhanced Main Content -->
    <main class="flex-1 p-8 overflow-y-auto space-y-6 w-full bg-gradient-to-br from-gray-900 to-gray-900/80">

        {{-- Enhanced Alerts --}}
        @foreach (['success', 'error'] as $msg)
            @if(session()->has($msg))
                <div class="{{ $msg === 'success' ? 
                    'bg-gradient-to-r from-green-600/20 to-green-800/20 border-l-4 border-green-500 text-green-200' : 
                    'bg-gradient-to-r from-red-600/20 to-red-800/20 border-l-4 border-red-500 text-red-200' }} 
                    p-4 rounded-lg shadow-lg backdrop-blur-sm flex items-start space-x-3 w-full animate-fade-in">
                    <div class="{{ $msg === 'success' ? 'text-green-400' : 'text-red-400' }} mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $msg === 'success' ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        {{ session($msg) }}
                    </div>
                    <button class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif
        @endforeach

        @if($errors->any())
            <div class="bg-gradient-to-r from-red-600/20 to-red-800/20 border-l-4 border-red-500 text-red-200 p-4 rounded-lg shadow-lg backdrop-blur-sm w-full animate-fade-in">
                <div class="flex items-start space-x-3">
                    <div class="text-red-400 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold mb-1">Validation Errors</h4>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if($selectedPatient && $patientData)
            <div class="flex flex-col space-y-8 w-full">

                <!-- Enhanced Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-3 md:space-y-0 w-full">
                    <div>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-300 to-cyan-200 bg-clip-text text-transparent">{{ $patientData->name ?? 'N/A' }}</h2>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-gray-400 font-mono text-sm bg-gray-800/50 px-2 py-1 rounded">IPP: {{ $patientData->ipp ?? 'N/A' }}</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-900/30 text-green-400 border border-green-800/50 flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-400 mr-1.5 animate-pulse"></span>
                                Active Patient
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="px-4 py-2 rounded-lg bg-gray-700/50 hover:bg-gray-700 text-gray-300 hover:text-white transition-all flex items-center space-x-2 border border-gray-700/50 hover:border-gray-600/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                            <span>Actions</span>
                        </button>
                        <button class="px-4 py-2 rounded-lg bg-blue-600/80 hover:bg-blue-500 text-white transition-all flex items-center space-x-2 shadow-lg hover:shadow-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            <span>Generate Report</span>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Tabs -->
                <div x-data="{ tab: 'overview' }" class="space-y-8 w-full">
                    <div class="flex space-x-1 border-b border-gray-700/50 w-full">
                        <button @click="tab='overview'" 
                                :class="tab==='overview' ? 
                                'text-blue-400 border-b-2 border-blue-400 bg-blue-500/10' : 
                                'text-gray-400 hover:text-white hover:bg-gray-700/30'" 
                                class="px-6 py-3 font-semibold transition-all duration-200 rounded-t-lg flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Overview</span>
                        </button>
                        <button @click="tab='appointments'" 
                                :class="tab==='appointments' ? 
                                'text-blue-400 border-b-2 border-blue-400 bg-blue-500/10' : 
                                'text-gray-400 hover:text-white hover:bg-gray-700/30'" 
                                class="px-6 py-3 font-semibold transition-all duration-200 rounded-t-lg flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Appointments</span>
                        </button>
                        <button @click="tab='dicom'" 
                                :class="tab==='dicom' ? 
                                'text-blue-400 border-b-2 border-blue-400 bg-blue-500/10' : 
                                'text-gray-400 hover:text-white hover:bg-gray-700/30'" 
                                class="px-6 py-3 font-semibold transition-all duration-200 rounded-t-lg flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span>DICOM Upload</span>
                        </button>
                    </div>

                    <!-- Enhanced Overview Tab -->
                    <div x-show="tab==='overview'" x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         class="space-y-8 w-full">
                        
                        <!-- Stats Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                            @php
                                $cards = [
                                    ['title'=>'Conditions','color'=>'blue','items'=>$patientData->conditions ?? [], 'key_name'=>'condition_name','desc'=>'notes', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                    ['title'=>'Allergies','color'=>'red','items'=>$patientData->allergies ?? [], 'key_name'=>'allergen','desc'=>'reaction', 'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                    ['title'=>'Medications','color'=>'green','items'=>$patientData->medications ?? [], 'key_name'=>'medication_name','desc'=>'dosage', 'icon'=>'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2'],
                                ];
                            @endphp

                            @foreach($cards as $card)
                                <div class="bg-gray-800/50 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-700/30 hover:border-{{ $card['color'] }}-400/30 group">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-{{ $card['color'] }}-400">{{ $card['title'] }}</h3>
                                        <div class="w-10 h-10 rounded-full bg-{{ $card['color'] }}-900/30 flex items-center justify-center text-{{ $card['color'] }}-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="space-y-3">
                                        @forelse($card['items'] as $item)
                                            <li class="bg-gray-700/50 px-4 py-3 rounded-lg hover:bg-{{ $card['color'] }}-900/20 transition-all duration-200 flex justify-between items-center border border-gray-700/30 hover:border-{{ $card['color'] }}-400/30">
                                                <span class="font-medium">{{ $item[$card['key_name']] ?? '-' }}</span>
                                                <span class="text-xs px-2 py-1 rounded-full bg-gray-800/50 text-gray-300">{{ $item[$card['desc']] ?? '-' }}</span>
                                            </li>
                                        @empty
                                            <li class="text-center py-4 text-gray-400/70">
                                                No {{ strtolower($card['title']) }} recorded
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endforeach
                        </div>

                        <!-- Enhanced Doctor Note Upload -->
                        <div class="bg-gray-800/50 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-700/30 hover:border-yellow-400/30 w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-yellow-400">Upload Doctor Note</h3>
                                <div class="w-10 h-10 rounded-full bg-yellow-900/30 flex items-center justify-center text-yellow-400 animate-pulse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>

                            <form wire:submit.prevent="submitDoctorNote"
                                enctype="multipart/form-data"
                                class="flex flex-col md:flex-row items-start md:items-end space-y-4 md:space-y-0 md:space-x-4 w-full">

                                <div class="flex-1 w-full">
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Select Document</label>
                                    <div class="relative">
                                        <input type="file"
                                            wire:model="doctorNoteFile"
                                            class="block w-full px-4 py-3 rounded-xl bg-gray-700/80 text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:bg-gray-700 transition-all duration-200 shadow-sm border border-gray-700/50 hover:border-yellow-400/50 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-500/20 file:text-yellow-400 hover:file:bg-yellow-500/30"
                                            accept=".txt,.pdf,.doc,.docx"
                                            required>
                                    </div>
                                </div>

                                <div class="flex flex-col space-y-1 min-w-[120px]">
                                    @if($fileIsBound)
                                        <div class="flex items-center text-green-400 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Ready to upload
                                        </div>
                                    @endif
                                    <div wire:loading wire:target="doctorNoteFile" class="flex items-center text-blue-300 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Processing...
                                    </div>
                                </div>

                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        wire:target="doctorNoteFile,submitDoctorNote"
                                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500 text-white font-semibold transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center min-w-[150px]">
                                    <span wire:loading.remove wire:target="submitDoctorNote" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        Submit
                                    </span>
                                    <span wire:loading wire:target="submitDoctorNote" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Uploading...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <tbody class="bg-gray-800/30 divide-y divide-gray-700/30">
    <!-- Enhanced Appointments Tab -->
<div x-show="tab==='appointments'" x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="space-y-6 w-full">

    <table class="min-w-full divide-y divide-gray-700/30">
        <thead class="bg-gray-800/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Purpose</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-gray-800/30 divide-y divide-gray-700/30">
            @foreach($upcomingAppointments as $appt)
            <tr class="hover:bg-gray-700/30 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-white">{{ $appt['date'] }}</div>
                    <div class="text-xs text-gray-400">{{ $appt['time'] }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-300">{{ $appt['purpose'] ?? 'General Checkup' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusColors = [
                            'scheduled' => 'bg-blue-900/30 text-blue-400',
                            'completed' => 'bg-green-900/30 text-green-400',
                            'cancelled' => 'bg-red-900/30 text-red-400',
                            'rescheduled' => 'bg-yellow-900/30 text-yellow-400'
                        ];
                        $statusColor = $statusColors[strtolower($appt['status'] ?? '')] ?? 'bg-gray-700 text-gray-300';
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">{{ ucfirst($appt['status'] ?? 'Scheduled') }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                    <button class="text-gray-400 hover:text-gray-300">Edit</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



                    <!-- Enhanced DICOM Upload Tab -->
<div x-show="tab==='dicom'" x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0 translate-y-2" 
     x-transition:enter-end="opacity-100 translate-y-0" 
     class="bg-gray-800/50 p-6 rounded-2xl shadow-lg border border-gray-700/30 w-full">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-green-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                DICOM Files Upload
            </h3>
            <p class="text-sm text-gray-400 mt-1">Upload medical imaging files in DICOM format</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-xs px-2 py-1 rounded-full bg-gray-800/50 text-gray-400 border border-gray-700/50">Max 10 files</span>
            <span class="text-xs px-2 py-1 rounded-full bg-gray-800/50 text-gray-400 border border-gray-700/50">Max 50MB each</span>
        </div>
    </div>

    <form wire:submit.prevent="uploadDicom" class="space-y-6 w-full">
        <!-- Drag and Drop Zone -->
        <div class="border-2 border-dashed border-gray-700/50 rounded-2xl p-8 text-center transition-all duration-300 hover:border-green-400/50 hover:bg-gray-700/20 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 group-hover:text-green-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <h4 class="text-lg font-medium text-gray-300 mb-1">Drag and drop DICOM files here</h4>
            <p class="text-sm text-gray-500 mb-4">or</p>
            <label class="px-6 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-700 text-white font-medium transition-all duration-200 shadow cursor-pointer border border-gray-700/50 hover:border-green-400/50 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Select Files
                <input type="file" wire:model="dicomFiles" multiple class="hidden" accept=".dcm,.dicom">
            </label>
        </div>

        <!-- Description -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Study Description</label>
            <input type="text" 
                   wire:model="dicomDescription" 
                   placeholder="Enter a description for this study" 
                   class="block w-full px-4 py-3 rounded-xl bg-gray-700/80 text-white placeholder-gray-500 
                          focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:bg-gray-700 
                          transition-all duration-200 shadow-sm border border-gray-700/50 hover:border-green-400/50">
            <p class="text-xs text-gray-500">Optional: add notes about this imaging study</p>
        </div>

        <!-- Certificate Password -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-400">Certificate Password</label>
            <div class="relative">
                <input type="password" 
                       wire:model="certificatePassword" 
                       placeholder="Enter your certificate password" 
                       class="block w-full px-4 py-3 rounded-xl bg-gray-700/80 text-white placeholder-gray-500 
                              focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:bg-gray-700 
                              transition-all duration-200 shadow-sm border border-gray-700/50 hover:border-green-400/50 pr-10">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500">Required for DICOM file signing</p>
        </div>

        <!-- Upload Button -->
        <button type="submit" 
                class="w-full px-6 py-4 rounded-xl bg-gradient-to-r from-green-600 to-green-700 
                       hover:from-green-500 hover:to-green-600 text-white font-semibold 
                       transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.01] 
                       flex items-center justify-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            <span>Upload & Sign DICOM Files</span>
        </button>
    </form>
</div>

        @else
            <div class="text-center py-20 w-full animate-fade-in">
                <div class="max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500/60 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-300 mb-2">No Patient Selected</h3>
                    <p class="text-gray-500 mb-6">Select a patient from the sidebar to view and manage their medical records</p>
                    <button class="px-6 py-3 rounded-xl bg-blue-600/80 hover:bg-blue-500 text-white font-medium transition-all duration-200 shadow-lg hover:shadow-xl inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Patient
                    </button>
                </div>
            </div>
        @endif
    </main>


<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(75, 85, 99, 0.3);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
</div>