@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Transaction</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('transaction..store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="amount"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}</label>
                                <div class="col-md-6">
                                    <input id="amount" type="number" step="0.01"
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
                                <label for="select-payer"

                                       class="col-md-4 col-form-label text-md-end">{{ __('Select Payer') }}</label>
                                <div class="col-md-6">
                                    <select name="payer" class="form-select @error('payer') is-invalid @enderror " id="select-payer">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->email}}</option>
                                        @endforeach
                                    </select>
                                    @error('payer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="due_on" class="col-md-4 col-form-label text-md-end">{{ __('Due On') }}</label>
                                <div class="col-md-6">
                                    <input id="due_on" type="datetime-local" class="form-control @error('due_on') is-invalid @enderror" name="due_on" required autocomplete="due_on">
                                    @error('due_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="vat" class="col-md-4 col-form-label text-md-end">{{ __('VAT %') }}</label>
                                <div class="col-md-6">
                                    <input id="vat" type="text" class="form-control @error('vat') is-invalid @enderror" name="vat" required autocomplete="vat">
                                    @error('vat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="is_vat_inclusive" class="col-md-4 col-form-label text-md-end">{{ __('Is VAT inclusive') }}</label>
                                <div class="col-md-6 mt-2 ">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_vat_inclusive"id="is_vat_inclusive1" value="yes" checked>
                                        <label class="form-check-label" for="is_vat_inclusive1">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_vat_inclusive"id="is_vat_inclusive2" value="no">
                                        <label class="form-check-label" for="is_vat_inclusive2">
                                            No
                                        </label>
                                    </div>
                                    @error('is_vat_inclusive')
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
    </div>
@endsection
