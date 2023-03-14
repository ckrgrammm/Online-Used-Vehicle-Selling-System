<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="/payment" method="get">
  @csrf
  <input type="text" name="orderId" value="3">
  <input type="submit" value="Page">
</form>


</body>
</html>

