ALTER TABLE `pi_master` ADD `update_info` TEXT NULL DEFAULT NULL AFTER `pi_attachment`; 

UPDATE `po_master` SET `po_status` = '1' 
WHERE `po_number` = 'BDWA000879';

DELETE FROM `bd_po_summary` WHERE PO_NUMBER IN (SELECT PO_NUMBER FROM payment_po_amount)

SELECT C.*,(C.stock_quantity+pur_qty-issue_qty-tpm_qty) as ddd 
FROM (SELECT p.product_code,p.product_name,p.main_stock,
  p.stock_quantity,p.department_id, 
(SELECT SUM(pu.quantity) FROM purchase_detail pu
 WHERE p.product_id=pu.product_id AND pu.status!=5) as pur_qty, 
(SELECT IFNULL(SUM(i.quantity),0) FROM item_issue_detail i 
  WHERE p.product_id=i.product_id) as issue_qty, 
(SELECT IFNULL(SUM(t.quantity),0) FROM spares_use_detail t 
  WHERE p.product_id=t.product_id) as tpm_qty,
(SELECT SUM(s.QUANTITY) FROM stock_master_detail s 
  WHERE p.product_id=s.product_id) as stockm
FROM product_info p WHERE p.product_code='B84-H54-W1100-C01'
) as C




SELECT C.*,(issue_qty+stockm) as ddd 
FROM (SELECT a.FIFO_CODE,SUM(a.quantity) as issue_qty, 
(SELECT SUM(s.QUANTITY) FROM stock_master_detail s WHERE a.FIFO_CODE=s.FIFO_CODE) as stockm 
FROM item_issue_detail a WHERE a.product_code='BZE-WJ1-NLST-W01' 
GROUP BY a.FIFO_CODE ) as C;


SELECT C.*,(issue_qty+stockm) as ddd 
FROM (SELECT a.FIFO_CODE,SUM(a.quantity) as issue_qty, 
(SELECT SUM(s.QUANTITY) FROM stock_master_detail s WHERE a.FIFO_CODE=s.FIFO_CODE AND s.TRX_TYPE='ISSUE') as stockm
FROM item_issue_detail a WHERE a.product_code='B71-C40-5G-W01' GROUP BY a.FIFO_CODE ) as C;


-- /////////////////////////////////////////////////////////////////

