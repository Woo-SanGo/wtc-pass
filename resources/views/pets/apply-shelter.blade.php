@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-3 text-danger">Only shelters can add a pet!</h2>
    <p>Hey there! It looks like only registered shelters can list pets for adoption right now. No worries though if you're a shelter or want to become one, we would love to have you join our community!</p>
    <p>Just apply below, and we will guide you through the process with a warm welcome. It is super easy, and we are excited to support you in finding loving homes for pets!</p>
    <a href="{{ route('applications.shelter-form') }}">Apply for Shelter</a>
        Apply to Become a Shelter
    </a>
</div>
@endsection