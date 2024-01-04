@extends('emails.layout')
@section('content')
<p><h2>Password Recovery Request</h2></p>
<p>It seems like you have requested a password reset for your account. Please click on the link below to create a new password.</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="{{ route('checkRecoveryHash')}}?hash={{$hash}}" target="_blank">Reset Password</a> </td>
            </tr> 
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection
