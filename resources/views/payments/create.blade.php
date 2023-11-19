@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Payment</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('payment..store',['id'=>$transactionId]) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="amount"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}</label>
                                <div class="col-md-6">
                                    <input id="amount" step="0.01" type="number"
                                           class="form-control @error('amount') is-invalid @enderror" name="amount"
                                           value="{{ old('amount') }}" required autocomplete="amount" autofocus>
                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="paid_on"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Paid On') }}</label>
                                <div class="col-md-6">
                                    <input id="paid_on" type="datetime-local"
                                           class="form-control @error('paid_on') is-invalid @enderror" name="paid_on"
                                           required autocomplete="paid_on">
                                    @error('paid_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="details"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Details') }}</label>
                                <div class="col-md-6">
                                    <input id="details" type="text"
                                           class="form-control @error('details') is-invalid @enderror" name="details"
                                           autocomplete="details">
                                    @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Payment Logs</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Transaction Id</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payed On</th>
                                <th scope="col">Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($paymentLists as $paymentList)
                                <tr>
                                    <td>{{$paymentList->id}}</td>
                                    <td>{{$paymentList->transaction_id}}</td>
                                    <td>{{$paymentList->amount}}</td>
                                    <td>{{$paymentList->paid_on}}</td>
                                    <td>{{($paymentList->details)? $paymentList->details : "-"}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Not Record Found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
