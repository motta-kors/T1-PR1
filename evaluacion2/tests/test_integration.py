"""Pruebas HTTP reales: requiere docker compose up --build -d."""
import os
from uuid import uuid4
import httpx

BASE=os.getenv("API_BASE","http://127.0.0.1:8000")
def call(method,path,token=None,**kwargs):
    headers=kwargs.pop("headers",{})
    if token: headers["Authorization"]="Bearer "+token
    return httpx.request(method,BASE+path,headers=headers,timeout=10,**kwargs)

def test_catalogo_anonimo():
    r=call("GET","/api/v1/products")
    assert r.status_code==200
    assert isinstance(r.json(),list)

def test_pedidos_sin_token():
    assert call("GET","/api/v1/orders").status_code==401

def test_gateway_no_expone_rutas_internas():
    assert call("GET","/api/v1/internal/admin").status_code==404

def test_roles_y_graphql():
    user={"email":f"test-{uuid4().hex}@example.test","name":"Usuario ficticio","password":"PasswordTest2026!"}
    r=call("POST","/api/v1/auth/register",json=user)
    assert r.status_code==201,r.text
    login=call("POST","/api/v1/auth/login",json={"email":user["email"],"password":user["password"]})
    assert login.status_code==200,login.text
    token=login.json()["access_token"]
    assert call("GET","/api/v1/me",token).status_code==200
    assert call("POST","/api/v1/products",token,json={"name":"No autorizado","price":100,"stock":1}).status_code==403
    r=call("POST","/api/v1/graphql",token,json={"query":"query { myOrders { id total status product { name } } }"})
    assert r.status_code==200 and not r.json().get("errors")
    assert call("GET","/api/v1/orders",token).status_code==200
    assert call("POST","/api/v1/auth/logout",token,json={}).status_code==200
    assert call("GET","/api/v1/orders",token).status_code==401
