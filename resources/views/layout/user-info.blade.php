<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ getImage(config('location.admin.profile.path'), Auth::user()->profile_picture, 'profile') }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
    </div>
</div>

