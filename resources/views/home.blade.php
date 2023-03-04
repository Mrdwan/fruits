@extends('master')

@section('content')
    @if(session()->has('message'))
        <div class="p-3 mb-4 bg-red-200 border-red-300 rounded-md shadow">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <form action="{{ route('home') }}" method="GET" class="grid grid-cols-3 p-3 bg-white border-gray-300 rounded-md shadow">
        <input type="text" name="name" placeholder="Fruit name" class="p-2 mr-4 border border-gray-200 rounded-md" value="{{ request('name') }}">
        <select name="family" class="p-2 mr-4 border border-gray-200 rounded-md">
            <option value="" class="hidden">Family</option>
            <option value="">all</option>
            @foreach ($families as $family)
                <option value="{{ $family->id }}" {{ request('family') == $family->id ? 'selected' : null }}>
                    {{ $family->name }}
                </option>
            @endforeach
        </select>
        <button class="p-2 px-6 text-white bg-gray-700 border rounded-md color-white place-self-end" type="submit">
            Filter
        </button>
    </form>

    @if ($fruits->isNotEmpty())
        <div class="grid grid-cols-3 gap-4 mt-6">
            @foreach ($fruits as $fruit)
                <div class="p-3 bg-white border-gray-300 rounded-md shadow">
                    <div class="flex justify-between">
                        <div>{{ $fruit->name }}</div>

                        <form action="{{ route('favorited.update', $fruit->id) }}" method="post">
                            @method('patch')
                            @csrf
                            <button class="submit">
                                @include('components.icons.heart', ['isFilled' => (int)$fruit->is_favorited])
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
    @else
        <div class="p-3 mt-4 bg-red-200 border-red-300 rounded-md shadow">no Fruits found</div>
    @endif

    <div class="mt-8">
        {{ $fruits->links() }}
    </div>
@endsection