<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <td>Driver Name</td>
            <td>{{$driverBill->full_name}}</td>
        </tr>
        <tr>
            <td>Bill From</td>
            <td>{{$driverBill->start_date }}</td>
        </tr>
        <tr>
            <td>Bill To</td>
            <td>{{$driverBill->end_date }}</td>
        </tr>
        <tr>
            <td>Bill Charge Option</td>
            <td>{{ $driverBill->bill_charge_title }}</td>
        </tr>
        <tr>
            <td>Bill Charge Sub Option</td>
            <td>{{$driverBill->option_value_name }}</td>
        </tr>
        <tr>
            <td>Bill Ammount</td>
            <td>{{$driverBill->amount }}</td>
        </tr>
        <tr>
            <td>Payment Status</td>
            @if($driverBill->payment_status==1)
            <td>{{'Free'}}</td>
            @elseif($driverBill->payment_status==2)
            <td>{{'Paid'}}</td>
            @elseif($driverBill->payment_status==3)
            <td>{{'Pending'}}</td>
            @endif
        </tr>

    </table>
</div>