-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-26 19:49:38
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
  `id` int(12) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '党费名称',
  `date` datetime NOT NULL COMMENT '发布日期',
  `mark` varchar(500) NOT NULL COMMENT '党费备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建党费表';

--
-- 转存表中的数据 `dj_dangfei`
--

INSERT INTO `dj_dangfei` (`id`, `name`, `date`, `mark`) VALUES
(1, '2017年第一次党费', '2017-02-01 17:12:15', '按照党章规定，党员向党组织交纳2017年第一季度党费。'),
(2, '2017年第二次党费', '2017-04-01 17:13:49', '在党爱党、在党言党、在党忧党、在党为党。2017年第二次党费'),
(3, '2017年第三次党费', '2017-07-01 17:14:49', '2017年第三季度党费。党费是党员向党组织交纳的用于党的事业和党的活动的经费。'),
(4, '2017年第四次党费', '2017-12-01 17:15:57', '2017年第四季度党费，增强党员的组织观念。'),
(5, '2018年第一次党费', '2018-01-01 17:16:42', '按时交纳党费，是共产党员必须具备的一个起码条件，是党员对党应尽的义务，是党员关心党的事业的具体表现。2018年第一次党费'),
(6, '2018年第二次党费', '2018-04-01 17:17:24', '2018年第二季度党费。党费是党员向党组织交纳的用于党的事业和党的活动的经费。');

-- --------------------------------------------------------

--
-- 表的结构 `dj_election`
--

