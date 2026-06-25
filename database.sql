-- ============================================================
-- DATABASE: sistem_buku
-- Sistem Pendataan Buku - UAS Pemrograman Web
-- ============================================================

CREATE DATABASE IF NOT EXISTS sistem_buku;
USE sistem_buku;

CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    pengarang VARCHAR(150) NOT NULL,
    penerbit VARCHAR(150) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data awal (minimal 5 record)
INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, kategori) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 10, 'Novel'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara', 1980, 7, 'Novel'),
('Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 5, 'Teknologi'),
('Atomic Habits', 'James Clear', 'Avery Publishing', 2018, 12, 'Self Help'),
('Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 8, 'Filsafat'),
('The Pragmatic Programmer', 'David Thomas', 'Addison-Wesley', 1999, 4, 'Teknologi'),
('Sapiens', 'Yuval Noah Harari', 'Harper Collins', 2011, 6, 'Sejarah');
