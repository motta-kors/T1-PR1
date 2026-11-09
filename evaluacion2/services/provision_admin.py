from .main import conn, hash_password
import os, secrets, sqlite3, httpx
from uuid import uuid4

email=os.environ.get("ADMIN_EMAIL","").strip().lower()
password=os.environ.get("ADMIN_PASSWORD","")
if not email or "@" not in email or len(password)<12:
    raise SystemExit("Defina ADMIN_EMAIL y ADMIN_PASSWORD (mínimo 12 caracteres) en el comando de provisión")
salt=secrets.token_hex(16)
with conn() as c:
    row=c.execute("SELECT id FROM users WHERE email=?",(email,)).fetchone()
    if row:
        c.execute("UPDATE users SET hashed=?,salt=?,role='admin' WHERE id=?",(hash_password(password,salt),salt,row["id"]))
        admin_id=row["id"]
        print("Cuenta administradora actualizada")
    else:
        admin_id=str(uuid4())
        c.execute("INSERT INTO users VALUES(?,?,?,?,?)",(admin_id,email,hash_password(password,salt),salt,"admin"))
        print("Cuenta administradora creada")

# La provisión mantiene el perfil correspondiente al usuario administrador.
response=httpx.post("http://clients:8000/profiles",json={"user_id":admin_id,"email":email,"name":"Administrador"},headers={"x-internal-key":os.environ["INTERNAL_SERVICE_KEY"]},timeout=5)
if response.status_code not in (200,201):
    raise SystemExit(f"No fue posible registrar el perfil administrador: HTTP {response.status_code}")
print("Perfil de administrador disponible")
