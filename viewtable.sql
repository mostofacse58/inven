--
-- Structure for view `asset_information_view`
--
DROP TABLE IF EXISTS `asset_information_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`vlmcom`@`localhost` SQL SECURITY DEFINER VIEW `asset_information_view`  AS SELECT `pd`.`product_detail_id` AS `product_detail_id`, `pd`.`ventura_code` AS `ventura_code`, `pd`.`asset_encoding` AS `asset_encoding`, `pd`.`purchase_date` AS `purchase_date`, `pd`.`machine_price` AS `machine_price`, `pd`.`amount_hkd` AS `amount_hkd`, `pd`.`it_status` AS `it_status`, `pd`.`tpm_status` AS `tpm_status`, `pd`.`machine_other` AS `machine_other`, `p`.`product_name` AS `product_name`, `p`.`product_code` AS `product_code`, `p`.`china_name` AS `china_name`, `c`.`category_name` AS `category_name`, `aim`.`employee_id` AS `employee_id`, `aim`.`issue_type` AS `issue_type`, `aim`.`issue_date` AS `issue_date`, `d`.`department_name` AS `department_name`, `d2`.`department_name` AS `take_department_name`, `e`.`employee_name` AS `employee_name`, `ml`.`mlocation_name` AS `mlocation_name`, `l`.`location_name` AS `location_name`, `pd`.`other_description` AS `other_description` FROM ((((((((`product_detail_info` `pd` join `department_info` `d` on(`pd`.`department_id` = `d`.`department_id`)) join `product_info` `p` on(`p`.`product_id` = `pd`.`product_id`)) join `category_info` `c` on(`p`.`category_id` = `c`.`category_id`)) left join `asset_issue_master` `aim` on(`pd`.`product_detail_id` = `aim`.`product_detail_id` and `aim`.`take_over_status` = 1)) left join `location_info` `l` on(`aim`.`location_id` = `l`.`location_id`)) left join `main_location` `ml` on(`l`.`mlocation_id` = `ml`.`mlocation_id`)) left join `department_info` `d2` on(`aim`.`take_department_id` = `d2`.`department_id`)) left join `employee_idcard_info` `e` on(`aim`.`employee_id` = `e`.`employee_cardno`)) WHERE 1 GROUP BY `pd`.`product_detail_id` ORDER BY `pd`.`department_id` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `item_issue_detail_view`
--
DROP TABLE IF EXISTS `item_issue_detail_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`vlmcom`@`localhost` SQL SECURITY DEFINER VIEW `item_issue_detail_view`  AS SELECT `item_issue_detail`.`issue_id` AS `issue_id`, sum(`item_issue_detail`.`amount_hkd`) AS `total_amount_hkd` FROM `item_issue_detail` GROUP BY `item_issue_detail`.`issue_id` ;

-- --------------------------------------------------------

--
-- Structure for view `pi_master_view`
--
DROP TABLE IF EXISTS `pi_master_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`vlmcom`@`localhost` SQL SECURITY DEFINER VIEW `pi_master_view`  AS SELECT `pm`.`pi_id` AS `pi_id`, `pm`.`pi_no` AS `pi_no`, `pm`.`pi_type` AS `pi_type`, `pm`.`department_id` AS `department_id`, `pm`.`for_department_id` AS `for_department_id`, `pm`.`pi_date` AS `pi_date`, `pm`.`demand_date` AS `demand_date`, `pm`.`new_demand_date` AS `new_demand_date`, `pm`.`confirmed_date` AS `confirmed_date`, `pm`.`certified_date` AS `certified_date`, `pm`.`received_date` AS `received_date`, `pm`.`approved_date` AS `approved_date`, `pm`.`verified_date` AS `verified_date`, `pm`.`pi_status` AS `pi_status`, `pm`.`reject_note` AS `reject_note`, `pt`.`p_type_name` AS `p_type_name`, `d`.`department_name` AS `department_name`, `u6`.`user_name` AS `verified_name` FROM (((`pi_master` `pm` left join `purchase_type` `pt` on(`pm`.`purchase_type_id` = `pt`.`purchase_type_id`)) left join `department_info` `d` on(`pm`.`department_id` = `d`.`department_id`)) left join `user` `u6` on(`u6`.`id` = `pm`.`verified_by`)) ORDER BY `pm`.`pi_id` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `spares_use_detail_view`
--
DROP TABLE IF EXISTS `spares_use_detail_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`vlmcom`@`localhost` SQL SECURITY DEFINER VIEW `spares_use_detail_view`  AS SELECT `spares_use_detail`.`spares_use_id` AS `spares_use_id`, sum(`spares_use_detail`.`amount_hkd`) AS `total_amount_hkd` FROM `spares_use_detail` GROUP BY `spares_use_detail`.`spares_use_id` ;

--
-- Indexes for dumped tables
--
