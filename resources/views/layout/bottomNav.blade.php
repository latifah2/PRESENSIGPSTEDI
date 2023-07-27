    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="/dashboard" class="item {{request()->is('dashboard') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="home-outline" role="img" class="md hydrated"
                    aria-label="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        @if (Auth::guard('userAuthentication')->user()->user_status == 'Guest')
            <a href="/presensi/create" class="item">
                <div class="col">
                    <div class="action-button large">
                        <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                    </div>
                </div>
            </a>
        @endif
        @if (Auth::guard('userAuthentication')->user()->user_status == 'Admin')
        <a href="javascript:;" class="item">
            <div class="col" onclick="location.replace('/user-setting')">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Setting User</strong>
            </div>
        </a>
        @else
        <a href="javascript:;" class="item">
            <div class="col" onclick="location.replace('/profile')">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
        @endif
    </div>
    <!-- * App Bottom Menu -->