-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 24, 2024 at 10:22 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u682906679_cryptoblue`
--

-- --------------------------------------------------------

--
-- Table structure for table `ce_discount_system`
--

CREATE TABLE `ce_discount_system` (
  `id` int(11) NOT NULL,
  `discount_level` int(11) DEFAULT NULL,
  `from_value` varchar(255) DEFAULT NULL,
  `to_value` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `discount_percentage` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_faq`
--

CREATE TABLE `ce_faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_gateways`
--

CREATE TABLE `ce_gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `min_amount` varchar(255) DEFAULT NULL,
  `max_amount` varchar(255) DEFAULT NULL,
  `reserve` varchar(255) DEFAULT NULL,
  `include_fee` int(11) DEFAULT NULL,
  `extra_fee` varchar(255) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `allow_send` int(11) DEFAULT NULL,
  `require_login` int(11) DEFAULT NULL,
  `require_email_verify` int(11) DEFAULT NULL,
  `require_mobile_verify` int(11) DEFAULT NULL,
  `require_document_verify` int(11) DEFAULT NULL,
  `allow_attachments` int(11) DEFAULT NULL,
  `max_attachments` int(11) DEFAULT NULL,
  `require_attachments` int(11) DEFAULT NULL,
  `g_field_1` varchar(255) DEFAULT NULL,
  `g_field_2` varchar(255) DEFAULT NULL,
  `g_field_3` varchar(255) DEFAULT NULL,
  `g_field_4` varchar(255) DEFAULT NULL,
  `g_field_5` varchar(255) DEFAULT NULL,
  `g_field_6` varchar(255) DEFAULT NULL,
  `g_field_7` varchar(255) DEFAULT NULL,
  `g_field_8` varchar(255) DEFAULT NULL,
  `g_field_9` varchar(255) DEFAULT NULL,
  `g_field_10` varchar(255) DEFAULT NULL,
  `manual_payment` int(11) DEFAULT NULL,
  `external_gateway` int(11) DEFAULT NULL,
  `external_icon` varchar(255) DEFAULT NULL,
  `is_crypto` int(11) DEFAULT 0,
  `merchant_source` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_gateways`
--

