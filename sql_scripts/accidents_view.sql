CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `accidents_view` AS 
SELECT
    `a`.`RD_NO` AS `RD_NO`,
    `l`.`COMMUNITY_AREA` AS `COMMUNITY_AREA`,
    `a`.`STREET_NO` AS `STREET_NO`,
    `a`.`STREET_NAME` AS `STREET_NAME`,
    `a`.`CRASH_DATE` AS `CRASH_DATE`,
    `w`.`weather` AS `WEATHER`,
    `a`.`DAMAGE` AS `DAMAGE`,
    `a`.`INJURIES_TOTAL` AS `INJURIES_TOTAL`
FROM
    (
        (`accidents` `a`
    JOIN `location` `l`)
    JOIN `weather` `w`
    )
WHERE
    (
        (`a`.`LOCATION_ID` = `l`.`LOCATION_ID`) AND(`a`.`WID` = `w`.`WID`)
    );
