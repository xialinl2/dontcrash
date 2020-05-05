DROP PROCEDURE IF EXISTS development1.accident_alert_proc;
CREATE PROCEDURE development1.`accident_alert_proc`(IN p_rd_no VARCHAR(50),
 OUT x_err_msg VARCHAR(500))
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE user VARCHAR(100) DEFAULT "";
	
	-- declare cursor for all users
	DEClARE curUsers 
		CURSOR FOR 
			SELECT username FROM users
			WHERE rcv_alert = 'Y';
			
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
		
	-- declare EXIT handler		
	DECLARE EXIT handler 
		FOR SQLEXCEPTION 
		BEGIN
		ROLLBACK;
		SET x_err_msg = "Error - SQLException occurred";
		END;		

	OPEN curUsers;
	
	getUsers: LOOP
		FETCH curUsers INTO user;
		IF finished = 1 THEN 
			LEAVE getUsers;
		END IF;
		-- Insert alert
		INSERT INTO notification (username, rd_no)
		VALUES ( user , p_rd_no);		
	END LOOP getUsers;
	CLOSE curUsers;
	SET x_err_msg = "Success";
END;