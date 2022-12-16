DELIMITER $$
CREATE TRIGGER after_prod_create
    AFTER INSERT
    ON PROD FOR EACH ROW
BEGIN
    IF new.gabarit IS NULL THEN
        INSERT INTO PROD_DATA(id_code_affaire, id_prod)
        VALUES (new.id_code_affaire, new.id);
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER after_prod_update
    BEFORE UPDATE
    ON PROD FOR EACH ROW
BEGIN
    IF new.gabarit IS NULL AND new.id_statut_etape = 5 AND new.statut = 1 AND new.date_pao IS NULL THEN
        UPDATE PROD_DATA
        SET pao_sent_date = now()
        WHERE PROD_DATA.id_prod = new.id;
        SET new.date_pao = now();
    END IF;
END$$
DELIMITER ;
