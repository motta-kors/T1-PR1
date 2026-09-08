const express = require('express');
const cors = require('cors');
const mongoose = require('mongoose');
const { ApolloServer, gql } = require('apollo-server-express');
const Producto = require('./models/producto');

// Conexión a MongoDB local
mongoose.connect('mongodb://127.0.0.1:27017/gelatoDB')
    .then(() => console.log('Conectado a MongoDB (gelatoDB)'))
    .catch(err => console.error('Error de conexión a MongoDB:', err));

// Definición de tipos GraphQL
const typeDefs = gql`
    type Producto {
        id: ID!
        nombre: String!
        descripcion: String
        precio: Float!
        formato: String
        imagenUrl: String
    }

    input ProductoInput {
        nombre: String!
        descripcion: String
        precio: Float!
        formato: String
        imagenUrl: String
    }

    type Alert {
        message: String!
    }

    type Query {
        getProductos: [Producto]
        getProductoById(id: ID!): Producto
    }

    type Mutation {
        addProducto(input: ProductoInput!): Producto
        updProducto(id: ID!, input: ProductoInput!): Producto
        delProducto(id: ID!): Alert
    }
`;

// Resolvers
const resolvers = {
    Query: {
        async getProductos() {
            return await Producto.find();
        },
        async getProductoById(_, { id }) {
            return await Producto.findById(id);
        }
    },
    Mutation: {
        async addProducto(_, { input }) {
            const nuevoProducto = new Producto(input);
            return await nuevoProducto.save();
        },
        async updProducto(_, { id, input }) {
            return await Producto.findByIdAndUpdate(id, input, { new: true });
        },
        async delProducto(_, { id }) {
            await Producto.findByIdAndDelete(id);
            return { message: "Producto eliminado exitosamente" };
        }
    }
};

async function startServer() {
    const app = express();
    app.use(cors());

    const apolloServer = new ApolloServer({ typeDefs, resolvers });
    await apolloServer.start();
    apolloServer.applyMiddleware({ app, path: '/graphql' });

    app.listen(8090, () => {
        console.log("Servidor GraphQL corriendo en http://localhost:8090/graphql");
    });
}

startServer();