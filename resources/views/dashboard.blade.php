<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Features Section -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <section id="features" class="py-5">
                <div class="container">
                    <h2 class="text-center mb-5">Exams</h2>
                    <div class="row justify-content-center">
                        @foreach($exams as $exam)
                        <div class="col-md-4 mb-4">
                            <div class="feature-box">
                                <i class="feature-icon"></i>
                                <h3>{{$exam->title}}</h3>
                                <p>{{$exam->description}}</p>
                                <p>Duration:- {{$exam->time_limit/60}} Min.</p>
                                <p>Instructor:- {{$exam->user->name}}</p>
                                <p>Total Questions:- {{$exam->questions_count}}</p>
                            </br>
                                <a href="/exam/{{$exam->id}}" class="btn btn-primary" id="start-exam-button">Start Exam</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
