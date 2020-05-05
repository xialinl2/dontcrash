CREATE DEFINER=`root`@`localhost` TRIGGER `dontcrash_db`.`accidents_AFTER_DELETE` AFTER DELETE ON dontcrash_db.accidents FOR EACH ROW
BEGIN
DELETE FROM notification
    WHERE notification.RD_NO = old.RD_NO;
END