<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .feature-box {
                text-align: center;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease-in-out;
                background-color: #eae2b7;
            }

            .feature-box:hover {
                transform: translateY(-10px);
            }

            .feature-icon {
                font-size: 3rem;
                margin-bottom: 20px;
                color: #f77f00;
            }
            h2{
                font-size: 2em;
                font-weight: 900;
                color: red;
                text-decoration: underline;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            {{--@if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif--}}

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Time limit in seconds
                const examContainer = document.getElementById('exam-container');
                if (examContainer) {
                    const timeLimit = parseInt(examContainer.getAttribute('data-time-limit'), 10);
                    let timeRemaining = timeLimit;
                    // Timer function
                    function startTimer() {
                        const timerInterval = setInterval(function () {
                            timeRemaining--;
            
                            // Display the remaining time
                            const hours = Math.floor(timeRemaining / 3600);
                            const minutes = Math.floor((timeRemaining % 3600) / 60);
                            const seconds = timeRemaining % 60;
                            document.getElementById('time-remaining').textContent = `${hours}:${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            
                            // Automatically submit the form when the time is up
                            if (timeRemaining <= 0) {
                                clearInterval(timerInterval);
                                document.getElementById('exam-form').submit();
                            }
                        }, 1000);
                    }
                    // Start the timer when the page loads
                    startTimer();

                    // Show Questions Step-by-Step
                    const steps = document.querySelectorAll('.question-step');
                    let currentStep = 0;
                    function showStep(step) {
                        steps.forEach((stepElement, index) => {
                            stepElement.style.display = index === step ? 'block' : 'none';
                        });
                    }
                    document.querySelectorAll('.next-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            if (currentStep < steps.length - 1) {
                                currentStep++;
                                showStep(currentStep);
                            }
                        });
                    });
                    document.querySelectorAll('.prev-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            if (currentStep > 0) {
                                currentStep--;
                                showStep(currentStep);
                            }
                        });
                    });
                    showStep(currentStep);  // Show the first step initially
                }
            });
        </script>
    </body>
</html>
