const express = require("express");
const cors = require("cors");
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");

const app = express();

app.use(cors());
app.use(express.json());

const PORT = 3001;

// Por ahora usamos una clave temporal.
// Más adelante esta clave vendrá desde Vault.
const JWT_SECRET = "clave-secreta-temporal";

// Usuario de prueba.
// Más adelante esto también lo sacaremos de Vault/BD.
const usuario = {
    id: 1,
    email: "admin@ejemplo.com",
    passwordHash: bcrypt.hashSync("123456", 10),
    rol: "admin"
};


// -----------------------------
// LOGIN
// -----------------------------
app.post("/auth/login", async (req, res) => {

    const { email, password } = req.body;

    if (!email || !password) {
        return res.status(400).json({
            message: "Email y password son obligatorios"
        });
    }

    // Comprobar email
    if (email !== usuario.email) {
        return res.status(401).json({
            message: "Credenciales incorrectas"
        });
    }

    // Comprobar password
    const passwordCorrecta = await bcrypt.compare(
        password,
        usuario.passwordHash
    );

    if (!passwordCorrecta) {
        return res.status(401).json({
            message: "Credenciales incorrectas"
        });
    }

    // Crear token
    const token = jwt.sign(
        {
            id: usuario.id,
            email: usuario.email,
            rol: usuario.rol
        },
        JWT_SECRET,
        {
            expiresIn: "1h"
        }
    );

    res.json({
        message: "Login correcto",
        token: token
    });
});


// -----------------------------
// VERIFICAR TOKEN
// -----------------------------
app.get("/auth/verify", (req, res) => {

    const authHeader = req.headers.authorization;

    if (!authHeader) {
        return res.status(401).json({
            message: "Token no enviado"
        });
    }

    const token = authHeader.split(" ")[1];

    try {

        const datos = jwt.verify(token, JWT_SECRET);

        res.json({
            authenticated: true,
            user: datos
        });

    } catch (error) {

        res.status(401).json({
            authenticated: false,
            message: "Token inválido o expirado"
        });
    }
});


// -----------------------------
// SERVIDOR
// -----------------------------
app.listen(PORT, () => {
    console.log(`Auth Service funcionando en http://localhost:${PORT}`);
});