// routes/standar.js
const express = require('express');
const router = express.Router();
const pool = require('../db');

// DELETE endpoint untuk hapus standar
router.delete('/standar/:id', async (req, res) => {
const { id } = req.params;
try {
    const result = await pool.query('DELETE FROM a_standar WHERE id_standar = $1 RETURNING *', [id]);
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
