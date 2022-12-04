		<nav class="sidebar sidebar-offcanvas" id="sidebar">
		  <ul class="nav">
			<li class="nav-item nav-profile">
			  <a href="#" class="nav-link">
				<div class="nav-profile-image">
				  <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile">
				  <span class="login-status online"></span>
				  <!--change to offline or busy as needed-->
				</div>
				<div class="nav-profile-text d-flex flex-column">
					@if (Auth::user()->roles == 'customer')
					<span class="font-weight-bold mb-2 mt-2">{{ ucfirst(Auth::user()->name) }}
						<span class="mb-2 font-weight-normal">({{ ucfirst(Auth::user()->roles) }})</span>
					</span>
						@if($transaction != null)
						<span class="mb-2 font-weight-normal">Rp.{{ number_format($transaction->total,0,',','.') }},-</span>
						@else
						<span class="mb-2 font-weight-normal">Rp.{{ number_format(0,0,',','.') }},-</span>
						@endif
					@else
						<span class="font-weight-bold mb-2 mt-2">{{ ucfirst(Auth::user()->name) }}</span>
						<span class="mb-2">{{ ucfirst(Auth::user()->roles) }}</span>
					@endif
				 
				</div>
			  </a>
			</li>
			@if (Auth::user()->roles == 'admin')
			<li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
				<a class="nav-link" href="{{ route('home') }}">
				  <span class="menu-title">Dashboard</span>
				  <i class="mdi mdi-home menu-icon"></i>
				</a>
			  </li>
			  <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
				  <a class="nav-link" href="{{ route('users.index') }}">
					<span class="menu-title">User</span>
					<i class="mdi mdi-account-box menu-icon"></i>
				  </a>
			  </li>
			  @elseif (Auth::user()->roles == 'customer')
			  <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
				  <a class="nav-link" href="{{ route('home') }}">
				  <span class="menu-title">Dashboard</span>
				  <i class="mdi mdi-home menu-icon"></i>
				  </a>
			  </li>
			@endif			  
			@if (Auth::user()->roles == 'customer' || Auth::user()->roles == 'admin')
			<li class="nav-item">
				<a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
				  <span class="menu-title">Wallet</span>
				  <i class="menu-arrow"></i>
				  <i class="mdi mdi-wallet menu-icon"></i>
				</a>
				<div class="collapse" id="ui-basic">
				  <ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('deposit.create') }}" >
							<span class="menu-title" style="{{ (request()->is('withdraw*')) ? 'color:#3e4b5b; font-family:ubuntu-regular, sans-serif' : '' }}">Deposit </span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('withdraw.create') }}" class="nav-link">
							<span class="menu-title" style="{{ (request()->is('deposit*')) ? 'color:#3e4b5b; font-family:ubuntu-regular, sans-serif' : '' }}">Withdraw</span>
						</a>
					</li>
				  </ul>
				</div>
			  </li>
			<li class="nav-item {{ (request()->is('transaction*')) ? 'active' : '' }}">
				<a class="nav-link" href="{{ route('transaction.index') }}">
				  <span class="menu-title">Transaction</span>
				  <i class="mdi mdi-table-large menu-icon"></i>
				</a>
			</li>
			<li class="nav-item {{ (request()->is('ledgar*')) ? 'active' : '' }}">
				<a href="{{ route('ledgar.index') }}" class="nav-link">
					<span class="menu-title">Ledgar</span>
					<i class="mdi mdi-book-open-page-variant menu-icon"></i>
				</a>
			</li>
			@endif
			
		  </ul>
		</nav>