SELECT FIFO_CODE, SUM(`QUANTITY`) as qty, SUM(`TOTALAMT`) as amount,
SUM(`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` 
WHERE ITEM_CODE='BZE-WJ1-NLST-W01' 
GROUP BY FIFO_CODE


-- ////////////////////////////
-- Stock check
SELECT p.product_code,p.product_id,p.FIFO_CODE,p.quantity,
(SELECT SUM(i.`quantity`) FROM `spares_use_detail` i 
WHERE p.`FIFO_CODE`=i.FIFO_CODE) as issue_qty
FROM purchase_detail p WHERE p.product_id=1131;
  -- /////////////////////
  
  -- /////////////////////////
UPDATE stock_master_detail a
INNER JOIN only_grn_master  b ON (b.FIFO_CODE = a.FIFO_CODE)
SET a.UPRICE = b.UPRICE,a.CRRNCY=b.CRRNCY
WHERE a.TRX_TYPE!='GRN';

UPDATE stock_master_detail a
INNER JOIN purchase_master  b ON (b.purchase_id = a.receive_id)
SET a.po_number = b.po_number
WHERE a.TRX_TYPE!='GRN';



UPDATE
    stock_master_detail sm,
    only_grn_master p
SET
    sm.UPRICE=p.UPRICE,sm.CRRNCY=p.CRRNCY
WHERE sm.FIFO_CODE = p.FIFO_CODE 
AND sm.product_id=p.product_id AND sm.id>=200000 AND sm.id<=205000; 

UPDATE item_issue_detail a
INNER JOIN purchase_detail b ON (b.FIFO_CODE = a.FIFO_CODE)
SET a.unit_price = b.unit_price,a.currency=b.currency
WHERE b.FIFO_CODE = a.FIFO_CODE;


UPDATE
    product_detail_info sm,
    check_code p
SET
    sm.asset_encoding=p.asset_encoding
WHERE sm.ventura_code = p.ventura_code; 
-- ///////////////////
UPDATE `product_status_info` SET `from_location_name`='' WHERE 1;
UPDATE `product_status_info` SET `to_location_name`='' WHERE 1;



UPDATE
    product_status_info sm,
    product_detail_info p
SET
    sm.ventura_code=p.ventura_code
WHERE sm.product_detail_id = p.product_detail_id; 


UPDATE
    product_status_info sm,
    floorline_info p
SET
    sm.to_location_name=p.line_no
WHERE sm.line_id = p.line_id; 

 

UPDATE `product_status_info` SET `to_location_name`=`from_location_name` WHERE 1;

UPDATE `product_status_info` SET `assign_date_time`=`assign_date` WHERE 1;







UPDATE
    spares_use_detail sm,
    purchase_detail p
SET
    sm.unit_price=p.unit_price,sm.currency=p.currency
WHERE sm.FIFO_CODE = p.FIFO_CODE AND sm.product_id=p.product_id; 


UPDATE
    item_issue_detail sm,
    purchase_detail p
SET
    sm.unit_price=p.unit_price,sm.currency=p.currency
WHERE sm.FIFO_CODE = p.FIFO_CODE AND sm.product_id=p.product_id; 
-- ///////////////
UPDATE
    spares_use_detail sm,
    purchase_detail p
SET
    sm.unit_price=p.unit_price,sm.currency=p.currency
WHERE sm.FIFO_CODE = p.FIFO_CODE AND sm.product_id=p.product_id; 
-- ///////////////////////
UPDATE `product_detail_info` SET `machine_price`=19167.5,`currency`='BDT' 
WHERE machine_price =0 AND `product_id`=3019;

UPDATE `product_detail_info` SET `amount_hkd`=machine_price*0.10 WHERE currency='BDT';
UPDATE `product_detail_info` SET `amount_hkd`=machine_price*1.1 WHERE currency='RMB';
UPDATE `product_detail_info` SET `amount_hkd`=machine_price*7.750 WHERE currency='USD';


-- Stock check
 SELECT p.product_code,p.product_name,p.main_stock,p.stock_quantity,
  (SELECT SUM(pu.`quantity`) FROM `purchase_detail` pu 
    WHERE p.`product_id`=pu.product_id AND pu.status!=5) as pur_qty,
  (SELECT SUM(i.`quantity`) FROM `item_issue_detail` i 
    WHERE p.`product_id`=i.product_id) as issue_qty,
  (SELECT SUM(t.`quantity`) FROM `spares_use_detail` t 
    WHERE p.`product_id`=t.product_id) as tpm_qty
  FROM product_info p WHERE p.product_id=1783;
  
-- // Only ZERO PRICE UPDATE////////////////////////

UPDATE
    stock_master_detail sm,
    product_info p
SET
    sm.UPRICE = p.unit_price,
    sm.CRRNCY = p.currency
WHERE
    sm.product_id = p.product_id 
    AND sm.UPRICE=0 
    AND sm.department_id=26 
    AND p.department_id=26; 


UPDATE
    purchase_detail sm,
    product_info p
SET
    sm.unit_price = p.unit_price,
    sm.currency=p.currency
WHERE
    sm.product_id = p.product_id 
    AND sm.unit_price=0 
    AND sm.department_id=26 
    AND p.department_id=26;

-- //////////////////////////

UPDATE
    item_issue_detail sm,
    product_info p
SET
    sm.unit_price = p.unit_price,
    sm.currency=p.currency
WHERE
    sm.product_id = p.product_id 
    AND sm.unit_price=0 
    AND sm.department_id=26 
    AND p.department_id=26; 

-- /////// All product Unit Price Update////

UPDATE
    stock_master_detail sm,
    product_info p
SET
    sm.UPRICE = p.unit_price,
    sm.CRRNCY = p.currency
WHERE
    sm.product_id = p.product_id 
    AND sm.department_id=18 
    AND p.department_id=18; 

-- ////////////////////////

UPDATE
    purchase_detail sm,
    product_info p
SET
    sm.unit_price = p.unit_price,
    sm.currency=p.currency
WHERE sm.product_id = p.product_id 
    AND  sm.department_id=18 
    AND p.department_id=18; 
-- ////////////////
UPDATE
    item_issue_detail sm,
    product_info p
SET
    sm.unit_price = p.unit_price,
    sm.currency=p.currency
WHERE sm.product_id = p.product_id 
    AND sm.department_id=18 
    AND p.department_id=18; 






-- ////////////////////////////////////////////////
-- ////////////////////////////
UPDATE
    store_issue_master sm,
    item_issue_detail p
SET
    sm.unit_price = p.unit_price,
    sm.currency=p.currency
WHERE sm.product_id = p.product_id 
    AND sm.department_id=2 
    AND p.department_id=2; 

-- ///////////////////////////
UPDATE
    purchase_detail sm,
    purchase_master p
SET
    sm.date=p.purchase_date
WHERE sm.purchase_id = p.purchase_id; 

-- ///////////////////////////

CREATE VIEW item_issue_detail_view AS

SELECT issue_id,SUM(amount_hkd) as total_amount_hkd
FROM item_issue_detail GROUP BY issue_id;


CREATE TABLE `pi_master_view` (
`pi_id` bigint(20)
,`pi_no` varchar(100)
,`pi_type` tinyint(4)
,`department_id` int(11)
,`for_department_id` int(11)
,`pi_date` varchar(15)
,`demand_date` varchar(20)
,`new_demand_date` varchar(20)
,`confirmed_date` varchar(15)
,`certified_date` varchar(15)
,`received_date` varchar(20)
,`approved_date` varchar(20)
,`verified_date` varchar(15)
,`pi_status` tinyint(4)
,`reject_note` longtext
,`p_type_name` varchar(100)
,`department_name` varchar(100)
,`verified_name` varchar(60)
);
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pi_master_view`  
AS SELECT `pm`.`pi_id` AS `pi_id`, `pm`.`pi_no` 
AS `pi_no`, `pm`.`pi_type` AS `pi_type`, `pm`.`department_id` 
AS `department_id`, `pm`.`for_department_id` AS `for_department_id`, `pm`.`pi_date` 
AS `pi_date`, `pm`.`demand_date` AS `demand_date`, `pm`.`new_demand_date` 
AS `new_demand_date`, `pm`.`confirmed_date` 
AS `confirmed_date`, `pm`.`certified_date` 
AS `certified_date`, `pm`.`received_date` 
AS `received_date`, `pm`.`approved_date` 
AS `approved_date`, `pm`.`verified_date` 
AS `verified_date`, `pm`.`pi_status` 
AS `pi_status`, `pm`.`reject_note` AS `reject_note`, 
`pt`.`p_type_name` AS `p_type_name`,
 `d`.`department_name` AS `department_name`, 
 `u6`.`user_name` AS `verified_name` 
FROM (((`pi_master` `pm` 
    left join `purchase_type` `pt` on(`pm`.`purchase_type_id` = `pt`.`purchase_type_id`)) 
left join `department_info` `d` on(`pm`.`department_id` = `d`.`department_id`)) 
    left join `user` `u6` on(`u6`.`id` = `pm`.`verified_by`)) ORDER BY `pm`.`pi_id` ASC ;




CREATE VIEW asset_information_view AS
SELECT pd.product_detail_id,pd.ventura_code,pd.asset_encoding,
pd.purchase_date,
pd.machine_price,pd.amount_hkd,pd.it_status,pd.tpm_status,
pd.machine_other,
p.product_name,p.product_code,p.china_name,
c.category_name,
aim.employee_id,
aim.issue_type,aim.issue_date,
d.department_name,
d2.department_name as take_department_name,
e.employee_name,ml.mlocation_name,l.location_name,
pd.other_description,pd.currency
FROM  product_detail_info pd 
INNER JOIN department_info d ON(pd.department_id=d.department_id)
INNER JOIN product_info p ON(p.product_id=pd.product_id)
INNER JOIN category_info c ON(p.category_id=c.category_id)
LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.take_over_status=1)
LEFT JOIN location_info l ON(aim.location_id=l.location_id)
LEFT JOIN main_location ml ON(l.mlocation_id=ml.mlocation_id)
LEFT JOIN department_info d2 ON(aim.take_department_id=d2.department_id)
LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
WHERE  1
GROUP BY pd.product_detail_id
ORDER BY pd.department_id ASC


CREATE VIEW item_issue_detail_view AS
SELECT issue_id,SUM(amount_hkd) as total_amount_hkd
FROM item_issue_detail GROUP BY issue_id;

CREATE VIEW spares_use_detail_view AS
SELECT spares_use_id,
SUM(amount_hkd) as total_amount_hkd
FROM spares_use_detail GROUP BY spares_use_id;
-- ///////////////////
UPDATE
    store_issue_master sm,
    item_issue_detail_view a
SET
    sm.total_amount_hkd = a.total_amount_hkd
WHERE
    sm.issue_id = a.issue_id 
-- ////////////////////
UPDATE
    spares_use_master sm,
    spares_use_detail_view a
SET
    sm.total_amount_hkd = a.total_amount_hkd
WHERE
    sm.spares_use_id = a.spares_use_id 

UPDATE `stock_master_detail` SET `TOTALAMT`=(QUANTITY*UPRICE) WHERE FIFO_CODE='2209141408530002';
UPDATE `purchase_detail` SET  `amount`=(`quantity`*`unit_price`) WHERE  FIFO_CODE='2209141408530002';
UPDATE `item_issue_detail` SET  `sub_total`=(`quantity`*`unit_price`) WHERE  FIFO_CODE='2209141408530002';


UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`*0.088) 
WHERE CRRNCY='BDT' AND FIFO_CODE='2401020944100007';
UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) 
WHERE currency='BDT' AND FIFO_CODE='2401020944100007';
UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) 
WHERE currency='BDT' AND FIFO_CODE='2401020944100007';


