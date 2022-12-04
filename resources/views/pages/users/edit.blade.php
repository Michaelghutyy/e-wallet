@extends('layouts.DashboardLayout')

@section('title', 'User')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>

	@section('pageTitle', 'User')
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">
		<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
	</li>
@endsection

@section('pageContent')
	<div class="row">
		<div class="col-12 grid-margin strecth-card">
			<div class="card">
				<div class="card-body">

					<div class="d-flex justify-content-between mb-5">
						<h4 class="card-title">Form User</h4>

						<a href="{{ route('users.index') }}" class="btn btn-gradient-primary btn-rounded btn-fw">Kembali</a>
					</div>

					<form class="forms-sample" action="{{ route('users.update', $data->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="Nama">Nama</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama Barang" value="{{ old('name', $data->name) }}">
						@error('name')
							<div class="text-danger mt-2">
								{{ $message }}
							</div>
						@enderror
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="username" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Masukkan username" value="{{ old('username', $data->username) }}">
						@error('username')
							<div class="text-danger mt-2">
								{{ $message }}
							</div>
						@enderror
						</div>
						<div class="form-group">
							<label for="roles">Roles</label>
							<select class="form-select" name="roles" id="roles">
								<option value="admin" {{ $data->roles == 'admin' ? 'selected' : '' }}>Admin</option>
								<option value="customer" {{ $data->roles == 'customer' ? 'selected' : '' }}>Customer</option>
							</select>
						</div>
						<div class="form-group">
							<label for="Password">Password</label>
							<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password" value="{{ old('password', $data->password) }}">
						@error('password')
							<div class="text-danger mt-2">
								{{ $message }}
							</div>
						@enderror
						</div>

						<div class="form-group">
							<label for="Confirm Password">Confirm Password</label>
							<input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" id="Confirm_password" placeholder="Masukkan Password" value="{{ old('confirm_password', $data->password) }}">
						@error('confirm_password')
							<div class="text-danger mt-2">
								{{ $message }}
							</div>
						@enderror
						</div>
						<div class="row mt-5">
							<div class="col-md-6">
								<button type="submit" class="btn btn-rounded btn-gradient-primary btn-lg form-control">Submit</button>
							</div>
							<div class="col-md-6">
								<button type="reset" class="btn btn-rounded btn-gradient-danger btn-lg form-control">Reset</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection