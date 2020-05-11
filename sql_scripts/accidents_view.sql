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
    
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `accidents_predict` AS 
SELECT
    `a`.`RD_NO` AS `RD_NO`,
    `a`.`CRASH_HOUR` AS `CRASH_HOUR`,
    `a`.`CRASH_DAY_OF_WEEK` AS `CRASH_DAY_OF_WEEK`,
    `a`.`CRASH_MONTH` AS `CRASH_MONTH`,
    `a`.`LATITUDE` AS `LATITUDE`,
    `a`.`LONGITUDE` AS `LONGITUDE`,
    `w`.`weather` AS `WEATHER`,
    `l`.`LIGHTING` AS `LIGHTING`,
    `a`.`ROADWAY_SURFACE_COND` AS `ROADWAY_SURFACE_COND`,
    `a`.`STREET_NAME` AS `STREET_NAME`,
    `loc`.`COMMUNITY_SIDE` AS `COMMUNITY_SIDE`
FROM
    (
        (
            (
                `dontcrash_db`.`accidents` `a`
            JOIN `dontcrash_db`.`weather` `w`
            )
        JOIN `dontcrash_db`.`light_condition` `l`
        )
    JOIN `dontcrash_db`.`location` `loc`
    )
WHERE
    (
        (YEAR(`a`.`CRASH_DATE`) = 2017) AND(MONTH(`a`.`CRASH_DATE`) < 12) AND(`a`.`WID` = `w`.`WID`) AND(`a`.`LID` = `l`.`LID`) AND(
            `a`.`LOCATION_ID` = `loc`.`LOCATION_ID`
        )
    )