-- ///////////////////////////
UPDATE `stock_master_detail` SET `TOTALAMT`=(QUANTITY*UPRICE) WHERE 1;
UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`) WHERE CRRNCY='HKD';
UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`*0.088) WHERE CRRNCY='BDT';
UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`*1.1) WHERE CRRNCY='RMB';
UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`*7.750) WHERE CRRNCY='USD';


-- ////////////////
UPDATE `item_issue_detail` SET  `sub_total`=(`quantity`*`unit_price`) WHERE 1;

UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`) WHERE currency='HKD';

UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) WHERE currency='BDT';

UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`*1.1) WHERE currency='RMB';

UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`*7.750) WHERE currency='USD';
-- //////////////////////////////////////////--
UPDATE `purchase_detail` SET  `amount`=(`quantity`*`unit_price`) WHERE 1;

UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`) WHERE currency='HKD';

UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) WHERE currency='BDT';

UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`*1.1) WHERE currency='RMB';

UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`*7.750) WHERE currency='USD';

UPDATE `spares_use_detail` SET  `amount`=(`quantity`*`unit_price`) WHERE 1;

UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`) WHERE currency='HKD';

UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) WHERE currency='BDT';

UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`*1.1) WHERE currency='RMB';

UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`*7.750) WHERE currency='USD';

-- /////////////////////////////////////////////////
-- ///////////////////////////////////////////////////


UPDATE `pi_item_details` SET `amount_hkd`=(`purchased_qty`*`unit_price`) WHERE currency='HKD';
UPDATE `pi_item_details` SET `amount_hkd`=(`purchased_qty`*`unit_price`*0.088) WHERE currency='BDT';
UPDATE `pi_item_details` SET `amount_hkd`=(`purchased_qty`*`unit_price`*1.1) WHERE currency='RMB';
UPDATE `pi_item_details` SET `amount_hkd`=(`purchased_qty`*`unit_price`*7.750) WHERE currency='USD';


-- ///////////////////
UPDATE `product_detail_info` SET `amount_hkd`=machine_price*0.088 WHERE currency='BDT';
UPDATE `product_detail_info` SET `amount_hkd`=machine_price*1.1 WHERE currency='RMB';
UPDATE `product_detail_info` SET `amount_hkd`=machine_price*7.750 WHERE currency='USD';

UPDATE `product_info` SET `amount_hkd`=unit_price*0.088 WHERE currency='BDT';
UPDATE `product_info` SET `amount_hkd`=unit_price*1.1 WHERE currency='RMB';
UPDATE `product_info` SET `amount_hkd`=unit_price*7.750 WHERE currency='USD';

-- /////////////////////////////

SELECT SUM(amount_hkd) as issuevalue FROM `spares_use_detail` WHERE `date`<='2019-07-31';
SELECT SUM(amount_hkd) as purchasevalue FROM `purchase_detail` WHERE `department_id`=12 AND date<='2019-07-31'

    -- /////////////////////////
SELECT SUM(p.`QUANTITY`) as qty, p.`department_id`,
p.`ITEM_CODE`,p.`FIFO_CODE`,p.`product_id`
FROM `stock_master_detail` p 
WHERE 0>(select sum(s.QUANTITY) as ddd FROM stock_master_detail s 
    WHERE s.FIFO_CODE=p.FIFO_CODE GROUP BY s.FIFO_CODE)
GROUP By p.FIFO_CODE




SELECT s.*
FROM `stock_master_detail` s,  stock_master_detail s2
WHERE s.`UPRICE`!=s2.`UPRICE` AND s.`FIFO_CODE`=s2.`FIFO_CODE` 
GROUP BY s.FIFO_CODE
ORDER BY s.ITEM_CODE, s.FIFO_CODE ASC




SELECT s.*,s2.CRRNCY as CRRNCY1,s2.id as id1, s2.TOTALAMT_HKD as TOTALAMT_HKD1,
s2.INDATE as INDATE1 
FROM `stock_master_detail` s, stock_master_detail s2 
WHERE s.`CRRNCY`!=s2.`CRRNCY` 
AND s.`FIFO_CODE`=s2.`FIFO_CODE` ;


SELECT s.* FROM `stock_master_detail` s

WHERE s.`TRX_TYPE`='RTN'  AND (SELECT count(id) as ssss FROM stock_master_detail s2 
	WHERE s.`FIFO_CODE`=s2.`FIFO_CODE` AND s.`TRX_TYPE`=s2.`TRX_TYPE`)>1
ORDER BY s.`FIFO_CODE` ;



DELETE FROM stock_master_detail 
WHERE 
	`FIFO_CODE` IN (
	SELECT 
		`FIFO_CODE` 
	FROM (
		SELECT 
			`FIFO_CODE`,
			ROW_NUMBER() OVER (
				PARTITION BY `TRX_TYPE`
				ORDER BY `TRX_TYPE`) AS row_num
		FROM 
			stock_master_detail
		
	) t
    WHERE row_num > 1
);


DELETE a FROM stock_master_detail a
  INNER JOIN stock_master_detail a2
WHERE a.id < a2.id
AND   a.FIFO_CODE = a2.FIFO_CODE
AND   a.TRX_TYPE  = 'RTR';

-- CREATE VIEW sss AS
-- SELECT IFNULL(SUM(iid.amount_hkd),0) as sparescost,
-- sim.department_id,
-- sim.take_department_id
--      FROM item_issue_detail iid, store_issue_master sim
--      WHERE iid.issue_id=sim.issue_id 
--      AND sim.take_department_id=$take_department_id        
--       GROUP BY sim.department_id

ALTER TABLE `product_info` ADD `usage_category` 
VARCHAR(50) NOT NULL DEFAULT 'REGULAR(A)' AFTER `safety_stock_qty`; 


SELECT * FROM `stock_master_detail` 
WHERE (TRX_TYPE='GRN' OR TRX_TYPE='OPENING') 
AND ITEM_CODE='BZZ-GJ1-QT-TUBE8' AND `FIFO_CODE`NOT LIKE '20%' 
GROUP BY `FIFO_CODE`,TRX_TYPE 
ORDER BY FIFO_CODE ASC 



SELECT SUM(`QUANTITY`) as qty, SUM(`TOTALAMT`) as amount, SUM(`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` 
WHERE `ITEM_CODE`='B99-B65'

-- DELETE FIFO minus VALUE and GRN return

DELETE FROM `stock_master_detail` WHERE TRX_TYPE='ISSUE' 
AND FIFO_CODE IN(SELECT FIFO_CODE FROM purchase_detail 
 WHERE status=5 AND department_id=17) ;

DELETE FROM `item_issue_detail` WHERE  FIFO_CODE IN(SELECT FIFO_CODE FROM purchase_detail 
 WHERE status=5 AND department_id=17) ;

---FIFO WISE MINUS QTY

SELECT C.*  FROM  (SELECT a.department_id,a.FIFO_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` a 
WHERE 1
GROUP BY a.FIFO_CODE,a.department_id 
) as C WHERE C.qty<0
ORDER BY C.FIFO_CODE;




