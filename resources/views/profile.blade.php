@extends('layouts.app')

@section('title', 'Profile')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gray-50 px-8 py-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">User Profile</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your account information and settings</p>
        </div>
        
        @if($user)
            <!-- User Info Section -->
            <div class="px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center">
                    @php
                        // Get first character of user's first name
                        $initial = !empty($user->first_name) ? strtoupper(substr($user->first_name, 0, 1)) : '?';
                        
                        // Generate a background color based on the user's name
                        $colorIndex = !empty($user->first_name) ? ord(strtolower($user->first_name[0])) % 5 : 0;
                        $bgColors = [
                            'bg-blue-600',
                            'bg-emerald-600',
                            'bg-purple-600',
                            'bg-rose-600',
                            'bg-amber-600'
                        ];
                        $bgColor = $bgColors[$colorIndex];
                    @endphp
                    
                    <div class="w-24 h-24 rounded-full border-4 border-white shadow-md flex items-center justify-center {{ $bgColor }} text-white text-3xl font-bold">
                        {{ $initial }}
                    </div>
                    
                    <div class="mt-4 md:mt-0 md:ml-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <div class="flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600 ml-2">{{ $user->email }}</p>
                        </div>
                        @if(!empty($user->contact_number))
                        <div class="flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <p class="text-gray-600 ml-2">{{ $user->contact_number }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-100"></div>
            
            <!-- Profile Details -->
            <div class="px-8 py-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gender -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h5 class="text-sm font-medium text-gray-500 ml-2">Gender</h5>
                        </div>
                        <p class="text-gray-800 font-medium">{{ ucfirst($user->gender) ?? 'Not specified' }}</p>
                    </div>
                    
                    <!-- Postcode -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h5 class="text-sm font-medium text-gray-500 ml-2">Postcode</h5>
                        </div>
                        <p class="text-gray-800 font-medium">{{ $user->postcode ?? 'Not specified' }}</p>
                    </div>
                    
                    <!-- Location -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h5 class="text-sm font-medium text-gray-500 ml-2">Location</h5>
                        </div>
                        <p class="text-gray-800 font-medium">
                            {{ $user->city->name ?? 'City not specified' }}{{ isset($user->city->name) && isset($user->state->name) ? ', ' : '' }}{{ $user->state->name ?? '' }}
                        </p>
                    </div>
                    
                    <!-- Roles -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <h5 class="text-sm font-medium text-gray-500 ml-2">Roles</h5>
                        </div>
                        <div>
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-2 mb-1 inline-block">{{ $role->name }}</span>
                                @endforeach
                            @else
                                <p class="text-gray-800 font-medium">No roles assigned</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Hobbies -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h5 class="text-sm font-medium text-gray-500 ml-2">Hobbies</h5>
                    </div>
                    <div>
                        @if(!empty($user->hobbies))
                            @foreach(explode(',', $user->hobbies) as $hobby)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded mr-2 mb-1 inline-block">{{ trim($hobby) }}</span>
                            @endforeach
                        @else
                            <p class="text-gray-800 font-medium">No hobbies listed</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="px-8 py-6 bg-gray-50 border-t">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">Last updated: {{ $user->updated_at->format('M d, Y') }}</p>
                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        @else
            <div class="px-8 py-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">User Not Found</h3>
                <p class="mt-2 text-sm text-gray-500">The requested user profile could not be found in our system.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Return to Home
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection