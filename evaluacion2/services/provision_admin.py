from .main import conn, hash_password
import os, secrets, sqlite3
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
        print("Cuenta administradora actualizada")
    else:
        c.execute("INSERT INTO users VALUES(?,?,?,?,?)",(str(uuid4()),email,hash_password(password,salt),salt,"admin"))
        print("Cuenta administradora creada")