SELECT C.*  FROM  (SELECT a.ITEM_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` a 
WHERE 1
GROUP BY a.ITEM_CODE 
) as C WHERE C.amount<0
ORDER BY C.amount;

-- FIFO WISE NEGATIVE VALUE
SELECT C.*  FROM  (SELECT  a.FIFO_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` a 
WHERE 1
GROUP BY a.FIFO_CODE 
) as C WHERE C.hkd<0
ORDER BY C.hkd;

SELECT C.*  FROM  (SELECT a.FIFO_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd 
FROM `stock_master_detail` a 
WHERE 1
GROUP BY a.FIFO_CODE 
) as C WHERE C.amount<0
ORDER BY C.amount;




--ITEM WISE
SELECT C.* FROM (SELECT a.FIFO_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd,
  a.CRRNCY FROM `stock_master_detail` a 
WHERE a.CRRNCY='HKD' GROUP BY a.FIFO_CODE ) as C 
WHERE C.hkd!=C.amount ORDER BY C.hkd DESC 

--FIFO WISE
SELECT C.* FROM (SELECT a.FIFO_CODE, SUM(a.`QUANTITY`) as qty,
  SUM(a.`TOTALAMT`) as amount,SUM(a.`TOTALAMT_HKD`) as hkd,
  a.CRRNCY FROM `stock_master_detail` a 
WHERE a.CRRNCY='HKD' 
GROUP BY a.FIFO_CODE ) as C 
WHERE C.hkd!=C.amount ORDER BY C.hkd DESC 
-- ////////////////


-- /////////////////////////////////

UPDATE `stock_master_detail` SET `UPRICE`=6995 WHERE `FIFO_CODE`='2404220722310001';
UPDATE `item_issue_detail` SET  `unit_price`=6995 WHERE `FIFO_CODE`='2404220722310001';
UPDATE `spares_use_detail` SET  `unit_price`=6995 WHERE `FIFO_CODE`='2404220722310001';
UPDATE `purchase_detail` SET  `unit_price`=6995 WHERE `FIFO_CODE`='2404220722310001';

-- ///////////////////////////
UPDATE `stock_master_detail` SET `TOTALAMT`=(QUANTITY*UPRICE) WHERE FIFO_CODE='2404220722310001';
UPDATE `purchase_detail` SET  `amount`=(`quantity`*`unit_price`) WHERE  FIFO_CODE='2404220722310001';
UPDATE `item_issue_detail` SET  `sub_total`=(`quantity`*`unit_price`) WHERE  FIFO_CODE='2404220722310001';
UPDATE `spares_use_detail` SET  `amount`=(`quantity`*`unit_price`) WHERE  FIFO_CODE='2404220722310001';


UPDATE `stock_master_detail` SET `TOTALAMT_HKD`=(`QUANTITY`*`UPRICE`*0.088) 
WHERE CRRNCY='BDT' AND FIFO_CODE='2404220722310001';
UPDATE `item_issue_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) 
WHERE currency='BDT' AND FIFO_CODE='2404220722310001';
UPDATE `purchase_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) 
WHERE currency='BDT' AND FIFO_CODE='2404220722310001';

UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`*0.088) 
WHERE currency='BDT' AND FIFO_CODE='2404220722310001';


UPDATE `spares_use_detail` SET `amount_hkd`=(`quantity`*`unit_price`*7.750) WHERE currency='USD';

-- /////////////////////
DELETE FROM  stock_master_detail WHERE FIFO_CODE='L2411171005450001' AND product_id=863;
DELETE FROM  item_issue_detail WHERE FIFO_CODE='L2411171005450001' AND product_id=863;
DELETE FROM  purchase_detail WHERE FIFO_CODE='L2411171005450001' AND product_id=863; 
DELETE FROM  spares_use_detail WHERE FIFO_CODE='L2411171005450001' AND product_id=863;


DELETE FROM  stock_master_detail WHERE FIFO_CODE='L2411171005450001';
DELETE FROM  item_issue_detail WHERE FIFO_CODE='L2411171005450001';
DELETE FROM  purchase_detail WHERE FIFO_CODE='L2411171005450001'; 
DELETE FROM  spares_use_detail WHERE FIFO_CODE='L2411171005450001';


UPDATE `stock_master_detail` SET CRRNCY='BDT', `UPRICE`=185 WHERE `ITEM_CODE`='BD64630000000070';

UPDATE `item_issue_detail` SET currency='BDT', `unit_price`=185 WHERE `product_code`='BD64630000000070';

UPDATE `purchase_detail` SET currency='BDT', `unit_price`=185 WHERE `product_code`='BD64630000000070';



SELECT * FROM `stock_master_detail` WHERE `FIFO_CODE`='2007140009' ORDER BY FIFO_CODE,INDATE


SELECT * FROM `stock_master_detail` WHERE `ITEM_CODE`='BZZ-GJ1-DP17 120/19-TNCR' ORDER BY FIFO_CODE,INDATE





UPDATE `stock_master_detail` SET CRRNCY='USD' WHERE `FIFO_CODE`='2203071744470001';

UPDATE `item_issue_detail` SET currency='USD' WHERE `FIFO_CODE`='2203071744470001';

UPDATE `purchase_detail` SET currency='USD'WHERE `FIFO_CODE`='2203071744470001';



SELECT SUM(`QUANTITY`) as issu FROM `stock_master_detail` 
WHERE product_id=2723 AND `QUANTITY`>0;

SELECT SUM(`QUANTITY`) as rr FROM `stock_master_detail` 
WHERE product_id=2723 AND `QUANTITY`<0;

-- /////////////////////////////

  SELECT s.* FROM item_issue_detail s 
  WHERE  s.FIFO_CODE!='19123002090' AND s.product_id=2090 
  AND s.issue_id NOT IN (SELECT i.issue_id 
    FROM stock_master_detail i 
  	WHERE i.FIFO_CODE=s.FIFO_CODE)  

  SELECT s.* FROM item_issue_detail s 
  WHERE s.FIFO_CODE!='19123002090' AND s.product_id=2090 
  AND s.issue_id NOT IN (SELECT i.issue_id FROM stock_master_detail i 
  	WHERE i.FIFO_CODE=s.FIFO_CODE)


  SELECT SUM(s.quantity) as ddd FROM item_issue_detail s 
  WHERE s.issue_id NOT IN (SELECT i.issue_id FROM stock_master_detail i 
  WHERE i.FIFO_CODE=s.FIFO_CODE)
  
-- ////////////////////////

SELECT C.*,(C.stock_quantity+pur_qty-issue_qty) as ddd 
FROM (SELECT p.product_code,p.product_name,p.main_stock,p.stock_quantity, 
(SELECT SUM(pu.`quantity`) FROM `purchase_detail` pu
 WHERE p.`product_id`=pu.product_id AND pu.status!=5) as pur_qty, 
(SELECT SUM(i.`quantity`) FROM `item_issue_detail` i 
  WHERE p.`product_id`=i.product_id) as issue_qty, 
(SELECT SUM(t.`quantity`) FROM `spares_use_detail` t 
  WHERE p.`product_id`=t.product_id) as tpm_qty
FROM product_info p WHERE p.product_id=2782
) as C

-- //////////////
ALTER TABLE `gatepass_master` ADD `returnable_status` TINYINT NOT NULL DEFAULT '1' AFTER `gatepass_status`;

ALTER TABLE `project_management`
 ADD `project_status` TINYINT NOT NULL DEFAULT '1' AFTER `attachment_file`;

ALTER TABLE `project_management`
 ADD `project_serial` TINYINT NULL  AFTER `project_status`;

SELECT pm.pi_no,pd.*,d.department_name,
       (SELECT IFNULL(SUM(po.quantity),0) FROM po_pline po 
        WHERE pd.product_id=po.product_id AND po.pi_no=pm.pi_no AND po.po_status=3) as po_qty,

        (SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5) as in_qty

      FROM pi_item_details pd,  pi_master pm,department_info d
      WHERE  pd.pi_id=pm.pi_id 
      AND d.department_id=pm.department_id
      AND pm.pi_status=7 
      ORDER BY pm.demand_date ASC





INSERT INTO product_info 
(SELECT NULL as product_id,
p.product_name,
p.china_name, 
0 as main_stock,
p.category_id,
 38 as department_id, 
 p.brand_id,
 p.mtype_id,
 NULL as machine_type_id,
 p.product_code,
 0 as product_code_count,
 p.product_model,
 0 as stock_quantity,
 p.unit_price,
 p.currency,
 0 as amount,
 0 as amount_hkd,
 0 as stock_value_hkd,
 0 as minimum_stock,
 0 as auto_safety_stock,
 0 as safety_stock_qty, 
 p.usage_category,
 NULL as plating,
 NULL as mgrade, 
 NULL as mdiameter,
 NULL as mthread_count,
 NULL as mlength,
 0 as ptype_id,
  p.unit_id,
  0 as box_id, 
  p.product_description,
  p.product_status,
 '2022-06-11' as entry_date,
 p.product_type,
 p.returnable,
 p.product_image,
 p.before_year_qty,
 p.lmonth_closing_stock,
 p.lmonth_closing_amount,
 p.oneqty,
 p.twoqty,
 p.threeqty,
 p.fourqty,
 p.fiveqty,
 p.sixqty,
 p.last_six_month_qty,
 0 as avg_use_per_month,
 p.lead_time,
 p.lead_time_stock_qty,
 p.one_month_stock,
 p.twenty_per_stock,
 p.reorder_level,
 p.re_order_qty,
 p.medical_yes,
 p.bd_or_cn,
 p.machine_other,
 p.diesel_yes,
 220 as user_id,
 '2022-06-11' as create_date,
 '2022-06-11' as last_receive_date,  
 p.head_id
 FROM product_info p 
 WHERE p.department_id=26)



SELECT c.*,(pur_qty+sale_return_qty-purchase_return_qty-sale_qty) as stock_qty 
FROM (SELECT p.product_id,p.name,

(SELECT IFNULL(count(pu.id),0) FROM _purchase pu
 WHERE p.product_id=pu.product_id) as pur_qty,
 
(SELECT IFNULL(count(pret.id),0) FROM _purchase_return pret
 WHERE p.product_id=pret.product_id) as purchase_return_qty,

(SELECT IFNULL(count(s.id),0) FROM _sales s
 WHERE p.product_id=s.product_id) as sale_qty,

(SELECT IFNULL(count(sr.id),0) FROM _sale_return sr
 WHERE p.product_id=sr.product_id) as sale_return_qty
FROM _product p WHERE 1
) as c


 SELECT p.product_id,p.name,
     (SELECT GROUP_CONCAT(pu.imei SEPARATOR ' <br>') as dd
     FROM _purchase pu
     WHERE p.product_id=pu.product_id 
     AND pu.imei NOT IN
     (
      (SELECT pret.imei FROM _purchase_return pret WHERE 
         pret.product_id=pu.product_id AND pret.product_id=p.product_id)
      UNION 
      (SELECT s.imei FROM _sales s, _sale_return sr
        WHERE s.imei!=sr.imei AND s.product_id=sr.product_id 
        AND s.product_id=p.product_id)
      )) as allimei,


     ((SELECT IFNULL(count(pu.id),0) FROM _purchase pu
     WHERE p.product_id=pu.product_id)-
     
    (SELECT IFNULL(count(pret.id),0) FROM _purchase_return pret
     WHERE p.product_id=pret.product_id)-

    (SELECT IFNULL(count(s.id),0) FROM _sales s
     WHERE p.product_id=s.product_id)+

    (SELECT IFNULL(count(sr.id),0) FROM _sale_return sr
     WHERE p.product_id=sr.product_id)) as stock_qty
 FROM _product p 




SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity,


(SELECT group_concat(sym.symptoms_name separator '+') as symptoms_group  
FROM issued_symptoms isym, symptoms_info sym 
WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=m.issue_id 
GROUP BY m.issue_id) as symptoms_group


FROM `item_issue_detail` md
INNER JOIN product_info p ON(p.product_id=md.product_id)
INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
WHERE p.category_id=57
ORDER BY md.date ASC
