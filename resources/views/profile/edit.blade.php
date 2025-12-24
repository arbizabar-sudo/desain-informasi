@extends('layout')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>First name</label>
            <input name="first_name" value="{{ old('first_name', $user->first_name) }}">
        </div>
        <div>
            <label>Last name</label>
            <input name="last_name" value="{{ old('last_name', $user->last_name) }}">
        </div>
        <div>
            <label>Username</label>
            <input name="username" value="{{ old('username', $user->username) }}">
        </div>
        <div>
            <label>Bio</label>
            <textarea name="bio">{{ old('bio', $user->bio) }}</textarea>
        </div>
        <div>
            <label>Headline</label>
            <input name="headline" value="{{ old('headline', $user->headline) }}">
        </div>
        <div>
            <label>Institution</label>
            <input name="institution" value="{{ old('institution', $user->institution) }}">
        </div>
        <div>
            <label>Location</label>
            <select name="location">
                <option value="">Select country</option>
                <option value="Indonesia" {{ old('location', $user->location) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                <option value="United States" {{ old('location', $user->location) == 'United States' ? 'selected' : '' }}>United States</option>
                <option value="Other" {{ old('location', $user->location) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div>
            <label>City</label>
            <input name="city" value="{{ old('city', $user->city) }}">
        </div>
        <div>
            <label>Location</label>
            <input name="location" value="{{ old('location', $user->location) }}">
        </div>
        <div>
            <label>Website</label>
            <input name="website" value="{{ old('website', $user->website) }}">
        </div>
        <div>
            <label>Instagram URL</label>
            <input name="ig" value="{{ old('ig', $user->ig) }}">
        </div>

        <div>
            <label>Avatar</label>
            <input type="file" name="avatar">
            @if($user->avatar)<div><img src="{{ asset('storage/'.$user->avatar) }}" style="width:80px;height:80px;object-fit:cover;border-radius:50%"></div>@endif
        </div>

        <div>
            <label>Cover Image</label>
            <input type="file" name="cover_image">
            @if($user->cover_image)<div><img src="{{ asset('storage/'.$user->cover_image) }}" style="width:200px;height:80px;object-fit:cover"></div>@endif
        </div>

        <div>
            <button class="btn">Save</button>
        </div>
    </form>
</div>
@endsection
