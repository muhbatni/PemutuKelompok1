const { Pool } = require('pg');

// Buat koneksi ke PostgreSQL
const db = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'pemutu',
    password: 'admin123',
    port: 5433, // port default PostgreSQL
});

db.connect()
    .then(() => console.log('PostgreSQL Connected...'))
    .catch(err => console.error('Connection error', err.stack));