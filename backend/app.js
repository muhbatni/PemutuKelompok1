// app.js
const express = require('express');
const app = express();
const standarRoutes = require('./routes/standar');
const cors = require('cors');

app.use(cors()); // Supaya frontend PHP bisa akses API Node.js
app.use(express.json());

// Semua route diletakkan di bawah prefix /api
app.use('/api', standarRoutes);

app.listen(3000, () => {
    console.log('API Node.js berjalan di http://localhost:3000');
});
