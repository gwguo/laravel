<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016092600603244",

    //商家ID。
    'seller_id' => "2088102177410261",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAl/BhWKp5ecHFZxv+NYFvbBLNatRKkB4XqaMCPa9uN+v8ubMZn7W2hBCXmNXC0dUwOqlSni2fr3EE/5a9xSIXnjyMxIEmBMOGg6y4fZ5hcp6fGJ4lyhUmrgDKBK1wncD9abc5MZiJQu3a6WrlKIgJLEC9wTMgynNsDkeuChWRQrRFBpZXtvXzpI4ANZnHA53ABhGFl2AwsPBrB2x+OxyO+LxBVEe2Fv4cEsxasWPYMqFIVNrdbzkkb/zr6MADFDRwyTkwkGipM/jchh4Q9WtVbfhzReMXOfJVZynWyM2Fc54d3fLTkVK/H7v25xW6NbZW6Igwa61O8wWZEK7hx0geLQIDAQABAoIBAAG5kOFYzhg7wunwv2oMFh+79ukHj/Ei5lHer9/TZgTsgOn6xoexoGjPZ2ksxBFtwiZoVa/GBNIRDmV4aJ8cS/hX56EzdiMHtTc5dr62VZTfiB7XbMZmhxHioGh9L5Ia5sWUdunBOY2w9ZNAy2kyYihGc+EFm5GwzcE7vxYOOJ/xN3ymgNx1g2G6yq9RhwWNW5pu/twDo2qwnmU7POCfSMt6yRyc66i3H0YbtSOT3IGOr7iObLr5m0Gx7ZlS/js3oIQRj6b+8tFjhjyeGq0ZA1+g2r4sufXF1f0+6zeMwA0/cn56zo534H6pj4l8F7mRBs0CKOBDLUNbIClr9GluaGECgYEAymuZr/UHQpkLQp44NTa5z+Bo8N+J5DNmh1qnNMK1RadqTZlO/wZU92MdJJ59986563v/TdabBr0aD7nH+p0Tqn4XyIMpeASv8m+ue+9cU7m0TOqPbKh8WUJ4pr5pDkRJTt2Yk9xGpjliq1XPe2A1WkFbgiA4An53X93DpGfBE6cCgYEAwCgQx8U+kwaiQP6IraTYh53h8UYeEIGny6PzW2k1QBvJfZJbt+DodXea0zkXZWhPhmXh//mIs/XrXHDUZqwqgDRk8X6Wp28qw4BMCkmbO0o1kguudWg9ov836P9kmkhHIkualJoPNO3mTUWz78+9a2/KT961dkAe585n2y0CSgsCgYEAtVcgIBqLnoYtKElGYaXdYPXSDbi1d9L0j14PXZzxeK069rnZo26wv8/zU9MJVu/Eb8puNfWEfMz8hAoTtdjyvVKpS+D1TaglWDPlRPJy7C75785THyzx+aUrIXaD91wFsLmk7xHv2Qqf8o61ifnu0iSrLjBe/Rz/JMsvciHhPxECgYAMVQXurDv915kmLq+65S94VKuhfmyDhq6sJRODNFdUi/P8eR4lyOtiTpDDKZDU00L3TyaX9P3O/uNiBWO8SyRXIgWwcf1dNYc7EMrQhjTOM08I1nMV2eDKyzJdY7ajKCxYiR2cl96N+Q6kuup3Y4+2i3AifBqNQkQ5gEeuC09wTQKBgFxbPRBoiRxQmbjgCXGaJngrMxT7y1Wd08Lafxvjy4qwEffjh/1SOe59LtjONOm2t48T+7nRUATek5OJ9PRHm1V1i0EuQg8HS5b458u6cflY0JgKBDJS46EjaSPPfg7R6mdN+6Bmhp7lAWs9Z3iE4EmAefVcPpQYMOHydGsqndKc",

    //异步通知地址
    'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",

    //同步跳转
    'return_url' => "http://www.wei.com/successPay",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4RaN5m29IzzvEY8OE6ipTXbkeOj0n6hzcX3Rs9JmL/hG8l0LUxhN7eVwlStefq9GbA1XttMg94X52ck4Kl6+T3yjRn94//EjQXc7po49ZxY4ewOA9qbd5NN3vDbFIFgQB+BK6qNkQjx4PgmJ1Les39Jjt/XQoq16O2/X8LN20bMmYBXixSEw08eHpCFHw6mu36OJ8+R3I7G0yn6XYe0IXaHkQJgh48OBUIx6w0FkRvhjvwEJMeb/RBMUB4vVVed9yy+ysAeXxEPIU4jdD8x/0WP9qGfVCRd+mngaSnGyTqbaaeEOUSnw87D/jSgkxAaRYMYBUFl261+3vjGxLlOZAQIDAQAB"
];
?>