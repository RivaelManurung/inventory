@inject('authService', 'App\Services\AuthService')

@php
if (!session()->has('user') && session()->has('jwt_token')) {
$user = $authService->getAuthenticatedUser();
if ($user) {
session(['user' => [
'user_id' => $user->user_id,
'user_nama' => $user->user_nama,
'user_nmlengkap' => $user->user_nmlengkap,
'user_email' => $user->user_email,
'user_foto' => $user->user_foto,
'role' => $user->role,
'permissions' => $user->permissions
]]);
}
}
$user = session('user') ? (object)session('user') : null;
@endphp
<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
	<div class="container-fluid">
		<div class="d-flex d-lg-none me-2">
			<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
				<i class="ph-list"></i>
			</button>
		</div>

		<div class="navbar-brand flex-1 flex-lg-0">
			<a href="{{ url('/dashboard') }}" class="d-inline-flex align-items-center">
				<img src="{{ asset('assets/images/logo.jpg') }}" class="w-16 h-16" alt="Logo Icon">
				<span class="d-none d-sm-inline-block ms-3 fw-bold fs-5 text-uppercase text-light">
					Inventori TSTH2
				</span>
			</a>
		</div>

		<ul class="nav flex-row justify-content-end order-1 order-lg-2">
			<li class="nav-item ms-lg-2">
				<a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas"
					data-bs-target="#notifications">
					<i class="ph-bell"></i>
					<span
						class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
				</a>
			</li>

			<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
				<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
					<div class="status-indicator-container">
						@if(isset($user->user_foto) && $user->user_foto)
						<img src="{{ $user->user_foto }}" class="w-32px h-32px rounded-pill" alt="User Photo">
						@else
						<div
							class="w-32px h-32px rounded-pill bg-primary d-flex align-items-center justify-content-center text-white">
							{{ strtoupper(substr($user->user_nama ?? 'U', 0, 1)) }}
						</div>
						@endif
						<span class="status-indicator bg-success"></span>
					</div>
					<span class="d-none d-lg-inline-block mx-lg-2">
						{{ $user->user_nmlengkap ?? $user->user_nama ?? 'User' }}
						@if(isset($user->role))
						<span class="badge bg-primary ms-1">
							{{ ucfirst($user->role) }}
						</span>
						@endif
					</span>
				</a>

				<div class="dropdown-menu dropdown-menu-end">
					<a href="#" class="dropdown-item">
						<i class="ph-user-circle me-2"></i>
						{{ $user->user_nmlengkap ?? 'My Profile' }}
					</a>
					<a href="#" class="dropdown-item">
						<i class="ph-envelope me-2"></i>
						{{ $user->user_email ?? '' }}
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<i class="ph-gear me-2"></i>
						Settings
					</a>
					<a href="{{ route('logout') }}" class="dropdown-item">
						<i class="ph-sign-out me-2"></i>
						Logout
					</a>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- /main navbar -->