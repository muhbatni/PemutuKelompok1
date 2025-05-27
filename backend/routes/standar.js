// routes/standar.js
const express = require('express');
const router = express.Router();
const pool = require('../db');

// GET endpoint untuk ambil semua standar
router.get('/standar', async (req, res) => {
    try {
        const result = await pool.query('SELECT * FROM a_standar ORDER BY id ASC');
        res.json(result.rows);
    } catch (err) {
        console.error(err);
        res.status(500).json({error: 'Terjadi kesalahan pada server', message: err.message});
    }
});

// GET endpoint untuk ambil standar berdasarkan ID
router.get('/standar/:id', async (req, res) => {
    try{
        const result = await pool.query('SELECT * FROM a_standar WHERE id = $1', [req.params.id]);
        if (result.rowCount === 0) return res.status(404).json({ message: 'Standar tidak ditemukan' });
        res.json(result.rows[0]);
    } catch (err) {
        console.error(err);
        res.status(500).json({error: 'Terjadi kesalahan pada server', message: err.message});
    }
})

// POST endpoint untuk tambah standar
router.post('/standar', async (req, res) => {
    const { nama_standar, deskripsi } = req.body;
    try {
        const result = await pool.query(
            'INSERT INTO a_standar (nama_standar, deskripsi) VALUES ($1, $2) RETURNING *',
            [nama_standar, deskripsi]
        );
        res.status(201).json(result.rows[0]);
    } catch (err) {
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
});

// PUT endpoint untuk update standar
router.put('/standar/:id', async (req, res) => {
    const { nama_standar, deskripsi } = req.body;
    try {
        const result = await pool.query(
            'UPDATE a_standar SET nama_standar = $1, deskripsi = $2 WHERE id = $3 RETURNING *',
            [nama_standar, deskripsi, req.params.id]
        );
        if (result.rowCount === 0) return res.status(404).json({ message: 'Standar tidak ditemukan' });
        res.json(result.rows[0]);        
    } catch (err) {
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
})

// DELETE endpoint untuk hapus standar
router.delete('/standar/:id', async (req, res) => {
const { id } = req.params;
try {
    const result = await pool.query('DELETE FROM a_standar WHERE id = $1 RETURNING *', [id]);
    if (result.rowCount === 0) {
        return res.status(404).json({ message: 'Standar tidak ditemukan' });
    }
    res.json({ message: 'Standar berhasil dihapus', data: result.rows[0] });
    } catch (err) {
        console.error(err);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
    }
});

module.exports = router;