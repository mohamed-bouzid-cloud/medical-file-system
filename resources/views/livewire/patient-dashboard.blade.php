<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MediVault | Patient Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        accent: '#38bdf8',
                    },
                    boxShadow: {
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1)',
                        'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .smooth-transition {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
        .badge {
            @apply px-2 py-1 text-xs font-semibold rounded-full;
        }
        .status-active {
            @apply bg-green-100 text-green-800;
        }
        .status-pending {
            @apply bg-yellow-100 text-yellow-800;
        }
        .status-completed {
            @apply bg-blue-100 text-blue-800;
        }
        .status-critical {
            @apply bg-red-100 text-red-800;
        }
        .status-moderate {
            @apply bg-orange-100 text-orange-800;
        }
        .status-mild {
            @apply bg-purple-100 text-purple-800;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-dark-900 to-dark-800 text-dark-100 font-sans antialiased tracking-tight p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header -->
        <header class="flex flex-col md:flex-row items-center justify-between border-b border-dark-700 pb-6 gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-primary-600 p-3 rounded-xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">MediVault</h1>
                    <p class="text-sm text-dark-400">Comprehensive Patient Health Portal</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-base text-dark-300">Welcome back, <span class="font-semibold text-white">{{ Auth::user()->first_name ?? 'Guest' }}</span></p>
                    <p class="text-sm text-dark-500">{{ Auth::user()->email }}</p>
                </div>
                <div class="relative group">
                    <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold cursor-pointer">
                        {{ strtoupper(substr(Auth::user()->first_name ?? 'G', 0, 1)) }}
                    </div>
                    <div class="absolute right-0 mt-2 w-48 bg-dark-700 rounded-md shadow-lg py-1 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200">
                        <a href="#" class="block px-4 py-2 text-sm text-dark-200 hover:bg-dark-600">Profile Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-dark-200 hover:bg-dark-600">Help Center</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-dark-600">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-dark-700 rounded-xl p-4 shadow-md border-l-4 border-blue-500">
                <p class="text-sm text-dark-400">Upcoming Appointments</p>
                <p class="text-2xl font-bold text-white">{{ count($appointments) }}</p>
            </div>
            <div class="bg-dark-700 rounded-xl p-4 shadow-md border-l-4 border-green-500">
                <p class="text-sm text-dark-400">Active Medications</p>
                <p class="text-2xl font-bold text-white">{{ count($medications) }}</p>
            </div>
            <div class="bg-dark-700 rounded-xl p-4 shadow-md border-l-4 border-purple-500">
                <p class="text-sm text-dark-400">Health Conditions</p>
                <p class="text-2xl font-bold text-white">{{ count($conditions) }}</p>
            </div>
            <div class="bg-dark-700 rounded-xl p-4 shadow-md border-l-4 border-red-500">
                <p class="text-sm text-dark-400">Known Allergies</p>
                <p class="text-2xl font-bold text-white">{{ count($allergies) }}</p>
            </div>
        </div>

        <!-- Patient Info -->
        <section class="bg-dark-700 rounded-2xl shadow-xl p-6 space-y-6 animate-slide-up">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="bg-primary-500 p-2 rounded-lg">
                        <i class="fas fa-user-injured text-white"></i>
                    </div>
                    <span>Patient Information</span>
                </h2>
                <button class="text-primary-400 hover:text-primary-300 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-edit"></i> Edit Information
                </button>
            </div>
            
            @if($patient)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-base">
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Full Name</p>
                        <p class="text-white font-medium">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                    </div>
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Patient ID (IPP)</p>
                        <p class="text-white font-medium">{{ $patient->ipp }}</p>
                    </div>
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Date of Birth</p>
                        <p class="text-white font-medium">{{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('M d, Y') : '-' }}</p>
                    </div>
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Gender</p>
                        <p class="text-white font-medium">{{ $patient->gender ?? '-' }}</p>
                    </div>
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Contact</p>
                        <p class="text-white font-medium">{{ $patient->phone ?? '-' }}</p>
                    </div>
                    <div class="bg-dark-800 p-4 rounded-lg">
                        <p class="text-dark-400 text-sm mb-1">Blood Type</p>
                        <p class="text-white font-medium">{{ $patient->blood_type ?? 'Unknown' }}</p>
                    </div>
                </div>
            @else
                <div class="bg-dark-800 rounded-lg p-8 text-center">
                    <i class="fas fa-user-slash text-4xl text-dark-500 mb-4"></i>
                    <p class="text-dark-400">No patient data found.</p>
                    <button class="mt-4 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Complete Your Profile
                    </button>
                </div>
            @endif
        </section>

        <!-- Grid Layout -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Appointments Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-calendar-check"></i> Appointments
                        </h3>
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            {{ count($appointments) }} upcoming
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($appointments as $appt)
                        <div class="bg-dark-800 p-4 rounded-lg border-l-4 border-blue-500 smooth-transition hover:bg-dark-750">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-white">{{ $appt->doctor_name }}</p>
                                    <p class="text-sm text-dark-400">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('D, M j, Y \a\t g:i A') }}</p>
                                </div>
                                <span class="badge status-{{ strtolower($appt->status) }}">
                                    {{ $appt->status }}
                                </span>
                            </div>
                            @if($appt->notes)
                                <div class="mt-2 text-sm text-dark-300">
                                    <p class="font-medium">Notes:</p>
                                    <p class="text-dark-400">{{ $appt->notes }}</p>
                                </div>
                            @endif
                            <button class="mt-3 text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i> View details
                            </button>
                        </div>
                    @empty
                        <div class="bg-dark-800 rounded-lg p-6 text-center">
                            <i class="fas fa-calendar-times text-3xl text-dark-500 mb-3"></i>
                            <p class="text-dark-400">No upcoming appointments</p>
                            <button class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs font-medium">
                                Schedule Appointment
                            </button>
                        </div>
                    @endforelse
                    <div class="pt-2">
                        <button class="w-full text-center text-primary-400 hover:text-primary-300 text-sm font-medium flex items-center justify-center gap-1">
                            <i class="fas fa-plus"></i> Schedule New Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Medications Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-green-600 to-green-800 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-pills"></i> Medications
                        </h3>
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            {{ count($medications) }} active
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($medications as $med)
                        <div class="bg-dark-800 p-4 rounded-lg border-l-4 border-green-500 smooth-transition hover:bg-dark-750">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-white">{{ $med->medication_name }}</p>
                                    <p class="text-sm text-dark-400">{{ $med->dosage }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-dark-400">Start: {{ \Carbon\Carbon::parse($med->start_date)->format('M j, Y') }}</p>
                                    @if($med->end_date)
                                        <p class="text-xs text-dark-400">End: {{ \Carbon\Carbon::parse($med->end_date)->format('M j, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($med->notes)
                                <div class="mt-2 text-sm text-dark-300">
                                    <p class="font-medium">Instructions:</p>
                                    <p class="text-dark-400">{{ $med->notes }}</p>
                                </div>
                            @endif
                            <div class="mt-3 flex justify-between items-center">
                                <button class="text-xs text-green-400 hover:text-green-300 flex items-center gap-1">
                                    <i class="fas fa-history"></i> Refill request
                                </button>
                                <button class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i> Details
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-dark-800 rounded-lg p-6 text-center">
                            <i class="fas fa-pills text-3xl text-dark-500 mb-3"></i>
                            <p class="text-dark-400">No active medications</p>
                        </div>
                    @endforelse
                    <div class="pt-2">
                        <button class="w-full text-center text-green-400 hover:text-green-300 text-sm font-medium flex items-center justify-center gap-1">
                            <i class="fas fa-plus"></i> Add Medication
                        </button>
                    </div>
                </div>
            </div>

            <!-- Conditions Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-heartbeat"></i> Health Conditions
                        </h3>
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            {{ count($conditions) }} recorded
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($conditions as $condition)
                        <div class="bg-dark-800 p-4 rounded-lg border-l-4 border-purple-500 smooth-transition hover:bg-dark-750">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-white">{{ $condition->condition_name }}</p>
                                    <p class="text-sm text-dark-400">Diagnosed: {{ \Carbon\Carbon::parse($condition->diagnosed_date)->format('M j, Y') }}</p>
                                </div>
                                <span class="badge status-{{ $condition->severity ?? 'moderate' }}">
                                    {{ $condition->severity ?? 'Moderate' }}
                                </span>
                            </div>
                            @if($condition->notes)
                                <div class="mt-2 text-sm text-dark-300">
                                    <p class="font-medium">Notes:</p>
                                    <p class="text-dark-400">{{ $condition->notes }}</p>
                                </div>
                            @endif
                            <button class="mt-3 text-xs text-purple-400 hover:text-purple-300 flex items-center gap-1">
                                <i class="fas fa-chart-line"></i> View progression
                            </button>
                        </div>
                    @empty
                        <div class="bg-dark-800 rounded-lg p-6 text-center">
                            <i class="fas fa-heartbeat text-3xl text-dark-500 mb-3"></i>
                            <p class="text-dark-400">No conditions recorded</p>
                        </div>
                    @endforelse
                    <div class="pt-2">
                        <button class="w-full text-center text-purple-400 hover:text-purple-300 text-sm font-medium flex items-center justify-center gap-1">
                            <i class="fas fa-plus"></i> Add Condition
                        </button>
                    </div>
                </div>
            </div>

            <!-- Allergies Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-red-600 to-red-800 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-allergies"></i> Allergies
                        </h3>
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            {{ count($allergies) }} known
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($allergies as $allergy)
                        <div class="bg-dark-800 p-4 rounded-lg border-l-4 border-red-500 smooth-transition hover:bg-dark-750">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-white">{{ $allergy->allergen }}</p>
                                    <p class="text-sm text-dark-400">Reaction: {{ $allergy->reaction }}</p>
                                </div>
                                <span class="badge status-{{ strtolower($allergy->severity ?? 'moderate') }}">
                                    {{ $allergy->severity ?? 'Moderate' }}
                                </span>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <button class="text-xs text-red-400 hover:text-red-300 flex items-center gap-1">
                                    <i class="fas fa-bell"></i> Set reminder
                                </button>
                                <button class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i> Details
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-dark-800 rounded-lg p-6 text-center">
                            <i class="fas fa-allergies text-3xl text-dark-500 mb-3"></i>
                            <p class="text-dark-400">No allergies recorded</p>
                            <button class="mt-3 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs font-medium">
                                Report Allergy
                            </button>
                        </div>
                    @endforelse
                    <div class="pt-2">
                        <button class="w-full text-center text-red-400 hover:text-red-300 text-sm font-medium flex items-center justify-center gap-1">
                            <i class="fas fa-plus"></i> Add Allergy
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lab Results Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-flask"></i> Lab Results
                        </h3>
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            {{ count($labResults) }} available
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($labResults as $result)
                        <div class="bg-dark-800 p-4 rounded-lg border-l-4 border-indigo-500 smooth-transition hover:bg-dark-750">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-white">{{ $result->test_name }}</p>
                                    <p class="text-sm text-dark-400">Date: {{ \Carbon\Carbon::parse($result->result_date)->format('M j, Y') }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if(str_contains(strtolower($result->result), 'normal')) bg-green-100 text-green-800
                                    @elseif(str_contains(strtolower($result->result), 'abnormal')) bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ str_contains(strtolower($result->result), 'normal') ? 'Normal' : 
                                      (str_contains(strtolower($result->result), 'abnormal') ? 'Abnormal' : 'Pending') }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-dark-300">Result:</p>
                                <p class="text-sm text-dark-400">{{ $result->result }}</p>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <button class="text-xs text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
                                    <i class="fas fa-download"></i> Download PDF
                                </button>
                                <button class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                    <i class="fas fa-share"></i> Share
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-dark-800 rounded-lg p-6 text-center">
                            <i class="fas fa-flask text-3xl text-dark-500 mb-3"></i>
                            <p class="text-dark-400">No lab results available</p>
                        </div>
                    @endforelse
                    <div class="pt-2">
                        <button class="w-full text-center text-indigo-400 hover:text-indigo-300 text-sm font-medium flex items-center justify-center gap-1">
                            <i class="fas fa-plus"></i> Request Lab Test
                        </button>
                    </div>
                </div>
            </div>

            <!-- Health Summary Card -->
            <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover">
                <div class="bg-gradient-to-r from-cyan-600 to-cyan-800 p-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-chart-pie"></i> Health Summary
                    </h3>
                </div>
                <div class="p-4">
                    <div class="bg-dark-800 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-white mb-2 flex items-center gap-2">
                            <i class="fas fa-heart text-red-400"></i> Vital Signs
                        </h4>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-dark-400">Blood Pressure</p>
                                <p class="text-white font-medium">120/80 mmHg</p>
                            </div>
                            <div>
                                <p class="text-dark-400">Heart Rate</p>
                                <p class="text-white font-medium">72 bpm</p>
                            </div>
                            <div>
                                <p class="text-dark-400">Temperature</p>
                                <p class="text-white font-medium">98.6°F</p>
                            </div>
                            <div>
                                <p class="text-dark-400">Oxygen Level</p>
                                <p class="text-white font-medium">98%</p>
                            </div>
                        </div>
                        <button class="mt-3 text-xs text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                            <i class="fas fa-plus"></i> Add new reading
                        </button>
                    </div>
                    
                    <div class="bg-dark-800 rounded-lg p-4">
                        <h4 class="font-semibold text-white mb-2 flex items-center gap-2">
                            <i class="fas fa-bell text-yellow-400"></i> Reminders
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="bg-cyan-600 p-2 rounded-lg mt-1">
                                    <i class="fas fa-pills text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Take medication</p>
                                    <p class="text-xs text-dark-400">Every day at 8:00 AM and 8:00 PM</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="bg-purple-600 p-2 rounded-lg mt-1">
                                    <i class="fas fa-dumbbell text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Physical therapy</p>
                                    <p class="text-xs text-dark-400">Monday, Wednesday, Friday at 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                        <button class="mt-3 text-xs text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                            <i class="fas fa-plus"></i> Add new reminder
                        </button>
                    </div>
                </div>
            </div>

        </section>

        <!-- Footer -->
        <footer class="border-t border-dark-700 pt-6 mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-dark-400">MediVault Patient Portal v2.1</p>
                </div>
                <div class="flex gap-4">
                    <a href="#" class="text-sm text-dark-400 hover:text-primary-400">Privacy Policy</a>
                    <a href="#" class="text-sm text-dark-400 hover:text-primary-400">Terms of Service</a>
                    <a href="#" class="text-sm text-dark-400 hover:text-primary-400">Contact Support</a>
                </div>
            </div>
        </footer>
<!-- DICOM Studies Card -->
<!-- DICOM Studies Card -->
<div class="space-y-6">
    <div class="bg-dark-700 rounded-2xl shadow-md overflow-hidden smooth-transition card-hover mt-6">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 p-4">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-x-ray"></i> Imaging Studies
            </h3>
        </div>
        <div class="p-4 space-y-4">
            @forelse($dicomStudies as $study)
                <div class="bg-dark-800 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-white font-medium">Study #{{ $study->id }}</div>
                        <div class="text-xs text-dark-400">{{ $study->created_at->format('Y-m-d H:i') }}</div>
                    </div>

                    <!-- File name -->
                    <div class="text-sm text-dark-400 mb-2 truncate">{{ basename($study->file_path) }}</div>

                    <!-- Description and signature -->
                    <div class="flex flex-col gap-1 text-sm">
                        <p class="text-white">
                            Description: <span class="font-medium">{{ $study->display_description ?? 'No description' }}</span>
                        </p>
                        <p class="text-white">
                            {{ $study->display_signed_by ?? 'Not signed yet' }}
                            @if($study->signed_at)
                                <span class="text-dark-400">on {{ \Carbon\Carbon::parse($study->signed_at)->format('Y-m-d H:i') }}</span>
                            @endif
                        </p>
                    </div>

                    <!-- View button -->
                    <button 
    class="mt-3 w-full text-sm px-3 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 transition flex items-center justify-center gap-2"
    data-url="{{ route('dicom.viewer', ['instanceID' => $study->orthanc_id]) }}"
    @click="window.dispatchEvent(new CustomEvent('open-dicom-viewer', { detail: { url: $event.currentTarget.dataset.url } }))"
>
    <i class="fas fa-eye"></i> View Images
</button>

                </div>
            @empty
                <div class="text-sm text-dark-400">No imaging studies available.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- AlpineJS modal for DICOM Viewer -->
<div x-data="{ open: false, url: '' }"
     x-on:open-dicom-viewer.window="open = true; url = $event.detail.url">
    <template x-if="open">
        <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="relative w-full max-w-6xl max-h-full">
                <iframe :src="url" class="w-full h-[80vh] rounded-xl shadow-lg"></iframe>
                <button class="absolute top-4 right-4 text-white text-3xl font-bold" @click="open = false">×</button>
            </div>
        </div>
    </template>
</div>


<script>
document.addEventListener('livewire:load', () => {
    Livewire.on('open-dicom-viewer', (payload) => {
        console.log('Received payload:', payload); // 🔹 check this
        if (payload?.url) {
            window.dispatchEvent(new CustomEvent('open-dicom-viewer', { detail: { url: payload.url } }));
        } else {
            alert("❌ Viewer URL missing");
        }
    });

    Livewire.on('dicom-error', (data) => {
        alert("❌ DICOM Error: " + data.message);
    });
});
</script>



<!-- Include Cornerstone if needed -->
<script src="https://unpkg.com/cornerstone-core/dist/cornerstone.js"></script>
<script src="https://unpkg.com/cornerstone-wado-image-loader/dist/cornerstoneWADOImageLoader.js"></script>

    <script>
        // Simple animations and interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.boxShadow = '';
                });
            });

            // Tooltip functionality could be added here
            // Or any other interactive elements
        });
    </script>
</body>
</html>