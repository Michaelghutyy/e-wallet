@extends('layouts.DashboardLayout')

@section('title', 'Deposit')

@section('iconPage')
<i class="mdi mdi-table-large menu-icon"></i>

	@section('pageTitle', 'Deposit')
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
						<h4 class="card-title">Deposit</h4>

                        @if (Auth::user()->roles == "customer")
                            <a href="{{ route('home') }}" class="btn btn-gradient-primary btn-rounded btn-fw">Kembali</a>
                        @else
                            <a href="{{ route('transaction.index') }}" class="btn btn-gradient-primary btn-rounded btn-fw">Kembali</a>
                        @endif
					
					</div>

					<form class="forms-sample" action="{{ route('deposit.paymentProses') }}" method="POST">
						@csrf

                        <div class="row text-center mb-3 mt-5">
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/BCA.png') }}" alt="BCA" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="BCA" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>                                      
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/BNI.png') }}" alt="BNI" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="BNI" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/BRI.png') }}" alt="BRI" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="BRI" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="card " style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/Maybank.png') }}" alt="Maybank" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="Maybank" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/Mandiri.png') }}" alt="Mandiri" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="Mandiri" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body shadow p-3 bg-body rounded">
                                        <img src="{{ asset('images/payment/Permata.png') }}" alt="Permata" style="max-height: 150px; max-width: 150px;">
                                      <h5 class="card-title">
                                        <input type="submit" value="Permata" name="type" class="btn btn-gradient-info btn-rounded form-control"></h5>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                        
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection