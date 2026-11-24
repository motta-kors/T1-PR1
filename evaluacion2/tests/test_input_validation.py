import os
import httpx

BASE = os.getenv('BASE_URL', 'http://127.0.0.1:8000/api/v1').rstrip('/')

def test_catalogue_remains_public():
    response = httpx.get(f'{BASE}/products', timeout=10)
    assert response.status_code == 200
    assert isinstance(response.json(), list)

def test_order_rejects_client_supplied_price():
    import uuid
    email = f'gelato-{uuid.uuid4().hex}@example.test'
    password = 'TestGelato12345!'
    with httpx.Client(timeout=10) as client:
        response = client.post(f'{BASE}/auth/register', json={'email': email, 'name': 'Cliente Gelato', 'password': password})
        assert response.status_code == 201
        response = client.post(f'{BASE}/auth/login', json={'email': email, 'password': password})
        assert response.status_code == 200
        token = response.json()['access_token']
        response = client.post(f'{BASE}/orders', headers={'Authorization': f'Bearer {token}'}, json={'product_id': str(uuid.uuid4()), 'quantity': 1, 'price': 1})
        assert response.status_code == 422
