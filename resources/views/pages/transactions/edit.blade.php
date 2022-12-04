@extends('layouts.DashboardLayout')

@section('title', 'Transaction')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>

	@section('pageTitle', 'Transaction')
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
						<h4 class="card-title">Form Transaction</h4>

						<a href="{{ route('transaction.index') }}" class="btn btn-gradient-primary btn-rounded btn-fw">Kembali</a>
					</div>

					<form class="forms-sample" action="{{ route('transaction.update', $dataTransaction->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Name</label>
								<select name="user_id" id="user_id" class="form-select">
								@foreach ($dataUser as $d)
									<option value="{{ $d->id }}" {{ $dataTransaction->user_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
								@endforeach
								</select>
						</div>
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Masukkan amount" value="{{ old('amount', $dataTransaction->amount) }}">
							@error('amount')
								<div class="text-danger mt-2">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="type">Payment Type</label>
							<select name="type" id="type" class="form-select">
								<option value="BCA" {{ $dataTransaction->type == "BCA" ? 'Selected' : ''}}>BCA</option>
								<option value="BNI" {{ $dataTransaction->type == "BNI" ? 'Selected' : ''}}>BNI</option>
								<option value="BRI" {{ $dataTransaction->type == "BRI" ? 'Selected' : ''}}>BRI</option>
								<option value="Maybank" {{ $dataTransaction->type == "Maybank" ? 'Selected' : ''}}>Maybank</option>
								<option value="Mandiri" {{ $dataTransaction->type == "Mandiri" ? 'Selected' : ''}}>Mandiri</option>
								<option value="Permata" {{ $dataTransaction->type == "Permata" ? 'Selected' : ''}}>Permata</option>
							</select>
						</div>
						<div class="form-group">
							<label for="status">Status</label>
							<select name="status" id="status" class="form-select">
								<option value="Success" {{ $dataTransaction->status == "Success" ? 'Selected' : ''}}>Success</option>
								<option value="Pending" {{ $dataTransaction->status == "Pending" ? 'Selected' : ''}}>Pending</option>
								<option value="Failed" {{ $dataTransaction->status == "Failed" ? 'Selected' : ''}}>Failed</option>
							</select>
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