@extends('layouts.main')
@section('title', 'おもでひを書くよ')
@section('content')
    <div class="col-8 col-offset-2 mx-auto">
        @include('partial.flash')
        @include('partial.errors')
        <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
            <div class="card mb-3">
                @csrf
                <div class="row m-3">
                    <div class="mb-3">
                        <label for="file" class="form-label">画像ファイルを選択してください</label>
                        <input type="file" name="file[]" id="file" class="form-control" multiple="multiple">
                    </div>
                    <div class="mb-3">
                        <label for="caption" class="form-label">説明を入力してください</label>
                        <input type="text" name="caption" id="caption" class="form-control" value="{{ old('caption') }}">
                    </div>
                    <div>
                        <label for="info" class="form-label">詳細を入力してください</label>
                        <textarea name="info" id="info" rows="5" class="form-control">{{ old('info') }}</textarea>
                    </div>
                </div>
                <input type="submit">
        </form>
    </div>
@endsection
