@extends('layouts.main')
@section('title', 'おもひでの詳細だよ')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    <section>
        <article class="card shadow position-relative">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $article->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <h1>{{ $article->caption }}</h1>
                            <h3>{{ $article->info }}</h3>
                        </figcaption>
                    </div>
                </div>
            </figure>
            @can('update', $article)
                <a href="{{ route('articles.edit', $article) }}">
                    <i class="fas fa-pen-square position-absolute top-0 end-0 fs-1"></i>
                </a>
            @endcan
        </article>
        @can('delete', $article)
            <div class="d-grid gap-3 col-6 mx-auto">
                <form action="{{ route('articles.destroy', $article) }}" method="post" id="form">
                    @csrf
                    @method('DELETE')
                </form>
                <input form="form" type="submit" value="削除" onclick="if(!confirm('本当に削除していいですか')){return false}"
                    class="btn btn-danger btn-lg">
            </div>
        @endcan
        <div class="d-grid gap-3 col-6 mx-auto mt-3">
            <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        </div>
    </section>
@endsection