CREATE TABLE `dj_election` (
  `id` int(12) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '评议名称',
  `create_at` datetime DEFAULT NULL COMMENT '创建日期',
  `start_date` datetime NOT NULL COMMENT '开始日期',
  `end_date` datetime NOT NULL COMMENT '截止日期',
  `vote_num` int(4) NOT NULL COMMENT '每人票数',
  `mark` varchar(500) DEFAULT NULL COMMENT '评议备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='民主评议表';

--
-- 转存表中的数据 `dj_election`
--

INSERT INTO `dj_election` (`id`, `name`, `create_at`, `start_date`, `end_date`, `vote_num`, `mark`) VALUES
(1, '2016-2017年度民主评议', '2018-04-27 01:23:57', '2017-12-01 00:00:00', '2017-12-15 23:59:59', 3, '2016-2017年度民主评议，每人仅可投三票。'),
(2, '2018年第一期民主评议', '2018-04-27 01:25:02', '2018-02-01 00:00:00', '2018-02-15 23:59:59', 4, '2018年第一期民主评议，每人四票'),
(3, '2018年第二期民主评议', '2018-04-27 01:25:45', '2018-04-01 00:00:00', '2018-04-15 23:59:59', 3, '2018年第二期民主评议，每人三票，公平公正');

-- --------------------------------------------------------

--
-- 表的结构 `dj_jiaona`
--

CREATE TABLE `dj_jiaona` (
  `id` int(12) NOT NULL,
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `dangfeiid` int(12) NOT NULL COMMENT '党费编号',
  `price` decimal(18,2) NOT NULL COMMENT '应缴金额',
  `real_price` decimal(18,2) NOT NULL COMMENT '实缴金额',
  `date` datetime DEFAULT NULL COMMENT '缴纳时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党费缴纳表';

--
-- 转存表中的数据 `dj_jiaona`
--

INSERT INTO `dj_jiaona` (`id`, `user_id`, `dangfeiid`, `price`, `real_price`, `date`) VALUES
(1, '1', 1, '0.00', '0.00', '2018-01-01 00:00:00'),
(2, '21232f297a57a5a743894a0e4a801fc3', 3, '50.00', '55.10', '2018-04-26 00:00:00'),
(3, '21232f297a57a5a743894a0e4a801fc3', 4, '50.00', '55.00', '2018-04-26 00:00:00'),
(4, '21232f297a57a5a743894a0e4a801fc3', 5, '50.00', '50.00', '2018-04-26 00:00:00'),
(5, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 5, '25.00', '30.00', '2018-04-26 00:00:00'),
(6, '4f1a6d6caf78c98ff7d75033aff90bca', 6, '36.66', '36.66', '2018-04-26 00:00:00'),
(7, '9758b9bc1c9199513079fffdba3a65b2', 6, '20.50', '30.00', '2018-04-26 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `dj_judge`
--

CREATE TABLE `dj_judge` (
  `id` int(12) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '互评名称',
  `create_at` datetime DEFAULT NULL COMMENT '创建日期',
  `start_date` datetime NOT NULL COMMENT '开始日期',
  `end_date` datetime NOT NULL COMMENT '截止日期',
  `mark` varchar(500) DEFAULT NULL COMMENT '互评备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员互评表';

--
-- 转存表中的数据 `dj_judge`
--

INSERT INTO `dj_judge` (`id`, `name`, `create_at`, `start_date`, `end_date`, `mark`) VALUES
(1, '2017年度第四次互评', '2017-10-31 01:18:38', '2017-11-01 00:00:00', '2017-12-01 23:59:59', '2017年度第四次互评，党员间互相评价。'),
(2, '2017-2018年度互评', '2017-12-01 01:19:37', '2017-12-01 00:00:00', '2017-12-31 23:59:59', '2017年，年度互评。党员间互相评价'),
(3, '2018年度第一次互评', '2017-12-31 01:20:17', '2018-01-01 00:00:00', '2018-01-31 23:59:59', '2018年度第一次互评，党员间互相评价'),
(4, '2018年度第二次互评', '2018-03-01 01:20:52', '2018-03-01 00:00:00', '2018-03-31 23:59:59', '2018年度第二次互评，党员间互相评价');

-- --------------------------------------------------------

--
-- 表的结构 `dj_lesson`
--

CREATE TABLE `dj_lesson` (
  `id` int(12) NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '课程名称',
  `extension` varchar(10) DEFAULT NULL COMMENT '课程类型',
  `score` int(8) DEFAULT NULL COMMENT '课程分数',
  `detail` varchar(500) DEFAULT NULL COMMENT '课程详情',
  `link` varchar(500) DEFAULT NULL COMMENT '课程链接',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `mark` varchar(500) DEFAULT NULL COMMENT '课程备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建课程表';

--
-- 转存表中的数据 `dj_lesson`
--

INSERT INTO `dj_lesson` (`id`, `name`, `extension`, `score`, `detail`, `link`, `created_at`, `mark`) VALUES
(1, '中共中央组织部关于进一步做好新形势下发展党员工作的意见', '专题课程', 20, '为深入贯彻党的十六大精神，进一步做好新形势下发展党员工作，现提出如下意见。', 'http://127.0.0.1:88/wgn.dangjian/dangjian/upload/20180427003828.pdf', '2017-01-09 00:38:31', '加强对发展党员工作的督促检查。'),
(2, '关于转发福建省《关于加强和改进新形势下党对工会工作领导的意见》的通知', '专题课程', 25, '纪委、党委各部（室），各总支、直属支部、各部门工会：\r\n现将《中共福建省委关于加强和改进新形势下党对工会工作领导的意见》（闽委〔2011〕9号）转发给你们，请按照要求，结合各单位实际,认真学习贯彻。\r\n\r\n中共华侨大学委员会\r\n二〇一一年十月十四日', 'http://127.0.0.1:88/wgn.dangjian/dangjian/upload/20180427004220.pdf', '2017-05-22 00:42:22', '加强和改进新形势下党对工会工作领导的重要意义、指导思想和基本要求。'),
(3, '中共中央关于印发《中国共产党 纪律处分条例》的通知', '专题课程', 25, '中共中央印发的《中国共产党纪律处分条例》，对维护党的章程和其他党内法规，严肃党的纪律等发挥了重要作用。', 'http://127.0.0.1:88/wgn.dangjian/dangjian/upload/20180427010617.pdf', '2017-10-14 01:06:20', '党的十八大以来，随着形势发展，该条例已不能完全适应全面从严治党新的实践需要，党中央决定予以修订。'),
(4, '机关青年开展迎新春交流活动', '专题课程', 15, '机关团委在厦门校区林广场教师活动中心举办机关青年迎新春交流会。', 'http://127.0.0.1:88/wgn.dangjian/dangjian/upload/20180427010714.pdf', '2018-01-29 01:07:15', '机关党委常务副书记、党委组织部部长陈明森出席，来自校部机关各单位的60余名青年教职员工60参加。'),
(5, '机关青年开展主题植树活动', '专题课程', 15, '我校在厦门校区白鹭湖畔举行“播种绿色文明，拥抱校园春天”主题植树活动在，校领导与境外生代表、学生青年志愿代表等60余名师生参加。', 'http://127.0.0.1:88/wgn.dangjian/dangjian/upload/20180427010758.pdf', '2018-03-23 01:08:00', '机关团委组织部分机关青年积极参与该活动，并栽下了20余株碧桃树苗，为华园再添红花绿叶。');

-- --------------------------------------------------------

--
-- 表的结构 `dj_pingjia`
--

CREATE TABLE `dj_pingjia` (
  `id` int(12) NOT NULL,
  `judge_id` int(12) NOT NULL COMMENT '互评编号',
  `username` varchar(32) NOT NULL COMMENT '评价人',
  `target` varchar(32) NOT NULL COMMENT '被评人',
  `content` varchar(10) DEFAULT NULL COMMENT '评价内容',
  `date` datetime DEFAULT NULL COMMENT '评价时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员评价表';

--
-- 转存表中的数据 `dj_pingjia`
--

INSERT INTO `dj_pingjia` (`id`, `judge_id`, `username`, `target`, `content`, `date`) VALUES
(1, 3, 'admin', '1425132001', '优秀', '2018-04-27 01:27:36'),
(2, 3, 'admin', '1425132003', '优秀', '2018-04-27 01:27:36'),
(3, 3, 'admin', '1425132004', '优秀', '2018-04-27 01:27:36'),
(4, 3, 'admin', '1425132005', '优秀', '2018-04-27 01:27:36'),
(5, 3, 'admin', 'admin', '优秀', '2018-04-27 01:27:36'),
(6, 3, 'admin', '1425132002', '优秀', '2018-04-27 01:27:36'),
(7, 3, 'admin', '1425132006', '优秀', '2018-04-27 01:27:36'),
(8, 3, 'admin', '1425132007', '优秀', '2018-04-27 01:27:36'),
(9, 3, 'admin', '1425132008', '优秀', '2018-04-27 01:27:36'),
(10, 3, 'admin', '1425132009', '优秀', '2018-04-27 01:27:36'),
(11, 3, 'admin', '1425132010', '合格', '2018-04-27 01:27:36'),
(12, 3, '1425132001', 'admin', '优秀', '2018-04-27 01:28:12'),
(13, 3, '1425132001', '1425132001', '优秀', '2018-04-27 01:28:12'),
(14, 3, '1425132001', '1425132002', '优秀', '2018-04-27 01:28:12'),
(15, 3, '1425132001', '1425132003', '优秀', '2018-04-27 01:28:12'),
(16, 3, '1425132001', '1425132006', '优秀', '2018-04-27 01:28:12'),
(17, 3, '1425132001', '1425132004', '优秀', '2018-04-27 01:28:12'),
(18, 3, '1425132001', '1425132005', '优秀', '2018-04-27 01:28:12'),
(19, 3, '1425132001', '1425132007', '合格', '2018-04-27 01:28:12'),
(20, 3, '1425132001', '1425132010', '优秀', '2018-04-27 01:28:12'),
(21, 3, '1425132001', '1425132009', '优秀', '2018-04-27 01:28:12'),
(22, 3, '1425132001', '1425132008', '合格', '2018-04-27 01:28:12'),
(23, 4, '1425132001', 'admin', '合格', '2018-04-27 01:28:49'),
(24, 4, '1425132001', '1425132002', '优秀', '2018-04-27 01:28:49'),
(25, 4, '1425132001', '1425132001', '优秀', '2018-04-27 01:28:49'),
(26, 4, '1425132001', '1425132003', '优秀', '2018-04-27 01:28:49'),
(27, 4, '1425132001', '1425132004', '优秀', '2018-04-27 01:28:49'),
(28, 4, '1425132001', '1425132005', '优秀', '2018-04-27 01:28:49'),
(29, 4, '1425132001', '1425132006', '优秀', '2018-04-27 01:28:49'),
(30, 4, '1425132001', '1425132007', '优秀', '2018-04-27 01:28:49'),
(31, 4, '1425132001', '1425132008', '优秀', '2018-04-27 01:28:49'),
(32, 4, '1425132001', '1425132009', '优秀', '2018-04-27 01:28:49'),
(33, 4, '1425132001', '1425132010', '优秀', '2018-04-27 01:28:49'),
(34, 4, '1425132002', 'admin', '优秀', '2018-04-27 01:29:20'),
(35, 4, '1425132002', '1425132001', '优秀', '2018-04-27 01:29:20'),
(36, 4, '1425132002', '1425132002', '优秀', '2018-04-27 01:29:20'),
(37, 4, '1425132002', '1425132003', '优秀', '2018-04-27 01:29:20'),
(38, 4, '1425132002', '1425132004', '优秀', '2018-04-27 01:29:20'),
(39, 4, '1425132002', '1425132005', '优秀', '2018-04-27 01:29:20'),
(40, 4, '1425132002', '1425132006', '优秀', '2018-04-27 01:29:20'),
(41, 4, '1425132002', '1425132007', '优秀', '2018-04-27 01:29:20'),
(42, 4, '1425132002', '1425132008', '优秀', '2018-04-27 01:29:20'),
(43, 4, '1425132002', '1425132009', '优秀', '2018-04-27 01:29:20'),
(44, 4, '1425132002', '1425132010', '优秀', '2018-04-27 01:29:20'),
(45, 3, '1425132002', 'admin', '优秀', '2018-04-27 01:29:56'),
(46, 3, '1425132002', '1425132001', '优秀', '2018-04-27 01:29:56'),
(47, 3, '1425132002', '1425132002', '优秀', '2018-04-27 01:29:56'),
(48, 3, '1425132002', '1425132003', '优秀', '2018-04-27 01:29:56'),
(49, 3, '1425132002', '1425132004', '优秀', '2018-04-27 01:29:56'),
(50, 3, '1425132002', '1425132005', '优秀', '2018-04-27 01:29:56'),
(51, 3, '1425132002', '1425132006', '优秀', '2018-04-27 01:29:56'),
(52, 3, '1425132002', '1425132007', '优秀', '2018-04-27 01:29:56'),
(53, 3, '1425132002', '1425132008', '合格', '2018-04-27 01:29:56'),
(54, 3, '1425132002', '1425132009', '优秀', '2018-04-27 01:29:56'),
(55, 3, '1425132002', '1425132010', '合格', '2018-04-27 01:29:56'),
(56, 4, 'admin', '1425132001', '合格', '2018-04-27 01:30:21'),
(57, 4, 'admin', '1425132002', '合格', '2018-04-27 01:30:21'),
(58, 4, 'admin', '1425132003', '合格', '2018-04-27 01:30:21'),
(59, 4, 'admin', '1425132004', '合格', '2018-04-27 01:30:21'),
(60, 4, 'admin', 'admin', '合格', '2018-04-27 01:30:21'),
(61, 4, 'admin', '1425132005', '合格', '2018-04-27 01:30:21'),
(62, 4, 'admin', '1425132006', '合格', '2018-04-27 01:30:21'),
(63, 4, 'admin', '1425132007', '合格', '2018-04-27 01:30:21'),
(64, 4, 'admin', '1425132008', '合格', '2018-04-27 01:30:21'),
(65, 4, 'admin', '1425132009', '合格', '2018-04-27 01:30:21'),
(66, 4, 'admin', '1425132010', '合格', '2018-04-27 01:30:21');

-- --------------------------------------------------------

--
-- 表的结构 `dj_study`
--

CREATE TABLE `dj_study` (
  `id` int(12) NOT NULL,
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `lessonid` int(12) NOT NULL COMMENT '课程编号',
  `date` datetime DEFAULT NULL COMMENT '首次进入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建学习情况表';

--
-- 转存表中的数据 `dj_study`
--

INSERT INTO `dj_study` (`id`, `user_id`, `lessonid`, `date`) VALUES
(1, '1', 1, '2018-01-01 00:00:00'),
(2, '21232f297a57a5a743894a0e4a801fc3', 1, '2018-04-27 00:39:40'),
(3, '21232f297a57a5a743894a0e4a801fc3', 5, '2018-04-27 01:12:28'),
(4, '21232f297a57a5a743894a0e4a801fc3', 4, '2018-04-27 01:12:44'),
(5, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 5, '2018-04-27 01:15:40'),
(6, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 4, '2018-04-27 01:15:43'),
(7, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 3, '2018-04-27 01:15:45'),
(8, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 2, '2018-04-27 01:15:47'),
(9, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', 1, '2018-04-27 01:15:51');

-- --------------------------------------------------------

--
-- 表的结构 `dj_users`
--

CREATE TABLE `dj_users` (
  `id` int(12) UNSIGNED NOT NULL,
  `user_id` char(32) NOT NULL COMMENT '用户登陆名username的MD5值',
  `username` varchar(32) NOT NULL COMMENT '用户登陆名,学号',
  `password` char(32) NOT NULL COMMENT '用户密码的MD5值',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `sex` char(2) DEFAULT NULL COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `education` varchar(32) DEFAULT NULL COMMENT '学历',
  `volk` varchar(10) DEFAULT NULL COMMENT '民族',
  `category` int(1) DEFAULT NULL COMMENT '人员类别',
  `organization` varchar(200) DEFAULT NULL COMMENT '所在党支部',
  `joinDate` date DEFAULT NULL COMMENT '入党日期',
  `regularDate` date DEFAULT NULL COMMENT '转正日期',
  `price` decimal(18,2) DEFAULT NULL COMMENT '应缴金额',
  `phone` bigint(11) DEFAULT NULL COMMENT '电话号码',
  `email` varchar(200) NOT NULL COMMENT '邮箱',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `roleid` int(1) NOT NULL DEFAULT '0' COMMENT '权限判定,默认为0',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后一次修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建用户表';

--
-- 转存表中的数据 `dj_users`
--

INSERT INTO `dj_users` (`id`, `user_id`, `username`, `password`, `name`, `sex`, `birthday`, `idcard`, `education`, `volk`, `category`, `organization`, `joinDate`, `regularDate`, `price`, `phone`, `email`, `address`, `roleid`, `created_at`, `updated_at`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '管理员', '男', '1999-01-01', '12312319990101666X', '博士', '', 1, '', NULL, NULL, '50.00', 18866669999, 'wuguangnuo@qq.com', '厦门市集美区', 1, '2017-01-01 00:00:01', '2018-04-26 17:06:15'),
(2, 'd3a8b405cabf1ecb0ddff95efbfb7bdb', '1425132001', 'e10adc3949ba59abbe56e057f20f883e', '冯恬美', '女', '1996-01-01', '12312319960101123X', '本科', '汉族', 0, '', NULL, NULL, '25.00', NULL, '1425132001@hqu.edu.cn', '福建省厦门市集美区华侨大学（厦门校区）', 0, '2018-04-26 16:52:23', '2018-04-26 18:59:41'),
(3, '9758b9bc1c9199513079fffdba3a65b2', '1425132002', 'e10adc3949ba59abbe56e057f20f883e', '崔瑞云', '男', NULL, '', '高中', '满族', 0, '华侨大学计算机科学与技术学院党支部', '2018-01-01', NULL, '20.50', NULL, 'ruiyun@163.com', '', 0, '2018-04-26 16:53:23', '2018-04-26 17:07:38'),
(4, '4f1a6d6caf78c98ff7d75033aff90bca', '1425132003', 'e10adc3949ba59abbe56e057f20f883e', '石暖怡', '男', NULL, '', '', '', 1, '', '2017-05-01', '2018-04-01', '36.66', 13966668888, '87576241@qq.com', '福建省厦门市集美区华侨大学（厦门校区）', 0, '2018-04-26 16:54:20', '2018-04-26 17:09:31'),
(5, 'b3329f9b910ccb1c7f5ed3f2ad7aadb3', '1425132004', 'e10adc3949ba59abbe56e057f20f883e', '朱千秋', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qianqiu8@qq.com', NULL, 0, '2018-04-26 16:55:09', NULL),
(6, 'f32ca33c9f9065ac5c22d3b7e3065079', '1425132005', 'e10adc3949ba59abbe56e057f20f883e', '郭一南', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yinanguo@163.com', NULL, 0, '2018-04-26 16:55:49', NULL),
(7, '7c0ba065804c83f555c260d5b39ba933', '1425132006', 'e10adc3949ba59abbe56e057f20f883e', '陆婷美', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'guoguo@outlook.com', NULL, 0, '2018-04-26 16:57:03', NULL),
(8, '665045322bb1f2cba82bf13d6efe7004', '1425132007', 'e10adc3949ba59abbe56e057f20f883e', '江今瑶', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jinyao233@163.com', NULL, 0, '2018-04-26 16:57:45', NULL),
(9, '4652f221e82c6933ebc0d66278656aa4', '1425132008', 'e10adc3949ba59abbe56e057f20f883e', '刘虹影', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hongying@wang.cn', NULL, 0, '2018-04-26 16:58:41', NULL),
(10, 'a17647dd1ca2468666aff85ec7ba62d6', '1425132009', 'e10adc3949ba59abbe56e057f20f883e', '周子琳', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zilin@qq.com', NULL, 0, '2018-04-26 16:59:58', NULL),
(11, '875e040f7eafbdd596b7892957916f78', '1425132010', 'e10adc3949ba59abbe56e057f20f883e', '魏灵松', '男', NULL, '', '', '', 0, '', NULL, NULL, NULL, NULL, 'songge@qq.com', '', 0, '2018-04-26 17:00:35', '2018-04-26 18:50:41');

-- --------------------------------------------------------

--
-- 表的结构 `dj_vote`
--

CREATE TABLE `dj_vote` (
  `id` int(12) NOT NULL,
  `election_id` int(12) NOT NULL COMMENT '评议编号',
  `username` varchar(32) NOT NULL COMMENT '投票人',
  `target` varchar(32) NOT NULL COMMENT '被投票人',
  `date` datetime DEFAULT NULL COMMENT '投票时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员投票表';

--
-- 转存表中的数据 `dj_vote`
--

INSERT INTO `dj_vote` (`id`, `election_id`, `username`, `target`, `date`) VALUES
(1, 3, 'admin', 'admin', '2018-04-27 01:47:23'),
(2, 3, 'admin', '1425132001', '2018-04-27 01:47:23'),
(3, 3, 'admin', '1425132002', '2018-04-27 01:47:23'),
(4, 3, '1425132002', '1425132001', '2018-04-27 01:47:37'),
(5, 3, '1425132002', '1425132002', '2018-04-27 01:47:37'),
(6, 3, '1425132002', '1425132003', '2018-04-27 01:47:37'),
(7, 3, '1425132001', 'admin', '2018-04-27 01:48:04'),
(8, 3, '1425132001', '1425132002', '2018-04-27 01:48:04'),
(9, 3, '1425132001', '1425132003', '2018-04-27 01:48:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dj_dangfei`
--
ALTER TABLE `dj_dangfei`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_election`
--
ALTER TABLE `dj_election`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_jiaona`
--
ALTER TABLE `dj_jiaona`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_judge`
--
ALTER TABLE `dj_judge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_lesson`
--
ALTER TABLE `dj_lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_pingjia`
--
ALTER TABLE `dj_pingjia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_study`
--
ALTER TABLE `dj_study`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_users`
--
ALTER TABLE `dj_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dj_vote`
--
ALTER TABLE `dj_vote`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dj_dangfei`
--
ALTER TABLE `dj_dangfei`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `dj_election`
--
ALTER TABLE `dj_election`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `dj_jiaona`
--
ALTER TABLE `dj_jiaona`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `dj_judge`
--
ALTER TABLE `dj_judge`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `dj_lesson`
--
ALTER TABLE `dj_lesson`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `dj_pingjia`
--
ALTER TABLE `dj_pingjia`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- 使用表AUTO_INCREMENT `dj_study`
--
ALTER TABLE `dj_study`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `dj_users`
--
ALTER TABLE `dj_users`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `dj_vote`
--
ALTER TABLE `dj_vote`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
