require('dotenv').config();
const { Pool } = require('pg');

console.log('ENV VARS:', {
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  host: process.env.DB_HOST,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT,
});

const pool = new Pool({
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  host: process.env.DB_HOST,
  database: process.env.DB_NAME,
  port: parseInt(process.env.DB_PORT),
});

module.exports = pool;

pool.connect()
.then(() => console.log('PostgreSQL Connected...'))
.catch(err => console.error('Connection error', err.stack));