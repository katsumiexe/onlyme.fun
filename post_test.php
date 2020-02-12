<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="./js/jquery-3.4.1.min.js"></script>
<script>
$(function(){ 

$('#api').submit();

/*
    $.ajax({
        type: "POST",
        dataType: "jsonp",
        url:"https://api.networkprint.jp/rest/webapi/v2",
        crossDomain: true,
        data:{'M':'loginForGuest2','api_ver':'2.7','app_key':'85B35DD2-7B07-4560-A04B-C564425DDFE8'}
    })
    .done(function(data){
        console.log(data)
    });
*/

});
</script>
</head>
<body>

<form id="api" action="https://api.networkprint.jp/rest/webapi/v2" method="post">
    <input type="hidden" name="M" value="loginForGuest2">
    <input type="hidden" name="api_ver" value="2.7">
    <input type="hidden" name="app_key" value="85B35DD2-7B07-4560-A04B-C564425DDFE8">
<button type="submit">SET</button>
</form>


POST https://api.networkprint.jp/rest/webapi/v2 HTTP/1.1 Content-Type: application/x-www-form-urlencoded; charset=UTF-8 
M=loginForGuest2
&api_ver=2.7
&app_key=85B35DD2-7B07-4560-A04B-C564425DDFE8

https://api.networkprint.jp/rest/webapi/v2?M=loginForGuest2&api_ver=2.7&app_key=85B35DD2-7B07-4560-A04B-C564425DDFE8&timeout=5

https://api.networkprint.jp/rest/webapi/v2?M=loginForGuest2&api_ver=2.7

Content-Type: application/x-www-form-urlencoded; charset=UTF-8 

</body>
</html>