INSERT INTO `ce_gateways` (`id`, `name`, `currency`, `min_amount`, `max_amount`, `reserve`, `include_fee`, `extra_fee`, `fee`, `allow_send`, `require_login`, `require_email_verify`, `require_mobile_verify`, `require_document_verify`, `allow_attachments`, `max_attachments`, `require_attachments`, `g_field_1`, `g_field_2`, `g_field_3`, `g_field_4`, `g_field_5`, `g_field_6`, `g_field_7`, `g_field_8`, `g_field_9`, `g_field_10`, `manual_payment`, `external_gateway`, `external_icon`, `is_crypto`, `merchant_source`) VALUES
(1, 'Bitcoin', 'BTC', '0.001', '10000000', '99999848', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, '1jKQWBcQczr92gMgEvkMk36iXZhshqwHz', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246376_icon.png', 1, ''),
(2, 'Ethereum', 'ETH', '0.01', '10000000', '99998684.84460081', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, '0x4dCbA2817Eb590fFcB074849B979212001EA3951', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246416_icon.png', 1, ''),
(3, 'USD Coin', 'USDC', '10', '10000000', '99790000', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, '0x4dCbA2817Eb590fFcB074849B979212001EA3951', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246650_icon.png', 1, ''),
(4, 'Bitcoin Cash', 'BCH', '0.1', '2000', '1000', 0, '0', 0, 1, 1, 1, 0, 1, 0, 0, 0, 'qrysp6ag9fyecfykx0ga6n7z4udwd3vypyr7yaeq6y', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246679_icon.png', 1, ''),
(5, 'Binance Coin', 'BNB', '0.1', '2000', '1000', 0, '0', 0, 1, 1, 1, 0, 1, 0, 0, 0, 'bnb1ulxjsqkdpem56axc5sqljuwe7wya3j0x042cwg', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246709_icon.png', 1, ''),
(6, 'Dogecoin', 'DOGE', '100', '10000', '1000000', 0, '0', 0, 1, 1, 1, 0, 1, 0, 0, 0, 'DFSF9JikAJ8ZYhjzbs4Qw1XmpAKwC7JMas', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246740_icon.png', 1, ''),
(7, 'Tether', 'USDT', '10', '10000000', '100000000', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, '0x4dCbA2817Eb590fFcB074849B979212001EA3951', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246764_icon.png', 1, ''),
(8, 'Ripple', 'XRP', '2', '1000', '10000', 0, '0', 0, 1, 1, 1, 0, 1, 0, 0, 0, 'rG6sEJkjAAzSET11KJdPGDMgyWXhGE4yoP', '', '', '', '', '', '', '', '', '', 1, 1, 'uploads/1681246801_icon.png', 1, ''),
(9, 'Bank Transfer (Eurozone)', 'EUR', '100', '10000000', '100000000', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, 'Banking Circle S.A.', '2, Boulevard de la Foire L-1528 LUXEMBOURG', 'LU694080000097914081', 'BCIRLULL', 'Virsympay LLC', '', '', '', '', '', 1, 1, 'uploads/1681247002_icon.png', 0, ''),
(10, 'Bank Transfer (UK Only)', 'GBP', '100', '10000000', '100000000', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, 'Barclays', '231486', '14837753', 'Virsympay LLC', '', '', '', '', '', '', 1, 1, 'uploads/1681247402_icon.png', 0, ''),
(11, 'Bank Transfer (US Only)', 'USD', '100', '10000000', '100000000', 0, '0', 0, 1, 1, 1, 0, 1, 1, 10, 0, 'Fidelity Investments', '450 N Federal Hwy Suite 200, Fort Lauderdale, FL 33301', '39900000740175795', '101205681', 'Virsympay LLC', '3232 SW 2nd Ave. Fort Lauderdale FL 33315', '', '', '', '', 1, 1, 'uploads/1681247715_icon.png', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ce_gateways_directions`
--

CREATE TABLE `ce_gateways_directions` (
  `id` int(11) NOT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `directions` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_gateways_directions`
--

INSERT INTO `ce_gateways_directions` (`id`, `gateway_id`, `directions`) VALUES
(1, 1, '2,3,4,5,6,7,8,9,10,11'),
(2, 2, '1,3,4,5,6,7,8,9,10,11'),
(3, 3, '1,2,4,5,6,7,8,9,10,11'),
(4, 4, '1,2,3,5,6,7,8,9,10,11'),
(5, 5, '1,2,3,4,6,7,8,9,10,11'),
(6, 6, '1,2,3,4,5,7,8,9,10,11'),
(7, 7, '1,2,3,4,5,6,8,9,10,11'),
(8, 8, '1,2,3,4,5,6,7,9,10,11'),
(9, 9, '1,2,3,4,5,6,7,8,10,11'),
(10, 10, '1,2,3,4,5,6,7,8,9,11'),
(11, 11, '1,2,3,4,5,6,7,8,9,10');

-- --------------------------------------------------------

--
-- Table structure for table `ce_gateways_fields`
--

CREATE TABLE `ce_gateways_fields` (
  `id` int(11) NOT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_number` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_gateways_fields`
--

INSERT INTO `ce_gateways_fields` (`id`, `gateway_id`, `type`, `field_name`, `field_number`) VALUES
(1, 1, 0, 'Bitcoin Wallet Address', 1),
(2, 2, 0, 'Ethereum ERC30 Wallet Address', 1),
(3, 3, 0, 'USD Coin Wallet Address', 1),
(4, 4, 0, 'Bitcoin Cash Wallet Address', 1),
(5, 5, 0, 'Binance Coin Wallet Address', 1),
(6, 6, 0, 'Dogecoin Wallet Address', 1),
(7, 7, 0, 'Tether Wallet Address', 1),
(8, 8, 0, 'Ripple Wallet Address', 1),
(9, 9, 0, 'Bank name', 1),
(10, 9, 0, 'Bank address', 2),
(11, 9, 0, 'IBAN', 3),
(12, 9, 0, 'BIC', 4),
(13, 9, 0, 'Beneficiary name', 5),
(14, 10, 0, 'Bank name', 1),
(15, 10, 0, 'Sort Code', 2),
(16, 10, 0, 'Account Number', 3),
(17, 10, 0, 'Beneficiary name', 4),
(18, 11, 0, 'Bank name', 1),
(19, 11, 0, 'Bank Address', 2),
(20, 11, 0, 'Account Number', 3),
(21, 11, 0, 'Account Routing', 4),
(22, 11, 0, 'Beneficiary name', 5),
(23, 11, 0, 'Account Address', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ce_gateways_rules`
--

CREATE TABLE `ce_gateways_rules` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_to` int(11) DEFAULT NULL,
  `exchange_rules` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_active`
--

CREATE TABLE `ce_invest_active` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `daily_profit` varchar(255) DEFAULT NULL,
  `total_profit` varchar(255) DEFAULT NULL,
  `total_return` varchar(255) DEFAULT NULL,
  `total_return_with_profit` varchar(255) DEFAULT NULL,
  `investment_days` varchar(255) DEFAULT NULL,
  `confirmations` int(11) DEFAULT NULL,
  `days_left` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `expired` int(11) DEFAULT NULL,
  `have_insurance` int(11) DEFAULT NULL,
  `insurance_start` int(11) DEFAULT NULL,
  `insurance_expire` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_balances`
--

CREATE TABLE `ce_invest_balances` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_deposits`
--

CREATE TABLE `ce_invest_deposits` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `tx_id` varchar(255) DEFAULT NULL,
  `cp_txid` varchar(255) DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `confirms_need` int(11) DEFAULT NULL,
  `pay_address` varchar(255) DEFAULT NULL,
  `paid` int(11) DEFAULT NULL,
  `confirmations` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `expired` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_earnings`
--

CREATE TABLE `ce_invest_earnings` (
  `id` int(11) NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_plans`
--

CREATE TABLE `ce_invest_plans` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `min_deposit_amount` varchar(255) DEFAULT NULL,
  `min_withdrawal_amount` varchar(255) DEFAULT NULL,
  `daily_profit` varchar(255) DEFAULT NULL,
  `investment_days` varchar(255) DEFAULT NULL,
  `confirmations` varchar(255) DEFAULT NULL,
  `cp_merchant` varchar(255) DEFAULT NULL,
  `cp_secret` varchar(255) DEFAULT NULL,
  `cp_public_key` varchar(255) DEFAULT NULL,
  `cp_private_key` varchar(255) DEFAULT NULL,
  `update_dp_onchange` int(11) DEFAULT NULL,
  `update_id_onchange` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_invest_withdrawals`
--

CREATE TABLE `ce_invest_withdrawals` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `withdrawal_id` varchar(255) DEFAULT NULL,
  `earnings_id` int(11) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `tx_id` varchar(255) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_news`
--

CREATE TABLE `ce_news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_news`
--

INSERT INTO `ce_news` (`id`, `title`, `content`, `created`, `updated`, `views`, `author`) VALUES
(1, 'From the News Desk of the Virsymcoin - Binance Vs Forbes', '<p><iframe title=\"YouTube video player\" src=\"https://www.youtube.com/embed/l7fqlxdcccQ\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe></p>', 1681468193, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ce_operators`
--

CREATE TABLE `ce_operators` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `can_login` int(11) DEFAULT NULL,
  `can_manage_gateways` int(11) DEFAULT NULL,
  `can_manage_directions` int(11) DEFAULT NULL,
  `can_manage_rates` int(11) DEFAULT NULL,
  `can_manage_rules` int(11) DEFAULT NULL,
  `can_manage_orders` int(11) DEFAULT NULL,
  `can_manage_users` int(11) DEFAULT NULL,
  `can_manage_reviews` int(11) DEFAULT NULL,
  `can_manage_withdrawals` int(11) DEFAULT NULL,
  `can_manage_support_tickets` int(11) DEFAULT NULL,
  `can_manage_news` int(11) DEFAULT NULL,
  `can_manage_pages` int(11) DEFAULT NULL,
  `can_manage_faq` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_operators_activity`
--

CREATE TABLE `ce_operators_activity` (
  `id` int(11) NOT NULL,
  `oid` int(11) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_id` varchar(255) DEFAULT NULL,
  `activity_value` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_orders`
--

CREATE TABLE `ce_orders` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `gateway_send` int(11) DEFAULT NULL,
  `gateway_receive` int(11) DEFAULT NULL,
  `amount_send` varchar(255) DEFAULT NULL,
  `amount_receive` varchar(255) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL,
  `currency_from` varchar(255) DEFAULT NULL,
  `currency_to` varchar(255) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  `transaction_send` varchar(255) DEFAULT NULL,
  `transaction_receive` varchar(255) DEFAULT NULL,
  `order_hash` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `expired` int(11) DEFAULT NULL,
  `refereer` int(11) DEFAULT NULL,
  `refereer_comission` varchar(255) DEFAULT NULL,
  `refereer_comission_currency` varchar(255) DEFAULT NULL,
  `refereer_set` int(11) DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_orders`
--

INSERT INTO `ce_orders` (`id`, `uid`, `gateway_send`, `gateway_receive`, `amount_send`, `amount_receive`, `rate_from`, `rate_to`, `currency_from`, `currency_to`, `u_field_1`, `u_field_2`, `u_field_3`, `u_field_4`, `u_field_5`, `u_field_6`, `u_field_7`, `u_field_8`, `u_field_9`, `u_field_10`, `transaction_send`, `transaction_receive`, `order_hash`, `ip`, `status`, `created`, `updated`, `expired`, `refereer`, `refereer_comission`, `refereer_comission_currency`, `refereer_set`, `processed_by`) VALUES
(1000000, 1, 11, 1, '33004.40', '1.00000000', '33004.40', '1', 'USD', 'BTC', 'darioroberts@hotmail.com', 'qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', '', '', '', '', '', '', '', '', '123198435', '', '2cec05190db910184c29ddb6f1dbd685', '24.231.57.56', 4, 1681311024, 1681408819, 0, 0, '0', '', 0, 1),
(1000001, 2, 11, 1, '3305988.00', '100.00000000', '33567.93', '1', 'USD', 'BTC', 'darioroberts@hotmail.com', 'qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', '', '', '', '', '', '', '', '', '223198439', '', '3637051bc0a3608676447049e57823a7', '64.150.226.23', 4, 1681409678, 1681409764, 0, 0, '0', '', 0, 1),
(1000002, 2, 11, 1, '1090976.04', '33.00000000', '33059.88', '1', 'USD', 'BTC', 'darioroberts@hotmail.com', 'AsX99BXtf55WPZ1deQ31HP9pkuzR7z5Ytr', '', '', '', '', '', '', '', '', '414201520', '', 'b9435547cb6ba883ef9e285f094ace57', '64.150.226.23', 4, 1681410448, 1681410528, 0, 0, '0', '', 0, 1),
(1000003, 2, 11, 2, '23323.10', '10.00000000', '2332.31', '1', 'USD', 'ETH', 'darioroberts@hotmail.com', 'Ty2319hje34094752398we2', '', '', '', '', '', '', '', '', '223198439', '', 'bcdc063c9f49d6234cbab54b35f25640', '64.150.226.23', 4, 1681480126, 1681914919, 0, 0, '0', '', 0, 1),
(1000004, 2, 1, 2, '100', '1305.00000000', '1', '13.050000', 'BTC', 'ETH', 'darioroberts@hotmail.com', 'Ty2319hje34094752398we2', '', '', '', '', '', '', '', '', '223198439', 'XDewijgh2948019nMasw0', '3e9cbd0908a56a6ee29ca345a1f2c24a', '64.150.226.23', 4, 1681914653, 1681914992, 0, 0, '0', '', 0, 1),
(1000005, 2, 9, 1, '575193.84', '19.00000000', '30273.36', '1', 'EUR', 'BTC', 'darioroberts@hotmail.com', 'LsX99BXtf55WPZ1deQ31HP9pkuzR7z5YtW', '', '', '', '', '', '', '', '', '123198435', 'GJHDBibb irbj34928109jnfbZxc', '9679ed11a4e35ed36ed61197b42476f9', '64.150.226.23', 4, 1681914768, 1681915054, 0, 0, '0', '', 0, 1),
(1000006, 2, 10, 3, '176000.00', '200000.00000000', '0.88', '1', 'GBP', 'USDC', 'darioroberts@hotmail.com', 'LsX99BXtf55WPZ1deQ31HP9pkuzR7z5YtW', '', '', '', '', '', '', '', '', '414201520', 'hjdaifiub8475yMJSbdUY938', '5eeafb82b0688c233c1885ab9138bb0b', '64.150.226.23', 4, 1681914862, 1681915102, 0, 0, '0', '', 0, 1),
(1000007, 2, 10, 1, '2685816.00', '100.00000000', '26858.16', '1', 'GBP', 'BTC', 'darioroberts@hotmail.com', 'LsX99BXtf55WPZ1deQ31HP9pkuzR7z5YtW', '', '', '', '', '', '', '', '', '60094872398', NULL, '696849d33fbc6043f6ffb4e73b6df3ff', '64.150.226.23', 3, 1683150798, 1683150848, 0, 0, '0', '', 0, NULL),
(1000008, 2, 9, 1, '1513668.00', '50.00000000', '30273.36', '1', 'EUR', 'BTC', 'darioroberts@hotmail.com', 'AsX99BXtf55WPZ1deQ31HP9pkuzR7z5Ytr', '', '', '', '', '', '', '', '', '60094872398', NULL, '9ba7d8d425f5d7bc75ec30c5ff5eec0f', '64.150.226.23', 3, 1683150931, 1683151072, 0, 0, '0', '', 0, NULL),
(1000009, 2, 11, 1, '719555.46', '23.00000000', '31285.02', '1', 'USD', 'BTC', 'darioroberts@hotmail.com', 'Y%#/5439800ghhw', '', '', '', '', '', '', '', '', '23876543', NULL, '7fbbed2afbb09eb15906f4ac57fc5bf2', '64.150.226.23', 3, 1683164163, 1683164210, 0, 0, '0', '', 0, NULL),
(1000010, 2, 9, 3, '10000.00', '10000.00000000', '1', '1', 'EUR', 'USDC', 'darioroberts@hotmail.com', 'Ty2319hje34094752398we2', '', '', '', '', '', '', '', '', '22839', 'GJHDBibb irbj34928109jnfbZxc', '5a629614c46ee4ca4c73665d68021f53', '64.150.226.23', 4, 1683949251, 1683949754, 0, 0, '0', '', 0, 1),
(1000011, 8, 11, 1, '67429.64', '1.00000000', '67429.64', '1', 'USD', 'BTC', '2@gmail.com', '**************', '', '', '', '', '', '', '', '', NULL, NULL, 'fceccd4e6b193b658b0f510f8d8fc98e', '122.161.77.178', 6, 1715547510, 0, 1715551495, 0, '0', '', 0, NULL),
(1000012, 8, 11, 2, '500', '0.15539919', '3217.52', '1', 'USD', 'ETH', '2@gmail.com', '**************', '', '', '', '', '', '', '', '', 'paid', 'hhhh', '0aa5a2af83ff8f887029874d55566a2b', '122.161.77.178', 4, 1715547555, 1715547729, 0, 0, '0', '', 0, 1),
(1000013, 8, 1, 2, '1', '16.63200000', '1', '16.632000', 'BTC', 'ETH', 'ranaali9320@gmail.com', '*********', '', '', '', '', '', '', '', '', NULL, NULL, '6a890556802f93e9ab8ca4adf3ce5463', '2401:4900:1c62:5d63:ed8a:7562:2a68:6891', 6, 1718046939, 0, 1718058323, 0, '0', '', 0, NULL),
(1000014, 8, 10, 5, '200', '0.64819316', '308.55', '1', 'GBP', 'BNB', 'ranaali9320@gmail.com', '*********', '', '', '', '', '', '', '', '', NULL, NULL, '489c6d192a1b54451788c603d7c76a2a', '2401:4900:1c62:5d63:ed8a:7562:2a68:6891', 6, 1718047224, 0, 1718058323, 0, '0', '', 0, NULL),
(1000015, 8, 11, 8, '500', '862.06896552', '0.58', '1', 'USD', 'XRP', 'ranaali9320@gmail.com', '*********', '', '', '', '', '', '', '', '', NULL, NULL, 'b60c297653d90d9b5955e3e9b85857d8', '2401:4900:1c62:5d63:ed8a:7562:2a68:6891', 6, 1718047899, 0, 1718058323, 0, '0', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ce_orders_attachments`
--

CREATE TABLE `ce_orders_attachments` (
  `id` int(11) NOT NULL,
  `oid` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filesize` varchar(255) DEFAULT NULL,
  `filepath` text DEFAULT NULL,
  `uploaded` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_orders_attachments`
--

INSERT INTO `ce_orders_attachments` (`id`, `oid`, `filename`, `filesize`, `filepath`, `uploaded`) VALUES
(1, 1000003, 'Screenshot 2023-04-12 at 15-26-47 Exchange Bank Transfer (US Only) USD to Bitcoin BTC - Virsymcoin.png', '26302', '5d2a2e897d/f31c147335/1681480180_file.png', 1681480180),
(2, 1000004, 'Screenshot 2023-04-12 at 16-33-08 Virsymcoin.png', '16129', '5d2a2e897d/f68ec4f0c6/1681914690_file.png', 1681914690),
(3, 1000010, 'Screenshot 2023-05-10 at 13-47-27 Chapter-07 The Truth of The Past.png', '423150', '5d2a2e897d/3e267ff3c8/1683949295_file.png', 1683949295),
(4, 1000012, 'Screenshot_10.png', '1167', '5d2a2e897d/f1073dcfac/1715547653_file.png', 1715547653);

-- --------------------------------------------------------

--
-- Table structure for table `ce_orders_values`
--

CREATE TABLE `ce_orders_values` (
  `id` int(11) NOT NULL,
  `oid` int(11) DEFAULT NULL,
  `field_id` varchar(255) DEFAULT NULL,
  `field_value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_pages`
--

CREATE TABLE `ce_pages` (
  `id` int(11) NOT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_rates`
--

CREATE TABLE `ce_rates` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_to` int(11) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL,
  `percentage_rate` int(11) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_rates`
--

INSERT INTO `ce_rates` (`id`, `gateway_from`, `gateway_to`, `rate_from`, `rate_to`, `percentage_rate`, `fee`) VALUES
(1, 1, 2, '', '', 1, 10),
(2, 1, 3, '', '', 1, 10),
(3, 1, 4, '', '', 1, 10),
(4, 1, 5, '', '', 1, 10),
(5, 1, 6, '', '', 1, 10),
(6, 1, 7, '', '', 1, 10),
(7, 1, 8, '', '', 1, 10),
(8, 1, 11, '', '', 1, 10),
(9, 2, 1, '', '', 1, 10),
(10, 2, 3, '', '', 1, 10),
(11, 2, 4, '', '', 1, 10),
(12, 2, 5, '', '', 1, 10),
(13, 2, 6, '', '', 1, 10),
(14, 2, 7, '', '', 1, 10),
(15, 2, 8, '', '', 1, 10),
(16, 2, 11, '', '', 1, 10),
(17, 3, 1, '', '', 1, 10),
(18, 3, 2, '', '', 1, 10),
(19, 3, 4, '', '', 1, 10),
(20, 3, 5, '', '', 1, 10),
(21, 3, 6, '', '', 1, 10),
(22, 3, 7, '', '', 1, 10),
(23, 3, 8, '', '', 1, 10),
(24, 3, 11, '', '', 1, 10),
(25, 4, 1, '', '', 1, 10),
(26, 4, 2, '', '', 1, 10),
(27, 4, 3, '', '', 1, 10),
(28, 4, 5, '', '', 1, 10),
(29, 4, 6, '', '', 1, 10),
(30, 4, 7, '', '', 1, 10),
(31, 4, 8, '', '', 1, 10),
(32, 4, 11, '', '', 1, 10),
(33, 5, 1, '', '', 1, 10),
(34, 5, 2, '', '', 1, 10),
(35, 5, 3, '', '', 1, 10),
(36, 5, 4, '', '', 1, 10),
(37, 5, 6, '', '', 1, 10),
(38, 5, 7, '', '', 1, 10),
(39, 5, 8, '', '', 1, 10),
(40, 5, 11, '', '', 1, 10),
(41, 6, 1, '', '', 1, 10),
(42, 6, 2, '', '', 1, 10),
(43, 6, 3, '', '', 1, 10),
(44, 6, 4, '', '', 1, 10),
(45, 6, 5, '', '', 1, 10),
(46, 6, 7, '', '', 1, 10),
(47, 6, 8, '', '', 1, 10),
(48, 6, 11, '', '', 1, 10),
(49, 7, 1, '', '', 1, 10),
(50, 7, 2, '', '', 1, 10),
(51, 7, 3, '', '', 1, 10),
(52, 7, 4, '', '', 1, 10),
(53, 7, 5, '', '', 1, 10),
(54, 7, 6, '', '', 1, 10),
(55, 7, 8, '', '', 1, 10),
(56, 7, 11, '', '', 1, 10),
(57, 8, 1, '', '', 1, 10),
(58, 8, 2, '', '', 1, 10),
(59, 8, 3, '', '', 1, 10),
(60, 8, 4, '', '', 1, 10),
(61, 8, 5, '', '', 1, 10),
(62, 8, 6, '', '', 1, 10),
(63, 8, 7, '', '', 1, 10),
(64, 8, 11, '', '', 1, 10),
(65, 11, 1, '', '', 1, 10),
(66, 11, 2, '', '', 1, 10),
(67, 11, 3, '', '', 1, 10),
(68, 11, 4, '', '', 1, 10),
(69, 11, 5, '', '', 1, 10),
(70, 11, 6, '', '', 1, 10),
(71, 11, 7, '', '', 1, 10),
(72, 11, 8, '', '', 1, 10),
(73, 11, 9, '1.1', '1.01', 0, 0),
(74, 11, 10, '1.36', '1.01', 0, 0),
(75, 1, 9, '1', '24711.40', 0, 0),
(76, 2, 9, '1', '1543.45', 0, 0),
(77, 2, 10, '1', '1358.06', 0, 0),
(78, 3, 9, '1.1', '1', 0, 0),
(79, 7, 9, '1.1', '1', 0, 0),
(80, 3, 10, '1.25', '1', 0, 0),
(81, 7, 10, '1.25', '1', 0, 0),
(82, 4, 9, '1', '104.80', 0, 0),
(83, 5, 9, '1', '263.06', 0, 0),
(84, 6, 9, '14.6', '1', 0, 0),
(85, 8, 9, '2.4', '1', 0, 0),
(127, 10, 2, '1872.26', '1', 0, 0),
(87, 1, 10, '1', '21767.53', 0, 0),
(88, 4, 10, '1', '92.33', 0, 0),
(89, 5, 10, '1', '231.21', 0, 0),
(90, 6, 10, '16.65', '1', 0, 0),
(91, 8, 10, '2.712', '1', 0, 0),
(129, 10, 7, '0.88', '1', 0, 0),
(128, 10, 3, '0.88', '1', 0, 0),
(119, 9, 3, '1', '1', 0, 0),
(120, 9, 4, '134.96', '1', 0, 0),
(121, 9, 5, '347.26', '1', 0, 0),
(122, 9, 6, '0.089', '1', 0, 0),
(118, 9, 2, '2106.18', '1', 0, 0),
(117, 9, 1, '30273.36', '1', 0, 0),
(126, 10, 1, '26858.16', '1', 0, 0),
(123, 9, 8, '0.52', '1', 0, 0),
(124, 9, 7, '1', '1', 0, 0),
(125, 9, 10, '1.24', '1', 0, 0),
(130, 10, 4, '119.54', '1', 0, 0),
(131, 10, 5, '308.55', '1', 0, 0),
(132, 10, 6, '0.079', '1', 0, 0),
(133, 10, 8, '0.46', '1', 0, 0),
(134, 10, 9, '1', '1.03', 0, 0),
(135, 10, 11, '1', '1.15', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ce_rates_live`
--

CREATE TABLE `ce_rates_live` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_to` int(11) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_rates_live`
--

INSERT INTO `ce_rates_live` (`id`, `gateway_from`, `gateway_to`, `rate_from`, `rate_to`, `updated`) VALUES
(1, 1, 2, '1', '16.632000', 1717614006),
(2, 1, 3, '1', '63983.718000', 1717614007),
(3, 1, 4, '1', '130.986000', 1717614007),
(4, 1, 5, '1', '92.664000', 1717614012),
(5, 1, 6, '1', '392217.417000', 1717614013),
(6, 1, 7, '1', '63979.299000', 1717614014),
(7, 1, 8, '1', '121557.690000', 1717614014),
(8, 1, 11, '1', '63988.35', 1717614015),
(9, 2, 1, '1', '0.048699', 1717614016),
(10, 2, 3, '1', '3461.463000', 1717614016),
(11, 2, 4, '1', '7.088400', 1717614017),
(12, 2, 5, '1', '5.012100', 1717614018),
(13, 2, 6, '1', '21214.305000', 1717614018),
(14, 2, 7, '1', '3462.390000', 1717614019),
(15, 2, 8, '1', '6577.434000', 1717614020),
(16, 2, 11, '1', '3461.62', 1717614021),
(17, 3, 1, '1', '0.000013', 1717614022),
(18, 3, 2, '1', '0.000234', 1717614024),
(19, 3, 4, '1', '0.001842', 1717614024),
(20, 3, 5, '1', '0.001303', 1717614025),
(21, 3, 6, '1', '5.515200', 1717614026),
(22, 3, 7, '1', '0.900000', 1717614026),
(23, 3, 8, '1', '1.710000', 1717614027),
(24, 3, 11, '1', '0.90', 1717614028),
(25, 4, 1, '1', '0.006183', 1717614029),
(26, 4, 2, '1', '0.114300', 1717614030),
(27, 4, 3, '1', '439.515000', 1717614030),
(28, 4, 5, '1', '0.636570', 1717614031),
(29, 4, 6, '1', '2693.826000', 1717614032),
(30, 4, 7, '1', '439.614000', 1717614032),
(31, 4, 8, '1', '834.966000', 1717614033),
(32, 4, 11, '1', '439.46', 1717614034),
(33, 5, 1, '1', '0.008741', 1717614035),
(34, 5, 2, '1', '0.161460', 1717614035),
(35, 5, 3, '1', '621.306000', 1717614036),
(36, 5, 4, '1', '1.271700', 1717614037),
(37, 5, 6, '1', '3805.992000', 1717614038),
(38, 5, 7, '1', '621.333000', 1717614039),
(39, 5, 8, '1', '1180.458000', 1717614040),
(40, 5, 11, '1', '621.30', 1717614040),
(41, 6, 1, '1', '0.000002', 1717614042),
(42, 6, 2, '1', '0.000038', 1717614043),
(43, 6, 3, '1', '0.146880', 1717614044),
(44, 6, 4, '1', '0.000301', 1717614044),
(45, 6, 5, '1', '0.000213', 1717614045),
(46, 6, 7, '1', '0.146880', 1717614046),
(47, 6, 8, '1', '0.279090', 1717614047),
(48, 6, 11, '1', '0.15', 1717614048),
(49, 7, 1, '1', '0.000013', 1717614048),
(50, 7, 2, '1', '0.000234', 1717614049),
(51, 7, 3, '1', '0.899910', 1717614050),
(52, 7, 4, '1', '0.001843', 1717614050),
(53, 7, 5, '1', '0.001303', 1717614051),
(54, 7, 6, '1', '5.513400', 1717614053),
(55, 7, 8, '1', '1.710000', 1717614054),
(56, 7, 11, '1', '0.90', 1717614054),
(57, 8, 1, '1', '0.000007', 1717614055),
(58, 8, 2, '1', '0.000123', 1717614056),
(59, 8, 3, '1', '0.473760', 1717614056),
(60, 8, 4, '1', '0.000970', 1717614057),
(61, 8, 5, '1', '0.000686', 1717614058),
(62, 8, 6, '1', '2.901600', 1717614058),
(63, 8, 7, '1', '0.473670', 1717614059),
(64, 8, 11, '1', '0.47', 1717614060),
(65, 11, 1, '78213.18', '1', 1717614060),
(66, 11, 2, '4232.31', '1', 1717614061),
(67, 11, 3, '1.10', '1', 1717614062),
(68, 11, 4, '537.19', '1', 1717614063),
(69, 11, 5, '759.48', '1', 1717614064),
(70, 11, 6, '0.18', '1', 1717614064),
(71, 11, 7, '1.10', '1', 1717614066),
(72, 11, 8, '0.58', '1', 1717614067),
(73, 11, 9, '1.1', '1.01', 1717614067),
(74, 11, 10, '1.36', '1.01', 1717614067),
(75, 1, 9, '1', '24711.40', 1717614067),
(76, 2, 9, '1', '1543.45', 1717614067),
(77, 2, 10, '1', '1358.06', 1717614067),
(78, 3, 9, '1.1', '1', 1717614067),
(79, 7, 9, '1.1', '1', 1717614067),
(80, 3, 10, '1.25', '1', 1717614067),
(81, 7, 10, '1.25', '1', 1717614067),
(82, 4, 9, '1', '104.80', 1717614067),
(83, 5, 9, '1', '263.06', 1717614067),
(84, 6, 9, '14.6', '1', 1717614067),
(85, 8, 9, '2.4', '1', 1717614067),
(86, 10, 9, '1', '1.03', 1717614067),
(87, 1, 10, '1', '21767.53', 1717614067),
(88, 4, 10, '1', '92.33', 1717614067),
(89, 5, 10, '1', '231.21', 1717614067),
(90, 6, 10, '16.65', '1', 1717614067),
(91, 8, 10, '2.712', '1', 1717614067),
(92, 9, 10, '1.24', '1', 1717614067),
(102, 10, 1, '26858.16', '1', 1717614067),
(93, 9, 1, '30273.36', '1', 1717614067),
(94, 9, 2, '2106.18', '1', 1717614067),
(95, 9, 3, '1', '1', 1717614067),
(96, 9, 4, '134.96', '1', 1717614067),
(97, 9, 5, '347.26', '1', 1717614067),
(98, 9, 6, '0.089', '1', 1717614067),
(99, 9, 7, '1', '1', 1717614067),
(100, 9, 8, '0.52', '1', 1717614067),
(101, 9, 11, '1', '1', 1681676105),
(103, 10, 2, '1872.26', '1', 1717614067),
(104, 10, 3, '0.88', '1', 1717614067),
(105, 10, 7, '0.88', '1', 1717614067),
(106, 10, 4, '119.54', '1', 1717614067),
(107, 10, 5, '308.55', '1', 1717614067),
(108, 10, 6, '0.079', '1', 1717614067),
(109, 10, 8, '0.46', '1', 1717614067),
(110, 10, 11, '1', '1.15', 1717614067);

-- --------------------------------------------------------

--
-- Table structure for table `ce_rates_saved`
--

CREATE TABLE `ce_rates_saved` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_from_prefix` varchar(255) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_reserve_requests`
--

CREATE TABLE `ce_reserve_requests` (
  `id` int(11) NOT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `requested_on` int(11) DEFAULT NULL,
  `updated_on` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_settings`
--

CREATE TABLE `ce_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `infoemail` varchar(255) DEFAULT NULL,
  `supportemail` varchar(255) DEFAULT NULL,
  `order_type` int(11) DEFAULT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `invest_plugin` int(11) DEFAULT NULL,
  `invest_insurance_plugin` int(11) DEFAULT NULL,
  `invest_insurance_fee` varchar(11) DEFAULT NULL,
  `invest_insurance_duration` int(11) DEFAULT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `default_template` varchar(255) DEFAULT NULL,
  `curcnv_api` varchar(255) DEFAULT NULL,
  `cryptocnv_api` varchar(255) DEFAULT NULL,
  `au_rate_int` int(11) DEFAULT NULL,
  `referral_comission` varchar(10) DEFAULT NULL,
  `referral_min_withdrawal` varchar(10) DEFAULT NULL,
  `show_operator_status` int(11) DEFAULT NULL,
  `operator_status` int(11) DEFAULT NULL,
  `show_worktime` int(11) DEFAULT NULL,
  `worktime_start` varchar(11) DEFAULT NULL,
  `worktime_end` varchar(11) DEFAULT NULL,
  `worktime_gmt` varchar(11) DEFAULT NULL,
  `enable_recaptcha` int(11) DEFAULT NULL,
  `recaptcha_publickey` varchar(255) DEFAULT NULL,
  `recaptcha_privatekey` varchar(255) DEFAULT NULL,
  `expire_uncompleted_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_settings`
--

INSERT INTO `ce_settings` (`id`, `title`, `description`, `keywords`, `name`, `url`, `infoemail`, `supportemail`, `order_type`, `purchase_code`, `invest_plugin`, `invest_insurance_plugin`, `invest_insurance_fee`, `invest_insurance_duration`, `default_language`, `default_template`, `curcnv_api`, `cryptocnv_api`, `au_rate_int`, `referral_comission`, `referral_min_withdrawal`, `show_operator_status`, `operator_status`, `show_worktime`, `worktime_start`, `worktime_end`, `worktime_gmt`, `enable_recaptcha`, `recaptcha_publickey`, `recaptcha_privatekey`, `expire_uncompleted_time`) VALUES
(1, 'CryptoBlue - Buy, Sell and Trade Cryptocurrency, Bitcoin is here!', 'CryptoBlue', 'CryptoBlue', 'CryptoBlue', 'https://cryptoblue.webextee.com/', 'info@webextee.com', 'info@webextee.com', NULL, NULL, NULL, NULL, NULL, NULL, 'English', 'LightExchanger', '91915b4d68d147dc2659', 'c5dc286838e241780aac1faaba0dca0d402168d1a72f0b4af93605b08ebb4821', 720, NULL, NULL, NULL, NULL, NULL, '10 AM', '10 PM', 'GMT-4', NULL, NULL, NULL, 3600);

-- --------------------------------------------------------

--
-- Table structure for table `ce_tickets`
--

CREATE TABLE `ce_tickets` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `served_level` int(11) DEFAULT NULL,
  `served_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_tickets_messages`
--

CREATE TABLE `ce_tickets_messages` (
  `id` int(11) NOT NULL,
  `tid` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_users`
--

CREATE TABLE `ce_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `email_hash` varchar(255) DEFAULT NULL,
  `email_verified` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `twoFA` int(11) DEFAULT NULL,
  `registered_on` varchar(255) DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday_date` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `mobile_verified` int(11) DEFAULT NULL,
  `document_verified` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `close_request` int(11) DEFAULT NULL,
  `discount_level` int(11) DEFAULT NULL,
  `invited_by` int(11) DEFAULT NULL,
  `exchanged_volume` int(11) DEFAULT NULL,
  `documents_pending` int(11) DEFAULT NULL,
  `wallet_id` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_users`
--

INSERT INTO `ce_users` (`id`, `email`, `username`, `password`, `password_hash`, `email_hash`, `email_verified`, `status`, `ip`, `twoFA`, `registered_on`, `last_login`, `first_name`, `last_name`, `birthday_date`, `country`, `city`, `zip_code`, `address`, `mobile_number`, `mobile_verified`, `document_verified`, `level`, `close_request`, `discount_level`, `invited_by`, `exchanged_volume`, `documents_pending`, `wallet_id`) VALUES
(1, 'info@virsymcoin.com', 'virsymcoin_admin', '$2y$10$.AHxg2xH8lVrUouC7fBzi.Q5MwwUUeRnku./gnxZoHxJwEuiIjxZi', NULL, NULL, NULL, 1, NULL, NULL, NULL, '1711623095', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'darioroberts@hotmail.com', '', '$2y$10$cSuj2OwUXjMG1ddUXuPMKu20AYkqF31oQUPAHm/u9wNGVsU3UI5ty', 'b49346c03aa2be409be4821ac', '28CB16', 1, 16, '24.231.57.56', 1, '1681308890', '1715024271', 'Dario', 'Roberts', '', '', '', '', '', '', 0, 1, 3, NULL, 0, NULL, 4420287, 0, 'VIRSM000002'),
(8, 'ranaali9320@gmail.com', '', '$2y$10$sJi7LPVvawt0fCLknGUZZ.i.RV8TRPDEBRCKph18TQ37vkxYKTs56', '', 'c0becb8f9b5479ec27e97eb4b', 1, 1, '122.161.67.14', 0, '1681321409', '1719162980', '', '', '', '', '', '', '', '', 0, 1, 3, NULL, 0, NULL, 500, 1, 'VIRSM000008'),
(9, 'support@virsymcoin.com', NULL, '$2y$10$kBJVZRCSz1VveM4bMz2sEOg2IdvY.vOvXQ0PfNlE2ZYiSJwE7HJpu', '', '', 1, 16, '64.150.226.23', 0, '1681479627', '1681479695', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 1, NULL),
(10, 'daniellecromer@yahoo.com', NULL, '$2y$10$BBR8KyzAjM7kR8b4XB6uA.GKbDllDnNxvH4nxfd58c/NWybcjuu1y', '', '', 1, 16, '108.60.227.16', 0, '1684518644', '1694486541', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000010'),
(11, 'ranaali93200@gmail.com', NULL, '$2y$10$KUEzho5JNqD0B/81PAQCT.vpNygXlHrom2A5LC2rpUUZ..7L5SUGC', '', 'e671f962bf6453fca91745110', 0, 16, '122.161.67.213', 0, '1684526834', '1717614286', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000011'),
(12, 'marcustrez@cyberservices.com', NULL, '$2y$10$29oom.XxdSjZAuH/v/jgt.iEmAM/YltnPWUTh3gY4F5cQ83XCVvTy', '', '', 1, 16, '193.36.224.144', 0, '1684885623', '1695819285', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000012'),
(13, 'wellbeingresources@mail.com', NULL, '$2y$10$t9D6TXOF12Fb2vnXpaKeOOKnyBRAaZV3/CDIl3vs7trgQrTDlj9/q', '', '', 1, 16, '104.234.53.89', 0, '1684953616', '1691161376', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 0, 'VIRSM000013'),
(14, 'jdrkerr@live.co.uk', NULL, '$2y$10$bzDUQITUlxIgvZmP0VE79.CGrJi/l2emecvENmW1DQch90Tyq11IC', '', '0426ae43e26060f7adda39c9c', 0, 16, '203.30.4.174', 0, '1686545485', '1692778532', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000014'),
(15, 'ali.asif@aspired.io', NULL, '$2y$10$V.r00i8Ymg88XdEezAXR5e7d90i4Ww1TUDjANSJGDv69PR.t1KF5m', '', '9b87c7b0bad538fa4ccc177c7', 0, 16, '117.20.31.210', 0, '1687298078', '1687298085', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000015'),
(16, 'k.springer@bluedotwealth.com', '', '$2y$10$JPzYOkfFzzue9CtH9tYOFuvHXBbgb5RQQPvo7N7pSY6JZ.jMDk.S2', '', '4b1cf8cc250ef7def74129308', 1, 16, '80.195.217.236', 0, '1687630968', '1687631261', '', '', '', '', '', '', '', '', 0, 1, 3, NULL, 0, NULL, 0, 1, 'VIRSM000016'),
(17, 'michael.atkinson@aspired.io', NULL, '$2y$10$Mfc47xUHxeIFds.4sWS90emcfiQBJ4rrRjarecWh70aSlQn2RYnFC', '', '', 1, 16, '175.107.203.68', 0, '1687807911', '1687807925', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000017'),
(18, 'wafa777a7@gmail.com', NULL, '$2y$10$T2XPWZRW5RbpHm7Nyj16HOULhnw59FyVFyyxwb2NQgitb/5wEQp5O', '', '', 1, 16, '70.34.251.243', 0, '1689627752', '1689627758', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000018'),
(19, 'Virginia73@gmail.com', NULL, '$2y$10$Cpu49YRmckTyzMOqbtB0OeqIO7TvcTdNM6ysk59ubRaUKHCEHY5ni', '', '06d576bafc2d9fcc58aca87b2', 0, 16, '127.0.0.1', 0, '1690677821', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000019'),
(20, 'fariha.anika@quantanite.com', NULL, '$2y$10$PUjEJabb1EurfyrEarPA.OiSES955cr0EJW5Jok98xEkaHabbUAkq', '', 'fddbc04c4cfda15dfaf46e2e0', 0, 16, '119.40.93.34', 0, '1690953187', '1690953207', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000020'),
(21, 'vs5822932@gmail.com', NULL, '$2y$10$K.T1SIXqabxEWZlwb77Dz.QPQ5as8VmbyD7uu/ESiBCdhvRm0ooKq', '', '', 1, 1, '64.120.123.48', 0, '1691774092', '1695307304', 'RAJENDRA', 'SHRESTHA', '11-07-1959', 'United States', 'Maryland', '20902', '807 STONINGTON RD SILVER SPRING MD', '+1 (646) 634-5070', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000021'),
(22, 'astridcapitalpartners@gmail.com', NULL, '$2y$10$eGlfd/3DPsJsMgxcOn2zt.VXreWF7YKtBKnXF.C5mr1CXxtuNns8i', '8d8ab04a1b59ef11203dfcda2', '24A299', 1, 1, '99.88.197.239', 1, '1694134724', '1699574009', 'Rebekah', 'Salaam', '08-11-1983', 'United States', 'La Jolla', '92037', '5580 La Jolla Blvd 358', '9492728995', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000022'),
(23, 'yusofhassan17@gmail.com', NULL, '$2y$10$Kf.dtct7m/Xy1NrGtxBr6uxk9my5U0y8i0YaY6gl789iy5/gKXpF.', '', '0009f26374daa8cbf28a269c2', 0, 16, '168.149.236.116', 0, '1694550342', '1694550352', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000023'),
(24, 'zqhmkm@vjuum.com', NULL, '$2y$10$UdDLDy8fUh8b5MQ51qmTdeWXz9RaRL2XBwddngeGrnnQcvatCBEhC', '', '73cf41abf0085da30c1563076', 0, 16, '213.6.153.7', 0, '1695808662', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000024'),
(25, '6bykxb@laafd.com', NULL, '$2y$10$1PMvnFfD2yBXbAHi7GFiauzebCmOVBl6Q18lYLZ.FcOtmx.XqmZDG', '', '2a774168c7083d4b48e331caa', 0, 16, '213.6.153.7', 1, '1695818524', '1695818601', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000025'),
(26, 'dmixx101@yahoo.com', NULL, '$2y$10$buRtH4sXSAZPbV7oHQoU5uiuvpp6uGc67pAAd4OxvAX3VjcnpmVPC', '', '4b8c97074a9935de8a0a4ec79', 0, 16, '102.90.44.64', 0, '1696266510', '1696266555', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000026'),
(28, 'derek8678@gmail.com', NULL, '$2y$10$uLcaZ0ma581I0Fs9QN7B..S2lWtD1vO3JhdqQMuLUJmsh2Rs9/D4C', '', '35d62cdc5eca3e3509f771c37', 0, 16, '98.188.33.122', 0, '1697219589', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000028'),
(29, 'Cesar583Lakin1988@alabamahomenetwoks.com', NULL, '$2y$10$xP1dAUSwdKEQ/oLsrALSWepu1RV4U9dQCRuiBe3wbRfmyv00HfxZu', '', '2026641a23164be34922fe812', 0, 16, '127.0.0.1', 0, '1697707857', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000029'),
(30, 'neil@brag-book.com', NULL, '$2y$10$Dz3WGF1plBTpb/vg4w0CgOPg3/hq6BFc5N8scIbIKKoxEEsSUGhYa', '', '22ed5be6ae090e72875856b28', 0, 16, '206.83.122.199', 0, '1698027424', '1698027431', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000030'),
(31, 'crwright1717@gmail.com', NULL, '$2y$10$BdVrm1xZN5Aa99tfUrFnz.B1CQ2uw3o9mjmdKclGYkr4oDMbe7ePK', '', '', 1, 16, '45.89.242.37', 0, '1698354948', '1698999235', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000031'),
(32, 'jamiexeatmon@gmail.com', NULL, '$2y$10$7BMzcGwqozjz70o79i3xneHflIPUL5wDGLSlp9bHbXDR57EoLWBVm', '', '63cd2aad8e7b75e7b1643be6d', 0, 16, '104.48.191.103', 0, '1699045904', '1699045935', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000032'),
(33, 'tania.treis@panoramaenvr.com', NULL, '$2y$10$uc0o0RLOao1pj.EQ1mCnju6K3GVUKhC/ETm/GbdA.hzvzsPoBKOhS', '', '', 1, 16, '45.130.83.77', 0, '1699471837', '1699471860', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000033'),
(34, 'chriswgrantjr@gmail.com', NULL, '$2y$10$2TqzyURPIEqQ0oAE8AR.RO.nMFBHXvuH4h8TGEsEiTkEJdLPiiZY2', '', '', 1, 1, '172.91.93.226', 0, '1699497091', '1699497130', 'Christopher', 'Grant', '03201992', 'United States', 'Torrance', '90504', '2100 West Redondo Beach Boulevard', '3108033973', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000034'),
(35, 'fatima.pashta@gmail.com', NULL, '$2y$10$Q7BEkP9rJ/VRhbKAQHSgUuidVA4.0WFkNZUclQR7iMTfv.7MWYJl6', '', '', 1, 16, '58.65.222.209', 0, '1701362705', '1701614826', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000035'),
(36, 'winnersonly.bah@gmail.com', NULL, '$2y$10$vtnrcFNzKrMMyQpGmOXkNe36D9BX1AK05PaWfDxpbm/8on1ydbPia', '', 'bc29445c07b21c35cc7b9bbfa', 0, 16, '204.236.64.119', 0, '1702175791', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000036'),
(37, 'd3elks2022@gmail.com', NULL, '$2y$10$yK5Fj/sQXZJVPeL1Ma7UMO8G6QGYMmPYnDEb0BcySyfLFOxBbKgCy', '', 'c09242c008e39674e4d2a3879', 0, 16, '105.41.105.251', 0, '1703111465', '1703111482', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000037'),
(38, 'altybox@outlook.com', NULL, '$2y$10$8mEQtXebpJ1Cxmde8FTLpexWwA2IFv/T/ZafpCZ/X7A41565X2.sq', '', '208c88e36fe1f0e74a2587f9e', 0, 16, '34.78.49.210', 0, '1704557885', '1704557922', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000038'),
(39, 'zevebahamas@gmail.com', NULL, '$2y$10$VJT7vvG7XBj.1zyopHyZ4uGk.DKd6AIzoYbS0GGXN4kXqm815GY7C', '', '', 1, 16, '24.51.69.254', 0, '1707069164', '1707069183', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, 1, 'VIRSM000039'),
(40, 'duncombedario@gmail.com', NULL, '$2y$10$KgplLmGyN9KVcL.YPkySYu0OOQ73gdG8BQki.rNLAUDMb1wL91HOG', '', '', 1, 16, '64.66.5.250', 0, '1707348822', '1707348865', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000040'),
(41, 'aa711mohammed@gmail.com', NULL, '$2y$10$5GjpO6466y0lsp0bdYVt0OHM/c3YAOqUOwPZH9EVl8ygQNqKxCfjm', '', 'e5c1bedcb81e728a412b95b10', 0, 16, '38.54.76.18', 0, '1708132636', '1708132657', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000041'),
(42, 'luckbox2019@protonmail.com', NULL, '$2y$10$0a.nI9MpIxm0cBZTwp6aieaQ..LPfIDaaMvLBtC3NPoitO0.akjfy', '', '234d984e664ba0202dba2c767', 0, 16, '104.225.112.165', 0, '1709592629', '1709592635', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000042'),
(43, 'luana.hoxha@icloud.com', NULL, '$2y$10$ZyFC5eD0HYQWVztzB9LlcOnbwPe1PTgb0awZq6WSa0tKMNGi8BEUe', '', '', 1, 16, '46.140.107.102', 0, '1710420721', '1710420786', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000043'),
(44, 'fasase@mail.com', NULL, '$2y$10$.tdwqkEqgd85Tfm2zi2nvuL2LMa8RJFEb50OnrkKzPgdhW1.n7Y3S', '', '2d567abd3d92753ade2653d94', 0, 16, '103.150.37.44', 0, '1711632775', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000044'),
(45, 'tinalee@mail.com', NULL, '$2y$10$1X.2vNV.5GCefA8KqlY7ZeW7ZeskX1xEWxMqv.lJNDZOftebHg0lG', '', 'c76b4eb4a82b245b05c6e837e', 0, 16, '107.149.200.21', 0, '1714067375', '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000045'),
(46, 'shillingscom@gmail.com', NULL, '$2y$10$a6awW1nxy5veLq9781iyaeL48Ak0atIZbVhXSDeuaU.h2sbPmdHCW', '', '3a56c53b7dad21d8fcfa0229b', 0, 16, '94.174.32.115', 0, '1714935612', '1715008016', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000046'),
(49, 'ab@gmail.com', NULL, '$2y$10$W2zHIgRDHJEJwCd5MYOiv.mWTIXDJUi2NYTS./IDZjHfCfflTt3B.', '', '390648d75b94efb1fb0202410', 0, 16, '114.130.152.234', 0, '1718712050', '1718712061', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 0, NULL, 0, NULL, 'VIRSM000049');

-- --------------------------------------------------------

--
-- Table structure for table `ce_users_documents`
--

CREATE TABLE `ce_users_documents` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `document_type` int(11) DEFAULT NULL,
  `document_path` text DEFAULT NULL,
  `uploaded` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_users_documents`
--

INSERT INTO `ce_users_documents` (`id`, `uid`, `document_type`, `document_path`, `uploaded`, `status`, `u_field_1`, `u_field_2`, `u_field_3`, `u_field_4`, `u_field_5`) VALUES
(1, 8, 1, 'fabbd6b03f74912a579d/8/bda7975f11f273f7748d.png', 1681329282, 1, '123', '2322', 'Screenshot_1772.png', '', ''),
(2, 8, 1, 'fabbd6b03f74912a579d/8/3bb0c612dee9d41aa28c.png', 1681329441, 1, '123', '2322', 'Screenshot_1772.png', '', ''),
(3, 8, 6, 'fabbd6b03f74912a579d/8/c1d68e33d2cde9f3ef81.png', 1681329479, 1, 'selfie', 'selfie', 'Screenshot_1772.png', '', ''),
(4, 8, 6, 'fabbd6b03f74912a579d/8/d2f73742413ec1d9af8b.png', 1681329620, 1, 'selfie', '', 'Screenshot_1772.png', '', ''),
(5, 2, 3, 'fabbd6b03f74912a579d/2/c8f565ad0424d6c433bf.png', 1681408750, 3, 'ER023422', 'See notes', 'Screenshot 2023-04-12 at 16-33-08 Virsymcoin.png', '', ''),
(6, 2, 6, 'fabbd6b03f74912a579d/2/812ac55ad73f98cb9a63.png', 1681408803, 3, 'ER023422', 'See attached', 'Screenshot 2023-04-12 at 15-37-03 Virsymcoin.png', '', ''),
(7, 2, 6, 'fabbd6b03f74912a579d/2/b837f3b46572cd844a1b.png', 1681408884, 3, 'ER023422', 'See attached', 'Screenshot 2023-04-12 at 15-37-03 Virsymcoin.png', '', ''),
(8, 9, 3, 'fabbd6b03f74912a579d/9/24f42728bec24c0ada66.png', 1681479817, 1, 'ER013423', '', 'Screenshot 2023-04-12 at 16-33-08 Virsymcoin.png', '', ''),
(9, 9, 6, 'fabbd6b03f74912a579d/9/a1a0db084667ccd26f31.png', 1681479845, 1, 'ER013423', '', 'Screenshot 2023-04-12 at 15-37-03 Virsymcoin.png', '', ''),
(10, 12, 3, 'fabbd6b03f74912a579d/12/0630c07b804b606917a3.jpg', 1684885846, 1, 'WQ637418', 'FIND ATTACHED SCANNED COPY OF PASSPORT', 'photo_2023-05-24_00-50-03.jpg', '', ''),
(11, 12, 6, 'fabbd6b03f74912a579d/12/33ee9f04396801a0db72.jpg', 1684895947, 1, 'WQ637418', 'priority Partners with Chairman dario roberts 24/05/2023', 'photo_2023-05-24_03-34-47.jpg', '', ''),
(12, 13, 6, 'fabbd6b03f74912a579d/13/ab3da9546e579d0ec9b4.jpg', 1684953853, 3, 'L535501566470', '', 'photo_2023-05-24_19-41-53.jpg', '', ''),
(13, 13, 6, 'fabbd6b03f74912a579d/13/5d8592672f211f8c7773.jpg', 1684966489, 3, '535072858', '', 'photo_2023-05-24_23-11-31.jpg', '', ''),
(14, 16, 3, 'fabbd6b03f74912a579d/16/5e88dbcdcf695648f5eb.jpeg', 1687631070, 1, '562261627', '', 'Passport.jpeg', '', ''),
(15, 21, 1, 'fabbd6b03f74912a579d/21/881628e7d6309e924c26.jpeg', 1691774569, 1, 'S-623-730-081-856', '', 'IMG_1411.jpeg', '', ''),
(16, 31, 4, 'fabbd6b03f74912a579d/31/c63a5160ad1af6d32efa.png', 1698355380, 1, 'WRIGH806049CR9NL04', '', 'Wright Front.png', '', ''),
(17, 22, 4, 'fabbd6b03f74912a579d/22/623382648c6261226b0c.jpeg', 1699574133, 1, 'B9069706', '', 'IMG_0785.jpeg', '', ''),
(18, 35, 1, 'fabbd6b03f74912a579d/35/7831a25c9a5167eed728.jpeg', 1701363516, 1, '3520274074469', '', 'WhatsApp Image 2023-03-11 at 8.49.45 AM.jpeg', '', ''),
(19, 35, 1, 'fabbd6b03f74912a579d/35/73568bdd35db01b46908.jpeg', 1701363942, 1, '3520274074469', '', 'WhatsApp Image 2023-03-11 at 8.49.45 AM.jpeg', '', ''),
(20, 39, 3, 'fabbd6b03f74912a579d/39/c4c558e795b841d77fe0.jpeg', 1707069412, 1, 'AA281999', '', 'WhatsApp Image 2024-02-04 at 12.54.31 PM.jpeg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ce_users_earnings`
--

CREATE TABLE `ce_users_earnings` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_users_reviews`
--

CREATE TABLE `ce_users_reviews` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `posted` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ce_users_reviews`
--

INSERT INTO `ce_users_reviews` (`id`, `uid`, `display_name`, `order_id`, `comment`, `status`, `type`, `posted`) VALUES
(1, 2, 'Crypto', 1000001, 'Love this site!', 1, 1, 1681410092),
(2, 2, 'BitGuy', 1000002, 'I like the speed, but I need you to up the amount to 10 million', 1, 1, 1681410588);

-- --------------------------------------------------------

--
-- Table structure for table `ce_users_withdrawals`
--

CREATE TABLE `ce_users_withdrawals` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `gateway` int(11) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `requested_on` int(11) DEFAULT NULL,
  `processed_on` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ce_user_wallets`
--

CREATE TABLE `ce_user_wallets` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT 0,
  `gateway_id` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `amount` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ce_user_wallets`
--

INSERT INTO `ce_user_wallets` (`id`, `uid`, `gateway_id`, `status`, `amount`) VALUES
(5, 8, 5, 1, '0.16507001'),
(6, 11, 5, 1, '0.40967999'),
(7, 8, 6, 1, '0.07492500'),
(8, 2, 5, 1, '200'),
(9, 2, 7, 1, '0'),
(10, 12, 5, 1, '0'),
(11, 12, 6, 1, '0'),
(12, 12, 7, 1, '0'),
(13, 12, 8, 1, '0'),
(14, 12, 9, 1, '0'),
(15, 12, 10, 1, '0'),
(16, 12, 11, 1, '0'),
(17, 12, 12, 1, '0'),
(18, 13, 5, 1, '0'),
(19, 13, 6, 1, '0'),
(20, 13, 7, 1, '0'),
(21, 13, 8, 1, '0'),
(22, 13, 9, 1, '0'),
(23, 13, 10, 1, '0'),
(24, 13, 11, 1, '0'),
(25, 13, 12, 1, '0'),
(26, 14, 5, 1, '0'),
(27, 14, 6, 1, '0'),
(28, 14, 7, 1, '0'),
(29, 14, 8, 1, '0'),
(30, 14, 9, 1, '0'),
(31, 14, 10, 1, '0'),
(32, 14, 11, 1, '0'),
(33, 14, 12, 1, '0'),
(34, 15, 5, 1, '0'),
(35, 15, 6, 1, '0'),
(36, 15, 7, 1, '0'),
(37, 15, 8, 1, '0'),
(38, 15, 9, 1, '0'),
(39, 15, 10, 1, '0'),
(40, 15, 11, 1, '0'),
(41, 15, 12, 1, '0'),
(42, 16, 5, 1, '0'),
(43, 16, 6, 1, '0'),
(44, 16, 7, 1, '0'),
(45, 16, 8, 1, '0'),
(46, 16, 9, 1, '0'),
(47, 16, 10, 1, '0'),
(48, 16, 11, 1, '0'),
(49, 16, 12, 1, '0'),
(50, 17, 5, 1, '0'),
(51, 17, 6, 1, '0'),
(52, 17, 7, 1, '0'),
(53, 17, 8, 1, '0'),
(54, 17, 9, 1, '0'),
(55, 17, 10, 1, '0'),
(56, 17, 11, 1, '0'),
(57, 17, 12, 1, '0'),
(58, 18, 5, 1, '0'),
(59, 18, 6, 1, '0'),
(60, 18, 7, 1, '0'),
(61, 18, 8, 1, '0'),
(62, 18, 9, 1, '0'),
(63, 18, 10, 1, '0'),
(64, 18, 11, 1, '0'),
(65, 18, 12, 1, '0'),
(66, 19, 5, 1, '0'),
(67, 19, 6, 1, '0'),
(68, 19, 7, 1, '0'),
(69, 19, 8, 1, '0'),
(70, 19, 9, 1, '0'),
(71, 19, 10, 1, '0'),
(72, 19, 11, 1, '0'),
(73, 19, 12, 1, '0'),
(74, 20, 5, 1, '0'),
(75, 20, 6, 1, '0'),
(76, 20, 7, 1, '0'),
(77, 20, 8, 1, '0'),
(78, 20, 9, 1, '0'),
(79, 20, 10, 1, '0'),
(80, 20, 11, 1, '0'),
(81, 20, 12, 1, '0'),
(82, 21, 5, 1, '0'),
(83, 21, 6, 1, '0'),
(84, 21, 7, 1, '0'),
(85, 21, 8, 1, '0'),
(86, 21, 9, 1, '0'),
(87, 21, 10, 1, '0'),
(88, 21, 11, 1, '0'),
(89, 21, 12, 1, '0'),
(90, 22, 5, 1, '0'),
(91, 22, 6, 1, '0'),
(92, 22, 7, 1, '0'),
(93, 22, 8, 1, '0'),
(94, 22, 9, 1, '0'),
(95, 22, 10, 1, '0'),
(96, 22, 11, 1, '0'),
(97, 22, 12, 1, '0'),
(98, 23, 5, 1, '0'),
(99, 23, 6, 1, '0'),
(100, 23, 7, 1, '0'),
(101, 23, 8, 1, '0'),
(102, 23, 9, 1, '0'),
(103, 23, 10, 1, '0'),
(104, 23, 11, 1, '0'),
(105, 23, 12, 1, '0'),
(106, 24, 5, 1, '0'),
(107, 24, 6, 1, '0'),
(108, 24, 7, 1, '0'),
(109, 24, 8, 1, '0'),
(110, 24, 9, 1, '0'),
(111, 24, 10, 1, '0'),
(112, 24, 11, 1, '0'),
(113, 24, 12, 1, '0'),
(114, 25, 5, 1, '0'),
(115, 25, 6, 1, '0'),
(116, 25, 7, 1, '0'),
(117, 25, 8, 1, '0'),
(118, 25, 9, 1, '0'),
(119, 25, 10, 1, '0'),
(120, 25, 11, 1, '0'),
(121, 25, 12, 1, '0'),
(122, 26, 5, 1, '0'),
(123, 26, 6, 1, '0'),
(124, 26, 7, 1, '0'),
(125, 26, 8, 1, '0'),
(126, 26, 9, 1, '0'),
(127, 26, 10, 1, '0'),
(128, 26, 11, 1, '0'),
(129, 26, 12, 1, '0'),
(130, 27, 5, 1, '0'),
(131, 27, 6, 1, '0'),
(132, 27, 7, 1, '0'),
(133, 27, 8, 1, '0'),
(134, 27, 9, 1, '0'),
(135, 27, 10, 1, '0'),
(136, 27, 11, 1, '0'),
(137, 27, 12, 1, '0'),
(138, 28, 5, 1, '0'),
(139, 28, 6, 1, '0'),
(140, 28, 7, 1, '0'),
(141, 28, 8, 1, '0'),
(142, 28, 9, 1, '0'),
(143, 28, 10, 1, '0'),
(144, 28, 11, 1, '0'),
(145, 28, 12, 1, '0'),
(146, 29, 5, 1, '0'),
(147, 29, 6, 1, '0'),
(148, 29, 7, 1, '0'),
(149, 29, 8, 1, '0'),
(150, 29, 9, 1, '0'),
(151, 29, 10, 1, '0'),
(152, 29, 11, 1, '0'),
(153, 29, 12, 1, '0'),
(154, 30, 5, 1, '0'),
(155, 30, 6, 1, '0'),
(156, 30, 7, 1, '0'),
(157, 30, 8, 1, '0'),
(158, 30, 9, 1, '0'),
(159, 30, 10, 1, '0'),
(160, 30, 11, 1, '0'),
(161, 30, 12, 1, '0'),
(162, 31, 5, 1, '0'),
(163, 31, 6, 1, '0'),
(164, 31, 7, 1, '0'),
(165, 31, 8, 1, '0'),
(166, 31, 9, 1, '0'),
(167, 31, 10, 1, '0'),
(168, 31, 11, 1, '0'),
(169, 31, 12, 1, '0'),
(170, 32, 5, 1, '0'),
(171, 32, 6, 1, '0'),
(172, 32, 7, 1, '0'),
(173, 32, 8, 1, '0'),
(174, 32, 9, 1, '0'),
(175, 32, 10, 1, '0'),
(176, 32, 11, 1, '0'),
(177, 32, 12, 1, '0'),
(178, 33, 5, 1, '0'),
(179, 33, 6, 1, '0'),
(180, 33, 7, 1, '0'),
(181, 33, 8, 1, '0'),
(182, 33, 9, 1, '0'),
(183, 33, 10, 1, '0'),
(184, 33, 11, 1, '0'),
(185, 33, 12, 1, '0'),
(186, 34, 5, 1, '0'),
(187, 34, 6, 1, '0'),
(188, 34, 7, 1, '0'),
(189, 34, 8, 1, '0'),
(190, 34, 9, 1, '0'),
(191, 34, 10, 1, '0'),
(192, 34, 11, 1, '0'),
(193, 34, 12, 1, '0'),
(194, 35, 5, 1, '0'),
(195, 35, 6, 1, '0'),
(196, 35, 7, 1, '0'),
(197, 35, 8, 1, '0'),
(198, 35, 9, 1, '0'),
(199, 35, 10, 1, '0'),
(200, 35, 11, 1, '0'),
(201, 35, 12, 1, '0'),
(202, 36, 5, 1, '0'),
(203, 36, 6, 1, '0'),
(204, 36, 7, 1, '0'),
(205, 36, 8, 1, '0'),
(206, 36, 9, 1, '0'),
(207, 36, 10, 1, '0'),
(208, 36, 11, 1, '0'),
(209, 36, 12, 1, '0'),
(210, 37, 5, 1, '0'),
(211, 37, 6, 1, '0'),
(212, 37, 7, 1, '0'),
(213, 37, 8, 1, '0'),
(214, 37, 9, 1, '0'),
(215, 37, 10, 1, '0'),
(216, 37, 11, 1, '0'),
(217, 37, 12, 1, '0'),
(218, 38, 5, 1, '0'),
(219, 38, 6, 1, '0'),
(220, 38, 7, 1, '0'),
(221, 38, 8, 1, '0'),
(222, 38, 9, 1, '0'),
(223, 38, 10, 1, '0'),
(224, 38, 11, 1, '0'),
(225, 38, 12, 1, '0'),
(226, 39, 5, 1, '0'),
(227, 39, 6, 1, '0'),
(228, 39, 7, 1, '0'),
(229, 39, 8, 1, '0'),
(230, 39, 9, 1, '0'),
(231, 39, 10, 1, '0'),
(232, 39, 11, 1, '0'),
(233, 39, 12, 1, '0'),
(234, 40, 5, 1, '0'),
(235, 40, 6, 1, '0'),
(236, 40, 7, 1, '0'),
(237, 40, 8, 1, '0'),
(238, 40, 9, 1, '0'),
(239, 40, 10, 1, '0'),
(240, 40, 11, 1, '0'),
(241, 40, 12, 1, '0'),
(242, 41, 5, 1, '0'),
(243, 41, 6, 1, '0'),
(244, 41, 7, 1, '0'),
(245, 41, 8, 1, '0'),
(246, 41, 9, 1, '0'),
(247, 41, 10, 1, '0'),
(248, 41, 11, 1, '0'),
(249, 41, 12, 1, '0'),
(250, 42, 5, 1, '0'),
(251, 42, 6, 1, '0'),
(252, 42, 7, 1, '0'),
(253, 42, 8, 1, '0'),
(254, 42, 9, 1, '0'),
(255, 42, 10, 1, '0'),
(256, 42, 11, 1, '0'),
(257, 42, 12, 1, '0'),
(258, 43, 5, 1, '0'),
(259, 43, 6, 1, '0'),
(260, 43, 7, 1, '0'),
(261, 43, 8, 1, '0'),
(262, 43, 9, 1, '0'),
(263, 43, 10, 1, '0'),
(264, 43, 11, 1, '0'),
(265, 43, 12, 1, '0'),
(266, 11, 7, 1, '0'),
(267, 11, 6, 1, '0'),
(268, 44, 5, 1, '0'),
(269, 44, 6, 1, '0'),
(270, 44, 7, 1, '0'),
(271, 44, 8, 1, '0'),
(272, 44, 9, 1, '0'),
(273, 44, 10, 1, '0'),
(274, 44, 11, 1, '0'),
(275, 44, 12, 1, '0'),
(276, 45, 5, 1, '0'),
(277, 45, 6, 1, '0'),
(278, 45, 7, 1, '0'),
(279, 45, 8, 1, '0'),
(280, 45, 9, 1, '0'),
(281, 45, 10, 1, '0'),
(282, 45, 11, 1, '0'),
(283, 45, 12, 1, '0'),
(284, 46, 5, 1, '0'),
(285, 46, 6, 1, '0'),
(286, 46, 7, 1, '0'),
(287, 46, 8, 1, '0'),
(288, 46, 9, 1, '0'),
(289, 46, 10, 1, '0'),
(290, 46, 11, 1, '0'),
(291, 46, 12, 1, '0'),
(292, 47, 5, 1, '0'),
(293, 47, 6, 1, '0'),
(294, 47, 7, 1, '0'),
(295, 47, 8, 1, '0'),
(296, 47, 9, 1, '0'),
(297, 47, 10, 1, '0'),
(298, 47, 11, 1, '0'),
(299, 47, 12, 1, '0'),
(300, 48, 5, 1, '0'),
(301, 48, 6, 1, '0'),
(302, 48, 7, 1, '0'),
(303, 48, 8, 1, '0'),
(304, 48, 9, 1, '0'),
(305, 48, 10, 1, '0'),
(306, 48, 11, 1, '0'),
(307, 48, 12, 1, '0'),
(308, 8, 11, 1, '0'),
(309, 49, 5, 1, '0'),
(310, 49, 6, 1, '0'),
(311, 49, 7, 1, '0'),
(312, 49, 8, 1, '0'),
(313, 49, 9, 1, '0'),
(314, 49, 10, 1, '0'),
(315, 49, 11, 1, '0'),
(316, 49, 12, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `ce_wallet_deposit`
--

CREATE TABLE `ce_wallet_deposit` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT 0,
  `wallet_id` int(11) DEFAULT 0,
  `gateway_id` int(11) DEFAULT 0,
  `amount` double DEFAULT 0,
  `receive_amount` double DEFAULT 0,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created` int(11) DEFAULT 0,
  `receipt` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ce_wallet_deposit`
--

INSERT INTO `ce_wallet_deposit` (`id`, `uid`, `wallet_id`, `gateway_id`, `amount`, `receive_amount`, `transaction_id`, `status`, `created`, `receipt`) VALUES
(4, 8, 5, 5, 1, 1, '************', 1, 1684526636, ''),
(5, 8, 7, 6, 5, 5, '***************', 1, 1684528799, ''),
(6, 2, 8, 5, 200, 200, 'Erjghbaj23ngnp0', 1, 1684576453, ''),
(7, 2, 8, 5, 400, 0, 'swiruthcnvo!', 0, 1684576625, ''),
(8, 2, 9, 7, 1000, 0, 'wq3948jhsu23orj!', 0, 1684576866, '');

-- --------------------------------------------------------

--
-- Table structure for table `ce_wallet_gateways`
--

CREATE TABLE `ce_wallet_gateways` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `wallet_id` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `fees` double NOT NULL DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `created` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ce_wallet_gateways`
--

INSERT INTO `ce_wallet_gateways` (`id`, `name`, `currency`, `wallet_id`, `icon`, `fees`, `status`, `created`) VALUES
(5, 'Bitcoin', 'BTC', '1jKQWBcQczr92gMgEvkMk36iXZhshqwHz', 'uploads/1684526571_icon.png', 6, 1, 1684575927),
(6, 'Binance Coin', 'BNB', 'bnb1ulxjsqkdpem56axc5sqljuwe7wya3j0x042cwg', 'uploads/1684528752_icon.png', 6, 1, 1684576170),
(7, 'Ethereum', 'ETH', '0x4dCbA2817Eb590fFcB074849B979212001EA3951', 'uploads/1684575781_icon.png', 6, 1, 1684575938),
(8, 'Bitcoin Cash', 'BCH', 'qrysp6ag9fyecfykx0ga6n7z4udwd3vypyr7yaeq6y', 'uploads/', 6, 1, 1684576013),
(9, 'USDC', 'USDC', '0x4dCbA2817Eb590fFcB074849B979212001EA3951', 'uploads/', 6, 1, 1684576083),
(10, 'DogeCoin', 'DOGE', 'DFSF9JikAJ8ZYhjzbs4Qw1XmpAKwC7JMas', 'uploads/', 6, 1, 1684576222),
(11, 'USDT', 'USDT', '0x4dCbA2817Eb590fFcB074849B979212001EA3951', 'uploads/', 6, 1, 1684576285),
(12, 'Ripple Labs', 'XRP', 'rG6sEJkjAAzSET11KJdPGDMgyWXhGE4yoP', 'uploads/', 6, 1, 1684576360);

-- --------------------------------------------------------

--
-- Table structure for table `ce_wallet_transfer`
--

CREATE TABLE `ce_wallet_transfer` (
  `id` int(11) NOT NULL,
  `from` int(11) DEFAULT 0,
  `to` int(11) DEFAULT 0,
  `amount` double DEFAULT 0,
  `wallet_id` varchar(255) DEFAULT '0',
  `gateway_id` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `created` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ce_wallet_transfer`
--

INSERT INTO `ce_wallet_transfer` (`id`, `from`, `to`, `amount`, `wallet_id`, `gateway_id`, `status`, `created`) VALUES
(1, 8, 11, 0.58624792, 'VIRSM000011', 5, 1, 1684526888),
(2, 8, 11, 0.1, 'VIRSM000011', 5, 1, 1684529151);

-- --------------------------------------------------------

--
-- Table structure for table `ce_wallet_withdraw`
--

CREATE TABLE `ce_wallet_withdraw` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT 0,
  `wallet_id` int(11) DEFAULT 0,
  `gateway_id` varchar(45) DEFAULT '0',
  `wallet_address` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT 0,
  `fees` double NOT NULL DEFAULT 0,
  `total_receive` double NOT NULL DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `created` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ce_wallet_withdraw`
--

INSERT INTO `ce_wallet_withdraw` (`id`, `uid`, `wallet_id`, `gateway_id`, `wallet_address`, `amount`, `fees`, `total_receive`, `status`, `created`) VALUES
(1, 8, 5, '5', 'unf67iygu574rty5rttvt5re5uxgg5he5hv', 0.05, 5, 0.0475, 1, 1684526731),
(2, 8, 7, '6', 'unf67iygu574rty5rttvt5re5uxgg5he5hv', 0.005, 2, 0.0049, 1, 1684528984);

-- --------------------------------------------------------

--
-- Table structure for table `ce_xmlrates`
--

CREATE TABLE `ce_xmlrates` (
  `id` int(11) NOT NULL,
  `gateway_from` int(11) DEFAULT NULL,
  `gateway_from_prefix` varchar(255) DEFAULT NULL,
  `gateway_to` int(11) DEFAULT NULL,
  `gateway_to_prefix` varchar(255) DEFAULT NULL,
  `rate_from` varchar(255) DEFAULT NULL,
  `rate_to` varchar(255) DEFAULT NULL,
  `automatic_rate` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ce_discount_system`
--
ALTER TABLE `ce_discount_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_faq`
--
ALTER TABLE `ce_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_gateways`
--
ALTER TABLE `ce_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_gateways_directions`
--
ALTER TABLE `ce_gateways_directions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_gateways_fields`
--
ALTER TABLE `ce_gateways_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_gateways_rules`
--
ALTER TABLE `ce_gateways_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_active`
--
ALTER TABLE `ce_invest_active`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_balances`
--
ALTER TABLE `ce_invest_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_deposits`
--
ALTER TABLE `ce_invest_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_earnings`
--
ALTER TABLE `ce_invest_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_plans`
--
ALTER TABLE `ce_invest_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_invest_withdrawals`
--
ALTER TABLE `ce_invest_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_news`
--
ALTER TABLE `ce_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_operators`
--
ALTER TABLE `ce_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_operators_activity`
--
ALTER TABLE `ce_operators_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_orders`
--
ALTER TABLE `ce_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_orders_attachments`
--
ALTER TABLE `ce_orders_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_orders_values`
--
ALTER TABLE `ce_orders_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_pages`
--
ALTER TABLE `ce_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_rates`
--
ALTER TABLE `ce_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_rates_live`
--
ALTER TABLE `ce_rates_live`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_rates_saved`
--
ALTER TABLE `ce_rates_saved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_reserve_requests`
--
ALTER TABLE `ce_reserve_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_settings`
--
ALTER TABLE `ce_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_tickets`
--
ALTER TABLE `ce_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_tickets_messages`
--
ALTER TABLE `ce_tickets_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_users`
--
ALTER TABLE `ce_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_users_documents`
--
ALTER TABLE `ce_users_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_users_earnings`
--
ALTER TABLE `ce_users_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_users_reviews`
--
ALTER TABLE `ce_users_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_users_withdrawals`
--
ALTER TABLE `ce_users_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_user_wallets`
--
ALTER TABLE `ce_user_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_wallet_deposit`
--
ALTER TABLE `ce_wallet_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_wallet_gateways`
--
ALTER TABLE `ce_wallet_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_wallet_transfer`
--
ALTER TABLE `ce_wallet_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_wallet_withdraw`
--
ALTER TABLE `ce_wallet_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_xmlrates`
--
ALTER TABLE `ce_xmlrates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ce_discount_system`
--
ALTER TABLE `ce_discount_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_faq`
--
ALTER TABLE `ce_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_gateways`
--
ALTER TABLE `ce_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ce_gateways_directions`
--
ALTER TABLE `ce_gateways_directions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ce_gateways_fields`
--
ALTER TABLE `ce_gateways_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ce_gateways_rules`
--
ALTER TABLE `ce_gateways_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_invest_active`
--
ALTER TABLE `ce_invest_active`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `ce_invest_balances`
--
ALTER TABLE `ce_invest_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_invest_deposits`
--
ALTER TABLE `ce_invest_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `ce_invest_earnings`
--
ALTER TABLE `ce_invest_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_invest_plans`
--
ALTER TABLE `ce_invest_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `ce_invest_withdrawals`
--
ALTER TABLE `ce_invest_withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `ce_news`
--
ALTER TABLE `ce_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ce_operators`
--
ALTER TABLE `ce_operators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_operators_activity`
--
ALTER TABLE `ce_operators_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_orders`
--
ALTER TABLE `ce_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000016;

--
-- AUTO_INCREMENT for table `ce_orders_attachments`
--
ALTER TABLE `ce_orders_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ce_orders_values`
--
ALTER TABLE `ce_orders_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_pages`
--
ALTER TABLE `ce_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ce_rates`
--
ALTER TABLE `ce_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `ce_rates_live`
--
ALTER TABLE `ce_rates_live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `ce_rates_saved`
--
ALTER TABLE `ce_rates_saved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_reserve_requests`
--
ALTER TABLE `ce_reserve_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_settings`
--
ALTER TABLE `ce_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ce_tickets`
--
ALTER TABLE `ce_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `ce_tickets_messages`
--
ALTER TABLE `ce_tickets_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_users`
--
ALTER TABLE `ce_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `ce_users_documents`
--
ALTER TABLE `ce_users_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ce_users_earnings`
--
ALTER TABLE `ce_users_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_users_reviews`
--
ALTER TABLE `ce_users_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ce_users_withdrawals`
--
ALTER TABLE `ce_users_withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ce_user_wallets`
--
ALTER TABLE `ce_user_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT for table `ce_wallet_deposit`
--
ALTER TABLE `ce_wallet_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ce_wallet_gateways`
--
ALTER TABLE `ce_wallet_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ce_wallet_transfer`
--
ALTER TABLE `ce_wallet_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ce_wallet_withdraw`
--
ALTER TABLE `ce_wallet_withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ce_xmlrates`
--
ALTER TABLE `ce_xmlrates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
