DELIMITER $$
CREATE FUNCTION get_idkrs_bynim(nim_mhs varchar(15), th_ajaran varchar(5))
RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE idkrs_d INT;
SELECT idkrs INTO idkrs_d FROM simkrs WHERE nim = nim_mhs AND
thajaran = th_ajaran;
RETURN idkrs_d;
END$$
DELIMITER ;

SELECT get_idkrs_bynim('102130232', '20111');
/* Digunakan untuk menampilkan FUNCTION 2x*/
SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE 
ROUTINE_TYPE = "FUNCTION" AND ROUTINE_SCHEMA = "akademik";

/* Digunakan untuk menghapus FUNCTION */
DROP FUNCTION get_idkrs_bynim

DELIMITER $$
CREATE PROCEDURE get_idkrs_bykelas(p_idkelas int)
RETURNS int(11)
    DETERMINISTIC
BEGIN
SELECT idkrs FROM simambilmk WHERE id_kelas_dosen = p_idkelas;
END$$
DELIMITER ;