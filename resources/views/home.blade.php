@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="text-center">
                            <h3>{{ __('Transaction Logs') }}</h3>
                        </div>
                        @role('admin')
                        <div class="float-sm-end">
                            <a href="{{route('transaction..create')}}" class="btn btn-secondary rounded-pill">+ Add
                                Transaction</a>
                        </div>
                        @endrole
                    </div>
                    <div class="card-body">
                        @role('admin')
                        <form class="form" method="post" action="{{route('report..submit')}}">
                            @csrf
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" name="start_date" class="form-control" id="startDate" placeholder="Start Date">
                                </div>
                                <div class="col-5">
                                    <input type="text" name="end_date" class="form-control" id="endDate" placeholder="End Date">
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                        @endrole
                        <div class="row">
                            <table class="table" id="transaction">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payer</th>
                                    <th scope="col">Due Amount</th>
                                    <th scope="col">Due On</th>
                                    <th scope="col">Vat %</th>
                                    <th scope="col">Is Vat Inclusive</th>
                                    <th scope="col">Status</th>
                                    @role('admin')
                                    <th scope="col">Action</th>
                                    @endrole
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction['sr_no']}}</td>
                                        <td>{{$transaction['amount']}}</td>
                                        <td>{{$transaction['payer']}}</td>
                                        <td>{{$transaction['due_amount']}}</td>
                                        <td>{{$transaction['due_on']}}</td>
                                        <td>{{$transaction['vat']}}</td>
                                        <td>{{($transaction['is_vat_inclusive'])}}</td>
                                        <td>{{$transaction['status']}}</td>
                                        @role('admin')
                                        <td>
                                            <div>
                                                <a class="btn btn-success"
                                                   href="{{route('payment..create',['id'=>$transaction['id']])}}">Add
                                                    Payment</a>
                                            </div>
                                        </td>
                                        @endrole

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Not Record Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $("#startDate").datepicker({
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    $("#endDate").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#endDate").datepicker({
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    $("#startDate").datepicker("option", "maxDate", selectedDate);
                }
            });
        });
    </script>
@endsection
