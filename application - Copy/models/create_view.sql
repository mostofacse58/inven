-- Machinery Report View Create sql.

select `pd`.`ventura_code` AS `ventura_code`,`p`.`product_name` AS `product_name`,`c`.`category_name` AS `category_name`,`p`.`product_code` AS `product_code`,`f`.`floor_no` AS `floor_no`,`fl`.`line_no` AS `line_no`,`pd`.`tpm_serial_code` AS `tpm_serial_code`,`pd`.`tpm_status` AS `tpm_status`,`pd`.`assign_date` AS `assign_date`,`pd`.`machine_price` AS `machine_price`,`pd`.`purchase_date` AS `purchase_date` from (((((`vlmbd_inventory`.`product_detail_info` `pd` join `vlmbd_inventory`.`product_info` `p` on((`p`.`product_id` = `pd`.`product_id`))) join `vlmbd_inventory`.`category_info` `c` on((`p`.`category_id` = `c`.`category_id`))) left join `vlmbd_inventory`.`machine_type` `mt` on((`p`.`machine_type_id` = `mt`.`machine_type_id`))) left join `vlmbd_inventory`.`floorline_info` `fl` on((`pd`.`line_id` = `fl`.`line_id`))) left join `vlmbd_inventory`.`floor_info` `f` on((`fl`.`floor_id` = `f`.`floor_id`))) where ((`pd`.`department_id` = 12) and (`pd`.`machine_other` = 1)) group by `pd`.`product_detail_id` order by `pd`.`ventura_code`



-- ////////////////////////////////

