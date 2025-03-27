@extends('components.layout')

@section('content')
<div class="container">
    
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Please verify your email</h1>
            <p class="text-center text-gray-600 mb-6">We've sent you an email with a verification link.</p>
            <p class="text-center text-gray-600 mb-4">Didn't get the email?</p>
            <form action="{{ route('verification.send') }}" method="post" class="flex flex-col items-center">
                @csrf
                <button class="primary-btn w-full">Send Again</button>
            </form>
        </div>
    </div>

</div>
@endsection