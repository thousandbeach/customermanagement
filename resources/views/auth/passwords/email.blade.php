@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">
        <h1 class="text-white text-2xl pt-5">パスワードリセット</h1>
        <h2 class="text-blue-300 pt-2">パスワードのリセットリンクを送信いたします<br>送信先のメールアドレスをご入力ください</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="pt-10" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} relative">
                <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">メールアドレス</label>
                <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.jp">
                @if ($errors->has('email'))
                    <span class="help-block text-red-600 text-sm pt-1">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="pt-10">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    パスワードのリセットリンクを送信
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
