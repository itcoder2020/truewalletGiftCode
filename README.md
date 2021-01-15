# TrueWallet GiftCode

## Installation

```php
include "trueWallet.php";
$api = new trueWallet("");//phone

```

## Example
```php
echo $api->toPup("https://gift.truemoney.com/campaign/?v=hraA6JA1rpynajcpnc");//link ex.https://gift.truemoney.com/campaign/?v=hraA6JA1rpynajcpnc
```
## Response
```json 
{ "statusCode":200, "message":"success", "error":null, "data":[ { "mobile":"096-xxx-0967", "update_date":1610698165000, "amount_baht":"50.00", "full_name":"ภานุพงศ์ ***" } ] }
```
#### [git : https://github.com/jkjknm123]


