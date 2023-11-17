@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                        <div class="data-range">
                            <form class="form" method="post" action="{{route('report..submit')}}" >
                                @csrf
                                <div class="row">
                                    <div class="col">
                                            <input type="text" name="starting_date" class="form-control date" placeholder="Start Date">
                                    </div>
                                    <div class="col">
                                            <input type="text" name="ending_date" class="form-control date" placeholder="End Date">
                                    </div>
                                    <div class="mt-1">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endrole
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
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
                                    <th scope="col">Action</th>
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
                                        <td>{{($transaction['is_vat_inclusive']==1)?"Yes":"No"}}</td>
                                        <td>{{$transaction['status']}}</td>
                                        <td>
                                            <div>
                                                <a class="btn btn-success"
                                                   href="{{route('payment..create',['id'=>$transaction['id']])}}">Add
                                                    Payment</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Not Record Found</td>
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
        $("input[type='text']").datepicker({
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            format: 'dd/mm/yyyy',
        }).on('changeDate', function(selected){
            updateDate($(this).closest('form').find('input:text'), selected);
        });
        function updateDate(inputs, selected){
            console.log($(inputs[0]).val());
            var minDate = new Date(selected.date.valueOf());
            $(inputs[1]).datepicker('setStartDate', minDate);
            $(inputs[0]).datepicker('setEndDate', minDate);
        }
    </script>
@endsection
