<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <title>Villa Chicken</title>
</head>
<body>
<table bgcolor="#FDFFCC" border="0" cellpadding="5" cellspacing="5" width="500">
    <tr>
        <td>
            <img style="width: 100%" src="http://pe.abcmultinegocios.com/wp-content/uploads/2017/01/villa-chicken-logo1-abcmultinegocios.jpg" alt="">
        </td>
    </tr>
    <tr>
        <td colspan="2">Hola <b>{{ $supplier }},</b></td>
    </tr>
    <tr>
        <td colspan="2">Estamos buscando reabastecernos y necesitamos que nos facilites una cotización por los siguientes productos:</td>
    </tr>
    <tr>
        <td>
            <table border="1" cellpadding="5" cellspacing="0" width="100%" style="width: 100%">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td style="text-align: right;">{{ $product['quantity'] }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">Gracias por la atención brindada.</td>
    </tr>
</table>
</body>
</html>