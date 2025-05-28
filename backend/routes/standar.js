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
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
});

// GET endpoint untuk ambil standar berdasarkan ID
router.get('/standar/:id', async (req, res) => {
    try {
        const result = await pool.query('SELECT * FROM a_standar WHERE id = $1', [req.params.id]);
        if (result.rowCount === 0) return res.status(404).json({ message: 'Standar tidak ditemukan' });
        res.json(result.rows[0]);
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
})

// POST endpoint untuk tambah standar
router.post('/standar', async (req, res) => {
    const { id_parent, nama, dokumen, is_aktif } = req.body; // Fixed: dokumen (bukan dokument)
    try {
        const result = await pool.query(
            'INSERT INTO a_standar (id_parent, nama, dokumen, is_aktif) VALUES ($1, $2, $3, $4) RETURNING *',
            [id_parent, nama, dokumen, is_aktif]
        );
        res.status(201).json(result.rows[0]);
    } catch (err) {
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
});

// PUT endpoint untuk update standar
router.put('/standar/:id', async (req, res) => {
    const { nama, dokumen, is_aktif, id_parent } = req.body;

    try {
        const result = await pool.query(
            `UPDATE a_standar SET nama = $1, dokumen = $2, is_aktif = $3, id_parent = $4 WHERE id = $5 RETURNING *`,
            [nama, dokumen, is_aktif, id_parent, req.params.id]
        );

        if (result.rowCount === 0) {
            return res.status(404).json({ message: 'Standar tidak ditemukan' });
        }

        res.json(result.rows[0]);
    } catch (err) {
        res.status(500).json({ error: 'Terjadi kesalahan pada server', message: err.message });
    }
});

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

router.get('/standar/download/:filename', (req, res) => {
    const filename = req.params.filename;
    const filePath = path.join(__dirname, '../writable/uploads/', filename);

    res.download(filePath, filename, (err) => {
        if (err) {
            console.error("Download error:", err);
            res.status(500).json({ error: 'Gagal mendownload file', message: err.message });
        }
    });
});

module.exports = router;