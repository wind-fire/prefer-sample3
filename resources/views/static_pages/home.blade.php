@extends('layouts.default')

@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p>
           你现在看到的是 <a href="http://prefer-app-sample3.herokuapp.com">Laravel 入门教程</a> 的示例项目
        </p>
        <p>
            一切，从这里开始
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
        </p>
    </div>
@stop