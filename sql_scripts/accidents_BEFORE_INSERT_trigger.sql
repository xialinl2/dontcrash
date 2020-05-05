CREATE DEFINER=`root`@`localhost` TRIGGER `development1`.`accidents_BEFORE_INSERT` BEFORE INSERT ON development1.accidents FOR EACH ROW
BEGIN
    DECLARE rdno_new varchar(50);
   
    select CONCAT('NW', MAX(SUBSTRING(RD_NO,3))+1)
    INTO rdno_new
    FROM accidents 
    WHERE RD_NO like 'NW%%';
    
    IF(rdno_new IS NULL) THEN
		SET rdno_new := 'NW100001';
	END IF;
    
    SET NEW.RD_NO = rdno_new;
END;