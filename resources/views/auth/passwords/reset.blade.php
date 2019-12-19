@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">
        <h1 class="text-white text-2xl pt-5">パスワードの再設定</h1>
        <h2 class="text-blue-300 pt-2">パスワードの再設定を行います<br>新しいパスワードをご入力ください</h2>
        <form class="pt-10" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} relative">
                <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">メールアドレス</label>
                <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="email" value="{{ $email or old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block text-red-600 text-sm pt-1">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} relative">
                <label for="password" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">新規パスワード</label>
                <input id="password" type="password" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} relative">
                <label for="password-confirm" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">新規パスワード確認</label>
                <input id="password-confirm" type="password" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="password_confirmation" required>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <div class="pt-10">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    パスワードを再設定する
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
