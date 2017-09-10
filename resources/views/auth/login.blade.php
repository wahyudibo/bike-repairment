@extends('layouts.master')

@section('navbar')
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Bengkel Sepeda Kampus UGM</a>
</nav>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Login</h4>
                    <form action="{{ route('login') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="id">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
