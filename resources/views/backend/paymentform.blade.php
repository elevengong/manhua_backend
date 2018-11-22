<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>online payment</title>
</head>
<body>
<form action="/paymentpage" method="post" name="alidirect" accept-charset="UTF-8" onsubmit="document.charset='UTF-8'">
    {{csrf_field()}}
    <input type="hidden" name="optEmail" value="{{$account->account}}">
    <input type="hidden" name="payAmount" value="{{$order_money}}">
    <input type="hidden" name="title" value="{{$order_no}}" />
</form>
<script>document.alidirect.submit();</script>
</body>
</html>