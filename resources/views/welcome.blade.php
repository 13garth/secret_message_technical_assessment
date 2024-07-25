@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>Secrect Message Specifications</h1>
                    <ul>
                        <li>
                            Running PHP 8.2.9 for development environment <br>
                            <img src="{{ asset('assets/current-php-version.png') }}" alt="php-version">
                        </li>
                        <br>
                        <li>
                            Running MySQL 8.0.34 for development environment <br>
                            <img src="{{ asset('assets/current-mysql-version.png') }}" alt="php-version">
                        </li>
                        <br>
                        <li>
                            Running MySQL 18.17.1 for development environment <br>
                            <img src="{{ asset('assets/current-node-version.png') }}" alt="php-version">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
