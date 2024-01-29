//Table structures
//transaction_tbl

CREATE TABLE `transaction_tbl` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `trans_id` varchar(20) NOT NULL,
 `trans_date` date DEFAULT NULL,
 `order_no` varchar(20) DEFAULT NULL,
 `order_date` date DEFAULT NULL,
 `dc_no` varchar(20) DEFAULT NULL,
 `dc_date` date DEFAULT NULL,
 `trans_type` varchar(4) NOT NULL,
 `db_account` int(11) NOT NULL,
 `cr_account` int(11) NOT NULL,
 `statecode` varchar(2) DEFAULT NULL,
 `gstin` varchar(16) DEFAULT NULL,
 `inv_type` varchar(10) NOT NULL DEFAULT 'R',
 `trans_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `net_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `trans_reference` varchar(100) DEFAULT NULL,
 `trans_narration` text,
 `salebyperson` int(11) NOT NULL DEFAULT '0',
 `finyear` varchar(7) DEFAULT NULL,
 `company_id` int(11) NOT NULL DEFAULT '0',
 `delflag` int(11) NOT NULL DEFAULT '0',
 `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


//itemtransaction_tbl

CREATE TABLE `itemtransaction_tbl` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `trans_link_id` int(11) NOT NULL,
 `trans_id` varchar(16) NOT NULL,
 `trans_date` date NOT NULL,
 `trans_type` varchar(4) NOT NULL,
 `item_id` int(11) NOT NULL,
 `item_name` varchar(100) DEFAULT NULL,
 `item_desc` varchar(100) NOT NULL,
 `item_hsnsac` varchar(6) DEFAULT NULL,
 `item_unit` varchar(4) NOT NULL,
 `item_qty` decimal(8,2) NOT NULL,
 `item_mrp` decimal(10,2) NOT NULL DEFAULT '0.00',
 `item_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
 `item_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `item_dispc` decimal(5,2) NOT NULL DEFAULT '0.00',
 `item_disamount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `item_gstpc` decimal(5,2) NOT NULL DEFAULT '0.00',
 `igst_pc` decimal(5,2) NOT NULL DEFAULT '0.00',
 `cgst_pc` decimal(5,2) NOT NULL DEFAULT '0.00',
 `sgst_pc` decimal(5,2) NOT NULL DEFAULT '0.00',
 `igst_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `cgst_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `sgst_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `taxable_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `nett_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
 `goods_service` int(11) NOT NULL DEFAULT '0',
 `finyear` varchar(7) DEFAULT NULL,
 `company_id` int(11) NOT NULL DEFAULT '0',
 `delflag` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4

//Products Table

CREATE TABLE `products_tbl` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `prod_name` varchar(100) NOT NULL,
 `prod_desc` varchar(100) NOT NULL,
 `prod_hsnsac` varchar(6) NOT NULL,
 `prod_gstpc` int(11) NOT NULL DEFAULT '0',
 `prod_unit` varchar(4) NOT NULL,
 `prod_mrp` decimal(8,2) NOT NULL DEFAULT '0.00',
 `prod_cost` decimal(8,2) NOT NULL DEFAULT '0.00',
 `prod_rate` decimal(8,2) NOT NULL DEFAULT '0.00',
 `prod_sku` varchar(100) NOT NULL,
 `prod_batch` varchar(20) NOT NULL,
 `prod_expiry` varchar(20) NOT NULL,
 `prod_make` varchar(25) NOT NULL,
 `prod_model` varchar(25) NOT NULL,
 `prod_stock` int(11) NOT NULL DEFAULT '0',
 `goods_service` int(11) NOT NULL DEFAULT '0',
 `company_id` int(11) NOT NULL DEFAULT '0',
 `delflag` int(11) NOT NULL DEFAULT '0',
 `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4


// Ledgermaster Table

CREATE TABLE `ledgermaster_tbl` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `account_name` varchar(150) NOT NULL,
 `account_address` text NOT NULL,
 `account_gstin` varchar(16) NOT NULL,
 `account_contact` varchar(50) NOT NULL,
 `account_email` varchar(150) NOT NULL,
 `account_city` varchar(50) NOT NULL,
 `account_statecode` varchar(3) NOT NULL,
 `account_groupid` int(11) NOT NULL,
 `account_pan` varchar(10) NOT NULL,
 `account_openbal` decimal(10,2) NOT NULL DEFAULT '0.00',
 `bus_type` int(11) NOT NULL DEFAULT '0',
 `predefined` int(11) NOT NULL DEFAULT '0',
 `company_id` int(11) NOT NULL DEFAULT '0',
 `delflag` int(11) NOT NULL DEFAULT '0',
 `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4

