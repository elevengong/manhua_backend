<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>online payment</title>
</head>
<body>
<form action="/alidirectV2/" method="post" name="alidirect" accept-charset="gb2312" onsubmit="document.charset='gb2312'">
    <input type="hidden" name="optEmail" value="{{$account->account}}">
    <input type="hidden" name="payAmount" value="{{$order_money}}">
    <input type="hidden" name="title" value="{{$order_no}}" />
</form>
<script>//document.alidirect.submit();</script>
</body>
</html>