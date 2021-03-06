@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">
        <h1 class="text-white text-2xl pt-5">新規登録</h1>
        <h2 class="text-blue-300 pt-2">ユーザー情報をご入力いただけますでしょうか</h2>
        <form class="pt-10" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} relative">
                    <label for="name" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">ユーザー名</label>
                    <input id="name" type="text" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block text-red-600 text-sm pt-1">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} relative pt-3">
                    <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">メールアドレス</label>
                    <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="email" value="{{ old('email') }}" required placeholder="your@email.jp">
                    @if ($errors->has('email'))
                        <span class="help-block text-red-600 text-sm pt-1">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} relative pt-3">
                    <label for="password" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">パスワード</label>
                    <input id="password" type="password" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block text-red-600 text-sm pt-1">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="relative pt-3">
                    <label for="password-confirm" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">確認用パスワード</label>
                    <input id="password-confirm" type="password" class="pt-8 w-full rounded p-3 bg-white-800 outline-none focus:bg-gray-100" name="password_confirmation" required>
                </div>
                {{--<div class="pt-2">
                    <label class="text-white">
                        <input type="checkbox" name="remember" {{ old('') ? 'checked' : '' }}> 個人情報の取り扱いに同意する
                    </label>
                </div>--}}
                <div class="pt-10">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        新規登録
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection
