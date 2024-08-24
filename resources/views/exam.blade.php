<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Features Section -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-center">{{$exam->title}}</h2>
            <p class="sexam text-center"><strong>{{$exam->description}}</strong></p>
            <p class="sexam text-center mb-5 text-danger">Total Questions:- {{$exam->questions_count}}</p>
            <div id="exam-container" data-time-limit="{{$exam->time_limit}}">

            </div>
            <div id="timer">Time Remaining: <span id="time-remaining"></span></div>
            <form id="exam-form" action="{{route('examsubmit')}}" method="POST">
                @csrf
                <input type="hidden" value="{{$exam->id}}" name="examid">
                @foreach($exam->questions as $index => $question)
                    <div class="question-step" data-step="{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                        <input type="hidden" name="questions[{{ $loop->index }}][question_id]" value="{{ $question->id }}">
                        <p>(<b>{{ $index + 1 }}</b>) {{$question->question}}</p>
                        @foreach($question->options as $option)
                        <div class="option">
                            <input type="radio" id="option{{ $option->id }}" name="questions[{{ $loop->parent->index }}][selected_option_id]" value="{{ $option->id }}">
                            <label for="option{{ $option->id }}">{{ $option->option }}</label>
                        </div>
                        @endforeach
                        <br/>
                        <!-- Navigation Buttons -->
                        <div class="navigation-buttons">
                            @if($index > 0)
                                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                            @endif
                            @if($index < count($exam->questions) - 1)
                                <button type="button" class="btn btn-primary next-btn">Next</button>
                            @else
                                <button type="submit" id="submit-exam-button" class="btn btn-success">Submit</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
</x-app-layout>