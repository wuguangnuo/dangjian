-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-02 15:54:25
-- 服务器版本： 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dangjian`
--

-- --------------------------------------------------------

--
-- 表的结构 `dj_dangfei`
--

CREATE TABLE `dj_dangfei` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '党费编号',
  `name` varchar(32) NOT NULL COMMENT '党费名称',
  `price` decimal(18,2) NOT NULL COMMENT '应缴金额',
  `date` datetime NOT NULL COMMENT '发布日期',
  -- 是否需要截止日期？
  `mark` varchar(200) NOT NULL COMMENT '党费备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建党费表';

--
-- 转存表中的数据 `dj_dangfei`
--

INSERT INTO `dj_dangfei` (`id`, `name`, `price`, `date`, `mark`) VALUES
(1, '第一次', '10.00', '2015-10-01 08:23:21', '第一次党费'),
(2, '第二次', '15.00', '2016-06-06 13:19:00', '2016年第一次'),
(3, '第三次', '25.50', '2016-10-10 12:11:50', '2016年第二次党费'),
(4, '第四次', '12.12', '2016-11-11 08:18:37', 'mark_4'),
(5, '第五次', '5.00', '2017-06-06 11:34:19', 'mark_5'),
(6, '第六次', '100.05', '2017-12-01 07:21:22', '测试录入第六次党费'),
(7, '第七次', '55.81', '2017-12-17 14:02:56', '备注党费名称A'),
(8, '第八次', '88.88', '2017-12-23 20:35:28', '备注8');

-- --------------------------------------------------------

--
-- 表的结构 `dj_jiaona`
--

CREATE TABLE `dj_jiaona` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '缴纳编号',
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `dangfeiid` int(12) NOT NULL COMMENT '党费编号',
  `date` datetime DEFAULT NULL COMMENT '缴纳时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党费缴纳表';

--
-- 转存表中的数据 `dj_jiaona`
--

INSERT INTO `dj_jiaona` (`id`, `user_id`, `dangfeiid`, `date`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 1, '2017-11-01 10:23:26'),
(2, '21232f297a57a5a743894a0e4a801fc3', 2, '2017-11-02 09:23:23'),
(3, '5a105e8b9d40e1329780d62ea2265d8a', 3, '2017-12-03 00:00:00'),
(4, '21232f297a57a5a743894a0e4a801fc3', 6, '2017-12-07 00:00:00'),
(5, '5a105e8b9d40e1329780d62ea2265d8a', 5, '2017-12-07 00:00:00'),
(6, '5a105e8b9d40e1329780d62ea2265d8a', 4, '2017-12-07 00:00:00'),
(11, '4f1a6d6caf78c98ff7d75033aff90bca', 6, '2017-12-09 00:00:00'),
(12, 'eab5fa7518f8d18a5086dabf21b180f1', 7, '2017-12-16 00:00:00'),
(13, 'c1450ac61575b90357c45ce8a9c8926c', 7, '2017-12-16 00:00:00'),
(14, '257917786ed54d6008719c101c0126ff', 8, '2017-12-27 12:12:00'),
(15, '257917786ed54d6008719c101c0126ff', 7, '2017-12-27 00:00:00'),
(16, '257917786ed54d6008719c101c0126ff', 6, '2017-12-01 00:00:00'),
(17, '21232f297a57a5a743894a0e4a801fc3', 8, '2018-01-02 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `dj_lesson`
--

CREATE TABLE `dj_lesson` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '课程编号',
  `name` varchar(32) NOT NULL COMMENT '课程名称',
  `detail` varchar(200) DEFAULT NULL COMMENT '课程详情',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `mark` varchar(200) DEFAULT NULL COMMENT '课程备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建课程表';

--
-- 转存表中的数据 `dj_lesson`
--

INSERT INTO `dj_lesson` (`id`, `name`, `detail`, `created_at`, `mark`) VALUES
(1, '第一堂课', '这是第一次在线学习详情', '2017-12-10 11:11:11', '这里是备注'),
(2, '第二次课程', '这是第二次在线学习详情', '2017-12-10 12:00:00', '备注2'),
(3, '必修课程A', '必修课程A详情', '2017-12-20 22:39:36', '必修课程A备注'),
(4, 'test4', NULL, '2017-12-21 00:00:00', NULL),
(5, 'test5', NULL, '2017-12-21 00:00:00', NULL),
(6, 'test6', NULL, '2017-12-21 00:00:00', NULL),
(7, 'test7', NULL, '2017-12-21 00:00:00', NULL),
(8, 'test8', NULL, '2017-12-21 00:00:00', NULL),
(9, 'test9', NULL, '2017-12-21 00:00:00', NULL),
(10, 'test10', NULL, '2017-12-21 00:00:00', NULL),
(11, 'test11', NULL, '2017-12-21 00:00:00', NULL),
(12, 'test12', NULL, '2017-12-21 00:00:00', NULL),
(13, '13区', '13区很恐怖', '2017-12-25 21:45:16', '课程十三备注');

-- --------------------------------------------------------

--
-- 表的结构 `dj_study`
--

CREATE TABLE `dj_study` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '学习编号',
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `lessonid` int(12) NOT NULL COMMENT '课程编号',
  `date` datetime DEFAULT NULL COMMENT '首次进入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建学习情况表';

--
-- 转存表中的数据 `dj_study`
--

INSERT INTO `dj_study` (`id`, `user_id`, `lessonid`, `date`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 1, '2017-12-17 14:18:53'),
(2, '5a105e8b9d40e1329780d62ea2265d8a', 1, '2017-12-17 14:19:17'),
(3, '21232f297a57a5a743894a0e4a801fc3', 2, '2017-12-17 17:32:03'),
(4, '5a105e8b9d40e1329780d62ea2265d8a', 3, '2017-12-20 22:41:09'),
(5, '21232f297a57a5a743894a0e4a801fc3', 3, '2017-12-21 20:48:48'),
(6, '21232f297a57a5a743894a0e4a801fc3', 49, '2017-12-22 12:54:05'),
(7, '5a105e8b9d40e1329780d62ea2265d8a', 50, '2017-12-22 23:06:34'),
(8, '21232f297a57a5a743894a0e4a801fc3', 36, '2017-12-23 11:09:00'),
(9, '21232f297a57a5a743894a0e4a801fc3', 50, '2017-12-23 14:33:38'),
(10, '21232f297a57a5a743894a0e4a801fc3', 42, '2017-12-23 19:41:05'),
(11, '5a105e8b9d40e1329780d62ea2265d8a', 49, '2017-12-23 19:50:54'),
(12, '5a105e8b9d40e1329780d62ea2265d8a', 38, '2017-12-23 19:51:03'),
(13, '5a105e8b9d40e1329780d62ea2265d8a', 37, '2017-12-23 19:51:17'),
(14, '5a105e8b9d40e1329780d62ea2265d8a', 30, '2017-12-23 19:51:38'),
(15, '5a105e8b9d40e1329780d62ea2265d8a', 46, '2017-12-23 19:52:49'),
(16, '5a105e8b9d40e1329780d62ea2265d8a', 4, '2017-12-25 21:36:14'),
(17, '5a105e8b9d40e1329780d62ea2265d8a', 51, '2017-12-25 21:45:47'),
(18, 'ad0234829205b9033196ba818f7a872b', 50, '2017-12-31 09:59:18'),
(19, 'ad0234829205b9033196ba818f7a872b', 49, '2017-12-31 09:59:29'),
(20, 'ad0234829205b9033196ba818f7a872b', 1, '2017-12-31 10:16:53'),
(21, 'ad0234829205b9033196ba818f7a872b', 3, '2017-12-31 10:16:59'),
(22, 'ad0234829205b9033196ba818f7a872b', 2, '2017-12-31 12:52:28'),
(23, 'ad0234829205b9033196ba818f7a872b', 51, '2017-12-31 12:57:42'),
(24, 'ad0234829205b9033196ba818f7a872b', 4, '2017-12-31 12:57:58'),
(25, 'ad0234829205b9033196ba818f7a872b', 5, '2017-12-31 12:58:09'),
(26, 'ad0234829205b9033196ba818f7a872b', 6, '2017-12-31 12:58:13');

-- --------------------------------------------------------

--
-- 表的结构 `dj_users`
--

CREATE TABLE `dj_users` (
  `id` int(12) UNSIGNED NOT NULL PRIMARY KEY COMMENT '用户编号',
  `user_id` char(32) NOT NULL COMMENT '用户登陆名username的MD5值',
  `username` varchar(32) NOT NULL COMMENT '用户登陆名,学号',
  `password` char(32) NOT NULL COMMENT '用户密码的MD5值',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `sex` char(2) DEFAULT NULL COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `college` varchar(80) DEFAULT NULL COMMENT '所在学院',
  `volk` varchar(10) DEFAULT NULL COMMENT '民族',
  `phone` bigint(11) DEFAULT NULL COMMENT '电话号码',
  `email` varchar(80) NOT NULL COMMENT '邮箱',
  `address` varchar(80) DEFAULT NULL COMMENT '地址',
  `roleid` int(1) NOT NULL DEFAULT '0' COMMENT '权限判定,默认为0',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后一次修改时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='党建用户表';

--
-- 转存表中的数据 `dj_users`
--

INSERT INTO `dj_users` (`id`, `user_id`, `username`, `password`, `name`, `sex`, `birthday`, `idcard`, `college`, `volk`, `phone`, `email`, `address`, `roleid`, `created_at`, `updated_at`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '管理员', '男', '2017-11-11', '12312320171111666X', NULL, NULL, 18866669999, 'admin@soooo.club', '北京市朝阳区', 1, '2017-11-29 00:00:00', NULL),
(2, '5a105e8b9d40e1329780d62ea2265d8a', 'test1', 'e10adc3949ba59abbe56e057f20f883e', '测试1', '女', '2017-11-03', '13118120171001666X', '华侨大学计算机科学与技术学院网络工程2班', '汉', 13646019112, 'test@163.com', '厦门市集美区兑山小学', 0, '2017-11-01 00:00:00', '2017-12-23 16:41:33'),
(10, 'ad0234829205b9033196ba818f7a872b', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '测试2', '女', '2017-12-12', '11122220171206333X', '家里蹲大学', '苗族', 10086, 'admin@wuguangnuo.cn', '下水道', 0, '2017-12-05 13:07:15', '2017-12-11 16:37:27'),
(12, 'c1450ac61575b90357c45ce8a9c8926c', '1425132026', '698d51a19d8a121ce581499d7b701668', '诺诺123', '女', '2017-12-16', '123456789987654321', '华大', '汉', 110, '123@456.789', '天安门', 0, '2017-12-09 19:10:16', '2017-12-16 18:00:14'),
(13, '4f1a6d6caf78c98ff7d75033aff90bca', '1425132003', 'e10adc3949ba59abbe56e057f20f883e', '张三', '', NULL, '', NULL, NULL, 0, '003@188.com', NULL, 0, '2017-12-09 19:12:14', NULL),
(14, 'eab5fa7518f8d18a5086dabf21b180f1', '1425132004', 'e10adc3949ba59abbe56e057f20f883e', '李四', '', NULL, '', NULL, NULL, 0, 'lisi@soooo.club', NULL, 0, '2017-12-13 21:42:22', NULL),
(15, '202cb962ac59075b964b07152d234b70', '1425132005', 'e10adc3949ba59abbe56e057f20f883e', '123', '女', '0000-00-00', '', '', '', 0, '123', '', 0, '2017-12-20 23:32:17', '2017-12-23 15:11:14'),
(17, 'dbc4d84bfcfe2284ba11beffb853a8c4', '1425132006', 'dbc4d84bfcfe2284ba11beffb853a8c4', '5555', '男', '0000-00-00', '', '', '', 0, 'yyyy', '', 0, '2017-12-21 21:23:46', '2017-12-21 22:26:23'),
(20, 'f898bb917b48a22a7f559d1985169dd9', '142513001', 'e10adc3949ba59abbe56e057f20f883e', '142513001', '', NULL, '', NULL, NULL, 0, '142513001', NULL, 0, '2017-12-23 15:17:23', NULL),
(21, '9758b9bc1c9199513079fffdba3a65b2', '1425132002', 'e10adc3949ba59abbe56e057f20f883e', '1425132002', '', NULL, '', NULL, NULL, 0, '1425132002', NULL, 0, '2017-12-23 15:17:52', NULL),
(22, 'b3329f9b910ccb1c7f5ed3f2ad7aadb3', '1425132007', 'e10adc3949ba59abbe56e057f20f883e', '1425132007', '', NULL, '', NULL, NULL, 0, '1425132004', NULL, 0, '2017-12-23 15:18:46', NULL),
(23, '257917786ed54d6008719c101c0126ff', '1425132099', 'b706835de79a2b4e80506f582af3676a', '99号', '男', '0000-00-00', '', '', '', 0, '99@9.c', '', 0, '2017-12-25 21:48:06', '2017-12-25 21:50:17');

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dj_dangfei`
--
ALTER TABLE `dj_dangfei`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `dj_jiaona`
--
ALTER TABLE `dj_jiaona`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `dj_lesson`
--
ALTER TABLE `dj_lesson`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `dj_study`
--
ALTER TABLE `dj_study`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `dj_users`
--
ALTER TABLE `dj_users`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号', AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
