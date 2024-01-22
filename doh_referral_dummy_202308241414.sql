﻿--
-- Script was generated by Devart dbForge Studio 2022 for MySQL, Version 9.1.21.0
-- Product home page: http://www.devart.com/dbforge/mysql/studio
-- Script date 8/24/2023 2:14:13 PM
-- Server version: 8.0.32
-- Client version: 4.1
--

-- 
-- Disable foreign keys
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Set SQL mode
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Set character set the client will use to send SQL statements to the server
--
SET NAMES 'utf8';

--
-- Set default database
--
USE doh_referral_dummy;

--
-- Drop procedure `doctor_monthly_report`
--
DROP PROCEDURE IF EXISTS doctor_monthly_report;

--
-- Set default database
--
USE doh_referral_dummy;

DELIMITER $$

--
-- Create procedure `doctor_monthly_report`
--
CREATE
DEFINER = 'root'@'localhost'
PROCEDURE doctor_monthly_report (IN date_start varchar(50), IN date_end varchar(50), IN facility_id int, IN transaction_status varchar(50), IN user_level varchar(15))
BEGIN

  IF user_level = 'admin' THEN
    IF transaction_status = 'referred' THEN
      SELECT
        T.value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND act.status = 'referred'
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);

    ELSEIF transaction_status = 'accepted' THEN
      SELECT
        T.value AS value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND (act.status = 'accepted'
        OR act.status = 'admitted'
        OR act.status = 'arrived')
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);

    ELSEIF transaction_status = 'redirected' THEN

      SELECT
        T.value AS value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND (act.status = 'redirected'
        OR act.status = 'rejected')
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);
    END IF;
  ELSE
    IF transaction_status = 'referred' THEN

      SELECT
        T.value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND act.referred_from = facility_id
        AND act.status = 'referred'
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);

    ELSEIF transaction_status = 'accepted' THEN

      SELECT
        T.value AS value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND act.referred_to = facility_id
        AND (act.status = 'accepted'
        OR act.status = 'admitted'
        OR act.status = 'arrived')
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);

    ELSEIF transaction_status = 'redirected' THEN

      SELECT
        T.value AS value
      FROM (SELECT
          DATE(act.date_referred) AS date,
          COUNT(DISTINCT act.code) AS value
        FROM doh_referral_dummy.activity act
        WHERE act.date_referred BETWEEN date_start AND date_end
        AND act.referred_to = facility_id
        AND (act.status = 'redirected'
        OR act.status = 'rejected')
        GROUP BY EXTRACT(YEAR_MONTH FROM act.date_referred)

        UNION

        SELECT
          date,
          0 AS value
        FROM (SELECT
            ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) date
          FROM (SELECT
                   0 t0
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t0,
               (SELECT
                   0 t1
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t1,
               (SELECT
                   0 t2
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t2,
               (SELECT
                   0 t3
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t3,
               (SELECT
                   0 t4
                 UNION
                 SELECT
                   1
                 UNION
                 SELECT
                   2
                 UNION
                 SELECT
                   3
                 UNION
                 SELECT
                   4
                 UNION
                 SELECT
                   5
                 UNION
                 SELECT
                   6
                 UNION
                 SELECT
                   7
                 UNION
                 SELECT
                   8
                 UNION
                 SELECT
                   9) t4) v
        WHERE date BETWEEN date_start AND date_end
        GROUP BY EXTRACT(YEAR_MONTH FROM date)) t
      GROUP BY EXTRACT(YEAR_MONTH FROM t.date);

    END IF;
  END IF;

END
$$

DELIMITER ;

-- 
-- Restore previous SQL mode
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Enable foreign keys
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;