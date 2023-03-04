@extends('master')

@section('content')
    @if(session()->has('message'))
        <div class="p-3 mt-4 bg-red-200 border-red-300 rounded-md shadow">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="p-3 bg-white border-gray-300 rounded-md shadow">
        all Nutritions:
        <div class="mt-6">
            <div>Carbohydrates: {{ $fruits->sum('carbohydrates') }}</div>
            <div>Protein: {{ $fruits->sum('protein') }}</div>
            <div>Fat: {{ $fruits->sum('fat') }}</div>
            <div>Calories: {{ $fruits->sum('calories') }}</div>
            <div>Sugar: {{ $fruits->sum('sugar') }}</div>
        </div> 
    </div>

    <div class="grid grid-cols-3 gap-4 mt-10">
        @foreach ($fruits as $fruit)
            <div class="p-3 bg-white border-gray-300 rounded-md shadow">
                <div class="flex justify-between">
                    <div>{{ $fruit->name }}</div>

                    <form action="{{ route('favorited.update', $fruit->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <button class="submit">
                            @include('components.icons.heart', ['isFilled' => $fruit->is_favorited])
                        </button>
                    </form>
                </div>

                <div class="mt-6">
                    <div>Genus: {{ $fruit->genus }}</div>
                    <div>Order: {{ $fruit->order }}</div>
                    <div>Carbohydrates: {{ $fruit->carbohydrates }}</div>
                    <div>Protein: {{ $fruit->protein }}</div>
                    <div>Fat: {{ $fruit->fat }}</div>
                    <div>Calories: {{ $fruit->calories }}</div>
                    <div>Sugar: {{ $fruit->sugar }}</div>
                    <div>Family: {{ $fruit->family->name }}</div>
                </div>         
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $fruits->links() }}
    </div>
@endsection