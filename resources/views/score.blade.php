<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Features Section -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-center">Score Card of {{$user->name}}</h2>
            </br>
            @if($scores->isNotEmpty())
                {{--$scores--}}
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Exam Title</th>
                            <th>Started At</th>
                            <th>Completed At</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $index=>$score)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$score->exam->title}}</td>
                                <td>{{ Carbon\Carbon::parse($score->started_at)->format('d-m-Y g:i A') }}</td>
                                <td>{{ Carbon\Carbon::parse($score->completed_at)->format('d-m-Y g:i A') }}</td>
                                <td>{{$score->score}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td  colspan="4"><b>Total</b></td>
                            <td><b>{{$total}}</b></td>
                        </tr>
                    </tbody>
                </table>
            @else
                <h1 style="font-size: 1.5em; color:blue">No Exam attempted yet!</h1>
            @endif
        </div>
    </div>
</x-app-layout>