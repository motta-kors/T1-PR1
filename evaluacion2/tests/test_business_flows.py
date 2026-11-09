"""Flujos funcionales de la Evaluación 2. Requieren servicios levantados.
Las pruebas de administrador usan credenciales creadas explícitamente:
ADMIN_EMAIL y ADMIN_PASSWORD, nunca contraseñas versionadas.
"""
import os
from uuid import uuid4
import pytest
from test_integration import call

def account():
    data={"email":f"sample-{uuid4().hex}@example.test","name":"Persona ficticia","password":"TestPassword2026!"}
    assert call("POST","/api/v1/auth/register",json=data).status_code==201
    r=call("POST","/api/v1/auth/login",json={"email":data["email"],"password":data["password"]})
    assert r.status_code==200
    return r.json()["access_token"]

def admin_token():
    email=os.getenv("ADMIN_EMAIL")
    password=os.getenv("ADMIN_PASSWORD")
    if not email or not password:
        pytest.skip("Provisione administrador y exporte ADMIN_EMAIL/ADMIN_PASSWORD")
    r=call("POST","/api/v1/auth/login",json={"email":email,"password":password})
    assert r.status_code==200,r.text
    return r.json()["access_token"]

def test_ajeno_admin_y_stock():
    admin=admin_token()
    user_a,user_b=account(),account()
    created=call("POST","/api/v1/products",admin,json={"name":"Producto de prueba","price":2500,"stock":3,"active":True})
    assert created.status_code==201,created.text
    pid=created.json()["id"]
    r=call("POST","/api/v1/orders",user_a,json={"product_id":pid,"quantity":2})
    assert r.status_code==201,r.text
    oid=r.json()["id"]
    assert r.json()["total"]==5000
    assert call("GET","/api/v1/orders/"+oid,user_b).status_code==403
    assert call("GET","/api/v1/orders/"+oid,user_a).status_code==200
    assert call("POST","/api/v1/payments/"+oid,user_b,json={}).status_code==403
    assert call("POST","/api/v1/orders",user_b,json={"product_id":pid,"quantity":2}).status_code==409
    cancelled=call("POST","/api/v1/orders/"+oid+"/cancel",user_a,json={})
    assert cancelled.status_code==200,cancelled.text
    assert cancelled.json()["status"]=="cancelled"
    assert call("POST","/api/v1/orders/"+oid+"/cancel",user_a,json={}).status_code==409
    product=call("GET","/api/v1/products/"+pid).json()
    assert product["stock"]==3
    assert call("DELETE","/api/v1/products/"+pid,admin).status_code==200

def test_sandbox_payment_idempotence():
    admin=admin_token()
    user=account()
    item=call("POST","/api/v1/products",admin,json={"name":"Pago demo","price":100,"stock":2,"active":True})
    assert item.status_code==201
    pid=item.json()["id"]
    order=call("POST","/api/v1/orders",user,json={"product_id":pid,"quantity":1})
    assert order.status_code==201
    oid=order.json()["id"]
    assert call("POST","/api/v1/payments/"+oid,user,json={}).status_code==200
    assert call("POST","/api/v1/payments/"+oid,user,json={}).status_code==200
    paid=call("POST","/api/v1/sandbox/confirm/"+oid,admin,json={})
    assert paid.status_code==200,paid.text
    paid_again=call("POST","/api/v1/sandbox/confirm/"+oid,admin,json={})
    assert paid_again.status_code==200,paid_again.text
    assert paid_again.json()["idempotent"] is True
    assert call("GET","/api/v1/orders/"+oid,user).json()["status"]=="paid"
    assert call("POST","/api/v1/orders/"+oid+"/cancel",user,json={}).status_code==409
    assert call("DELETE","/api/v1/products/"+pid,admin).status_code==200

def test_graphql_limits():
    user=account()
    assert call("POST","/api/v1/graphql",user,json={"query":"{ __schema { types { name } } }"}).status_code==400
    deep="{ myOrders { product { id } } }"
    r=call("POST","/api/v1/graphql",user,json={"query":deep})
    assert r.status_code==200 and "errors" not in r.json()
    too_many="{ "+("myOrders { id } "*45)+"}"
    assert call("POST","/api/v1/graphql",user,json={"query":too_many}).status_code==400

def test_validation_and_routing():
    assert call("GET","/api/v1/products/../../private").status_code in (404,400)
    assert call("POST","/api/v1/products",json={"name":"Sin sesión","price":20,"stock":3}).status_code==401
    assert call("POST","/api/v1/auth/register",json={"email":"bad","name":"x","password":"weak"}).status_code==422
