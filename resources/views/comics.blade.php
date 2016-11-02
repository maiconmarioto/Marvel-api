@extends('layouts.default')

@section('content')
    <div id="content">
        <form   action="/comics">
            <p>
                <label for="query">Query</label>
                <input type="text" name="query" value="{{ $query }}" id="query">
                <button>Search</button>
            </p>
        </form>

        <div class="results" id="comic">
            @foreach ($comics as $com)
                <article class="card">
                    <img src="{{ $com['thumbnail']['path'] }}/portrait_incredible.jpg" alt="{{ $com['title'] }} thumbnail">
                    <footer>
                        <h5>
                            <a href="/comic/{{ $com['id'] }}" class="card-title">{{ $com['title'] }} </a>
                        </h5>
                        <p>
                            {{ str_limit($com['description'], 160) }}
                        </p>
                    </footer>
                </article>
            @endforeach
        </div>
    </div>
@endsection
