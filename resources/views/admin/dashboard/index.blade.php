@extends('layouts.admin')

@section('content')

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen bg-gray-100 p-10 flex flex-col items-left">

        <!-- Page Header -->
        <header class="w-full max-w-6xl mb-12 px-6">
            <h1 class="text-4xl font-extrabold text-gray-800 text-left md:text-left">
                Dashboard Overview
            </h1>
            <p class="mt-10 text-gray-600 text-center md:text-left text-lg max-w-10xl">
            </p>
        </header>

        <!-- Dashboard Content Grid -->
        <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-6">

            <!-- Active Users Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-5 text-white text-center rounded-t-xl">
                    <h3 class="text-2xl font-bold">Active Users</h3>
                </div>
                <div class="p-8 flex flex-col items-center justify-center">
                    <p class="text-6xl font-extrabold text-gray-900 mb-3">
                        {{ $activeUsers ?? '0' }}
                    </p>
                    <p class="text-gray-600 text-base">currently active on the platform</p>
                </div>
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 rounded-b-xl">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-900 transition duration-200 ease-in-out">
                            View All Users
                            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Pets Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 p-5 text-white text-center rounded-t-xl">
                    <h3 class="text-2xl font-bold">Total Pets</h3>
                </div>
                <div class="p-8 flex flex-col items-center justify-center">
                    <p class="text-6xl font-extrabold text-gray-900 mb-3">
                        {{ $totalPets ?? '0' }}
                    </p>
                    <p class="text-gray-600 text-base">pets available in the system</p>
                </div>
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 rounded-b-xl">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.managepet.index') }}" class="inline-flex items-center text-sm font-semibold text-green-700 hover:text-green-900 transition duration-200 ease-in-out">
                            Manage Pets
                            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Applications Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-purple-600 to-violet-700 p-5 text-white text-center rounded-t-xl">
                    <h3 class="text-2xl font-bold">Applications</h3>
                </div>
                <div class="p-8 flex flex-col items-center justify-center">
                    <p class="text-6xl font-extrabold text-gray-900 mb-3">
                        {{ $totalApplications ?? '0' }}
                    </p>
                    <p class="text-gray-600 text-base">adoption applications received</p>
                </div>
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 rounded-b-xl">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.adoptions.index') }}" class="inline-flex items-center text-sm font-semibold text-purple-700 hover:text-purple-900 transition duration-200 ease-in-out">
                            View Applications
                            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full max-w-6xl px-6">
            <p class="mt-10 text-gray-600 text-center md:text-left text-lg max-w-10xl">
            </p>
            <h1 class="text-4xl font-extrabold text-gray-800 text-left md:text-left mb-6">
                Shelter Application Status Percentages
            </h1>

            <!-- Filter dropdown -->
            <form method="GET" class="mb-10 text-left">
                <label for="filter" class="mr-4 text-lg font-semibold text-indigo-800">Filter by:</label>
                <select name="filter" id="filter" onchange="this.form.submit()" class="border border-indigo-300 rounded-lg px-5 py-3 bg-white text-indigo-700 shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="day" {{ ($filter ?? '') == 'day' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ ($filter ?? '') == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ ($filter ?? '') == 'month' ? 'selected' : '' }}>This Month</option>
                </select>
            </form>

            <!-- Bar Chart Section -->
            <div class="bg-white p-8 rounded-2xl shadow-2xl border border-indigo-300">
                <h2 class="text-2xl font-bold text-indigo-900 mb-6">Status Percentages Chart</h2>
                <canvas id="percentChart" style="height: 320px;"></canvas>
            </div>
        </div>
    </div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const percentCtx = document.getElementById('percentChart').getContext('2d');

    new Chart(percentCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($percentages)),
            datasets: [{
                label: 'Percentage (%)',
                data: @json(array_values($percentages)),
                backgroundColor: ['#10B981', '#F97316', '#EF4444'], // green, orange, red
                borderRadius: 10,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#4B0082',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: '#4B0082'
                    },
                    title: {
                        display: true,
                        text: 'Percentage',
                        color: '#4B0082',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        color: '#4B0082'
                    }
                }
            }
        }
    });
</script>
@endsection
