@extends('layouts.DashboardLayout')

@section('title', 'Withdraw')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>

	@section('pageTitle', 'Withdraw')
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

					<div class="d-flex justify-content-between mb-2">
						<h4 class="card-title">Withdraw</h4>

						<a href="{{ route('transaction.index') }}" class="btn btn-gradient-primary btn-rounded btn-fw">Kembali</a>
					</div>

					<div class="row  mb-3 mt-5">
						<div class="col">
							<div class="card text-center" style="align-self: center">
								<div class="card-body">
									<img src="{{ '/images/payment/'.$type.'.png' }}" alt="BCA" style="max-height: 150px; max-width: 150px;">
								  <h3 class="card-title"> {{ $type }} Virtual Account </h3>
								</div>
							</div>
						</div> 
					</div>

					<form class="forms-sample" action="{{ route('withdraw.store') }}" method="POST">
						@csrf
						
						<input type="hidden" name="wallet_type" value="withdraw">
						<input type="hidden" name="type" value="{{ $type }}">
						
						@if (Auth::user()->roles == 'admin')
						<div class="form-group">
							<label for="name">User Name</label>
								<select name="user_id" id="user_id" class="form-select">
								@foreach ($dataUser as $d)
									<option value="{{ $d->id }}">{{ $d->name }}</option>
								@endforeach
								</select>
						</div>
						@elseif(Auth::user()->roles == 'customer')
							<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
						@endif
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Masukkan amount" value="{{ old('amount') }}">
							@error('amount')
								<div class="text-danger mt-2">
									{{ $message }}
								</div>
							@enderror
						</div>
	

						<div class="row mt-5">
							<div class="col-md-6">
								<button type="submit" class="btn btn-gradient-primary btn-rounded btn-lg form-control">Submit</button>
							</div>
							<div class="col-md-6">
								<button type="reset" class="btn btn-block btn-gradient-danger btn-rounded btn-lg form-control">Reset</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection