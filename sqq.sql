
DELETE FROM `bd_po_summary` WHERE `PO_NUMBER` IN(SELECT PO_NUMBER FROM payment_po_amount)


ALTER TABLE `purchase_detail` ADD `fifo_code` VARCHAR(50) NULL DEFAULT NULL AFTER `product_id`; 

ALTER TABLE `spares_use_detail` ADD `fifo_code` VARCHAR(20) NULL DEFAULT NULL AFTER `product_id`; 


SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity
FROM `item_issue_detail` md
INNER JOIN product_info p ON(p.product_id=md.product_id)
INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
WHERE p.category_id=57
ORDER BY md.date ASC



SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity,
(SELECT group_concat(sym.symptoms_name separator ',') as symptoms_group  
FROM issued_symptoms isym, symptoms_info sym 
WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=m.issue_id 
GROUP BY m.issue_id) as symptoms_group
FROM `item_issue_detail` md
INNER JOIN product_info p ON(p.product_id=md.product_id)
INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
WHERE p.category_id=57
ORDER BY md.date ASC


INSERT INTO medicaldata SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity,
(SELECT group_concat(sym.symptoms_name separator ',') as symptoms_group  
FROM issued_symptoms isym, symptoms_info sym 
WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=m.issue_id 
GROUP BY m.issue_id) as symptoms_group
FROM `item_issue_detail` md
INNER JOIN product_info p ON(p.product_id=md.product_id)
INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
WHERE p.category_id=57
ORDER BY md.date ASC


CREATE VIEW medicaldataview AS
SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity,
(SELECT group_concat(sym.symptoms_name separator ',') as symptoms_group  
FROM issued_symptoms isym, symptoms_info sym 
WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=m.issue_id 
GROUP BY m.issue_id) as symptoms_group
FROM `item_issue_detail` md
INNER JOIN product_info p ON(p.product_id=md.product_id)
INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
WHERE p.category_id=57
ORDER BY md.date ASC

SELECT * FROM `stock_master_detail` WHERE `product_id`=753 
AND `issue_id` NOT IN (SELECT  spares_use_id	 as issue_id 
  FROM spares_use_detail WHERE product_id=753)


UPDATE `purchase_master` p SET  
p.grand_total=(SELECT SUM(pd.amount) as sss FROM purchase_detail pd 
WHERE p.purchase_id=pd.purchase_id)  WHERE 1


UPDATE `purchase_master` SET supplier_id='353' WHERE `supplier_id`='323';
UPDATE `po_master` SET supplier_id='353' WHERE `supplier_id`='323';

DELETE FROM  supplier_info WHERE supplier_id='323';

-- Duplicate value DELETE
DELETE
FROM CONTACTS
WHERE ID NOT IN
      (SELECT *
       FROM (SELECT max(ID)
             FROM CONTACTS
             GROUP BY EMAIL) t);
-- /////////////////////


SELECT sim.issue_date,sim.employee_id,
      sim.employee_name,sim.sex,
          l.location_name,d.department_name,
          (SELECT group_concat(sym.symptoms_name separator '+') as symptoms_group  
          FROM issued_symptoms isym, symptoms_info sym 
          WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as symptoms_group,

          (SELECT group_concat(p.product_name separator '+') as item_group  
          FROM item_issue_detail idd, product_info p 
          WHERE idd.product_id=p.product_id AND idd.issue_id=sim.issue_id 
          GROUP BY sim.issue_id) as item_group,

          (SELECT SUM(idd2.sub_total) FROM item_issue_detail idd2
           WHERE  idd2.issue_id=sim.issue_id) as cost

          FROM  store_issue_master sim
          LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          WHERE sim.medical_yes=1 
          AND sim.department_id=3 
          AND sim.issue_date BETWEEN '2021-05-01' AND '2021-05-31'
          ORDER BY sim.issue_id ASC;


Received Data query from stock_master_detail;

SELECT SUM(QUANTITY) as ddd, SUM(`TOTALAMT_HKD`) as amount FROM `stock_master_detail` 
WHERE `INDATE` BETWEEN '2021-02-01' and '2021-02-31' 
and (TRX_TYPE='GRN' OR TRX_TYPE='RTN') 
AND receive_id is not null and department_id=12


CREATE TABLE audit_head(
  head_id INT NOT NULL AUTO_INCREMENT,
  head_name VARCHAR(150) NOT NULL,
  create_date date,
  user_id int,
  PRIMARY KEY(head_id)
)DEFAULT CHARSET=utf8;

CREATE TABLE audit_package(
  package_id INT NOT NULL AUTO_INCREMENT,
  head_id int not null,
  sub_head_name VARCHAR(150) NOT NULL,
  weight int NOT NULL,
  criteria_1 VARCHAR(600) NULL,
  criteria_2 VARCHAR(600) NULL,
  criteria_3 VARCHAR(600) NULL,
  year int,
  create_date date,
  user_id int,
  department_id int,
  PRIMARY KEY(package_id)
)DEFAULT CHARSET=utf8;


CREATE TABLE audit_master(
  master_id INT NOT NULL AUTO_INCREMENT,
  quater int NOT NULL,
  total_score DECIMAL(10,2) NULL,
  start_date VARCHAR(20),
  end_date VARCHAR(20),
  note VARCHAR(200),
  completed_date date,
  completed_by int,
  year int,
  atype VARCHAR(20) NULL,
  
  create_date date,
  status int,
  user_id int,
  department_id int,
  PRIMARY KEY(master_id)
)DEFAULT CHARSET=utf8;


CREATE TABLE audit_result(
  result_id INT NOT NULL AUTO_INCREMENT,
  master_id int,
  package_id int not null,
  score DECIMAL(10,2) NULL,
  key_note VARCHAR(600) NULL,
  year int,
  quater int NOT NULL,
  create_date date,
  user_id int,
  department_id int,
  PRIMARY KEY(result_id)
)DEFAULT CHARSET=utf8;


ALTER TABLE `payment_application_master` 
ADD `received_time` VARCHAR(10) NULL DEFAULT NULL AFTER `received_date`;

ALTER TABLE `pi_master` 
ADD `received_time` VARCHAR(10) NULL DEFAULT NULL AFTER `received_date`;

ALTER TABLE `payment_application_master` 
CHANGE `currency_rate_in_hkd` `currency_rate_in_hkd` DECIMAL(11,3) NOT NULL DEFAULT '0.100';


ALTER TABLE `item_issue_detail` 
ADD `product_name` VARCHAR(350) NULL DEFAULT NULL AFTER `FIFO_CODE`; 


UPDATE
    tbl_bank_information sm,
    change_rm p
SET
    sm.rm_code=p.rm_code
WHERE sm.ads_code = p.ads_code; 




ALTER TABLE `payment_application_master` 
CHANGE `delivery_by` `delivery_by` INT(11) NULL DEFAULT NULL;


CREATE TABLE sop_master(
  id INT NOT NULL AUTO_INCREMENT,
  menu VARCHAR(100) NOT NULL,
  title VARCHAR(350) NOT NULL,
  description longtext,
  file_1 VARCHAR(150) NULL,
  file_2 VARCHAR(150) NULL,
  file_3 VARCHAR(150) NULL,
  create_date date,
  user_id int,
  department_id int,
  PRIMARY KEY(id)
)DEFAULT CHARSET=utf8;




ALTER TABLE `purchase_master` ADD `invoice_no` VARCHAR(20) NULL DEFAULT NULL AFTER `file_no`;

INSERT INTO `actions_table` (`actions_id`, `team`, `actions_name`, `departmental_goal`, `category`, `person_name`, `start_date`, `end_date`, `department_id`, `target`, `target_type`, `achievment`, `result`, `remarks`, `status`, `year`, `user_id`, `create_date`) VALUES
(1714, 'BSS', 'Arrange Training on time', 'Capable to develop application by flutter language ( One person)', 'Positive', 'Hemel', '', '2023-11-30', 1, '100', '%', '0', NULL, NULL, 'Pending', 0, NULL, '');



CREATE VIEW po_master_view AS
SELECT po.*,
(SELECT IFNULL(SUM(pl.quantity),0) as totalpoqty FROM po_pline pl WHERE pl.po_id=po.po_id) as total_poqty,
(SELECT IFNULL(SUM(pd.quantity),0) as total_grn_qty 

  FROM purchase_detail pd
  WHERE pd.po_number=po.po_number AND pd.status!=5) as total_grn_qty, 

(SELECT IFNULL(SUM(pd.unqualified_qty),0) as total_grn_unq_qty 
  FROM purchase_detail pd 
  WHERE pd.po_number=po.po_number AND pd.status!=5) as total_grn_unq_qty
FROM  po_master po 
WHERE  1
ORDER BY po.po_id ASC