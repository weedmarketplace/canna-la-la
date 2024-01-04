@extends('emails.layout')
@section('content')
<p><h2>Order cancelled</h2></p>
<p>Your order {{$sku}} has been cancelled. If you have any questions or concerns, please contact our support team.</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="{{ route('order', ['hash'=>$hash])}}" target="_blank">View order</a> </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection