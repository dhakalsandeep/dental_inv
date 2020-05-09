@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img alt="" style="height: 150px;" class="rounded-circle w-100" src="{{$user->profile->profileImage()}}">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h3">{{ $user->username }}</div>

                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>

                </div>
                @can('update',$user->profile)
                    <a href="/p/create" just>Add New Post</a>
                @endcan

            </div>
            @can('update',$user->profile) <!-- Authorizing Users for Visibility -->
                <div>
                    <a href="/profile/{{$user->id}}/edit" just>Edit Profile</a>
                </div>
            @endcan
            <div class="d-flex">
                <div class="pr-5"><strong>{{$postCount}}</strong> post</div>
                <div class="pr-5"><strong>{{$followersCount}}</strong> followers</div>
                <div class="pr-5"><strong>{{$followingCount}}</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{$user->profile->title}}</div>
            <div>{{$user->profile->description}}</div>
            <div><a href="http://{{$user->profile->url}}" target="_blank">{{$user->profile->url}}</a> </div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{$post->id}}">
                    <img style="object-fit: cover;" src="/storage/{{$post->image}}" style="object-fit: cover;">
                </a>
            </div>
        <!-- <div class="col-4"><img alt="Image may contain: people sitting, screen, laptop and indoor" class="w-100" decoding="auto" sizes="220.53750610351562px" srcset="https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.112.929.929a/s150x150/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=7ff55a0b0610853e05b98546a3d92b3a&amp;oe=5E8BBBC4 150w,https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.112.929.929a/s240x240/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=a2d0e23b0c75ba3ea808a0203f8150eb&amp;oe=5E87C38E 240w,https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.112.929.929a/s320x320/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=c983a204c2b9ccf6d8d79bcc28e858f9&amp;oe=5E86AC34 320w,https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/e35/c0.112.929.929a/s480x480/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=3be9db735202804a67f7266d6132ee17&amp;oe=5E8CB46E 480w,https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/c0.112.929.929a/s640x640/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=9dadae0347e6dff10db67b443381c9ac&amp;oe=5E8084AC 640w" src="https://instagram.fbir1-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/c0.112.929.929a/s640x640/87342432_635895947238639_7505752153798576814_n.jpg?_nc_ht=instagram.fbir1-1.fna.fbcdn.net&amp;_nc_cat=103&amp;_nc_ohc=bwAERaN02B0AX_ohFrT&amp;oh=9dadae0347e6dff10db67b443381c9ac&amp;oe=5E8084AC" style="object-fit: cover;"></div>-->
        @endforeach
    </div>
</div>
@endsection
