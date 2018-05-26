-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-01 00:00:01
-- 服务器版本： 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+8:00";

--
-- Database: `dangjian`
--

--
-- 表的结构 `dj_dangfei`
--

CREATE TABLE IF NOT EXISTS `dj_dangfei` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '党费编号',
  `name` varchar(32) NOT NULL COMMENT '党费名称',
  `date` datetime NOT NULL COMMENT '发布日期',
  `mark` varchar(500) NOT NULL COMMENT '党费备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建党费表';

--
-- 表的结构 `dj_jiaona`
--

CREATE TABLE IF NOT EXISTS `dj_jiaona` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '缴纳编号',
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `dangfeiid` int(12) NOT NULL COMMENT '党费编号',
  `price` DECIMAL(18,2) NOT NULL COMMENT '应缴金额',
  `real_price` DECIMAL(18,2) NOT NULL COMMENT '实缴金额',
  `date` datetime DEFAULT NULL COMMENT '缴纳时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党费缴纳表';

--
-- 表的结构 `dj_lesson`
--

CREATE TABLE IF NOT EXISTS `dj_lesson` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '课程编号',
  `name` varchar(80) NOT NULL COMMENT '课程名称',
  `extension` varchar(10) DEFAULT NULL COMMENT '课程类型',
  `score` int(8) DEFAULT NULL COMMENT '课程分数',
  `detail` varchar(500) DEFAULT NULL COMMENT '课程详情',
  `link` varchar(500) DEFAULT NULL COMMENT '课程链接',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `mark` varchar(500) DEFAULT NULL COMMENT '课程备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建课程表';

--
-- 表的结构 `dj_study`
--

CREATE TABLE IF NOT EXISTS `dj_study` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '学习编号',
  `user_id` char(32) NOT NULL COMMENT '用户登录名MD5',
  `lessonid` int(12) NOT NULL COMMENT '课程编号',
  `date` datetime DEFAULT NULL COMMENT '首次进入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建学习情况表';

--
-- 表的结构 `dj_users`
--

CREATE TABLE IF NOT EXISTS `dj_users` (
  `id` int(12) UNSIGNED NOT NULL PRIMARY KEY COMMENT '用户编号',
  `user_id` char(32) NOT NULL COMMENT '用户登陆名username的MD5值',
  `username` varchar(32) NOT NULL COMMENT '用户登陆名,学号',
  `password` char(32) NOT NULL COMMENT '用户密码的MD5值',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `sex` char(2) DEFAULT NULL COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `education` varchar(32) default null comment '学历',
  `volk` varchar(10) DEFAULT NULL COMMENT '民族',
  `category` int(1) DEFAULT null COMMENT '人员类别',
  `organization` varchar(200) default null comment '所在党支部',
  `joinDate` date DEFAULT NULL COMMENT '入党日期',
  `regularDate` date DEFAULT NULL COMMENT '转正日期',
  `price` decimal(18,2) default NULL COMMENT '应缴金额',
  `phone` bigint(11) DEFAULT NULL COMMENT '电话号码',
  `email` varchar(200) NOT NULL COMMENT '邮箱',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `roleid` int(1) NOT NULL DEFAULT '0' COMMENT '权限判定,默认为0',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后一次修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党建用户表';

--
-- 表的结构 `dj_judge`
--

CREATE TABLE IF NOT EXISTS `dj_judge` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '互评编号',
  `name` varchar(32) NOT NULL COMMENT '互评名称',
  `create_at` datetime DEFAULT NULL COMMENT '创建日期',
  `start_date` datetime NOT NULL COMMENT '开始日期',
  `end_date` datetime NOT NULL COMMENT '截止日期',
  `mark` varchar(500) DEFAULT NULL COMMENT '互评备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员互评表';

--
-- 表的结构 `dj_pingjia`
--

CREATE TABLE IF NOT EXISTS `dj_pingjia` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '评价编号',
  `judge_id` int(12) NOT  NULL COMMENT '互评编号',
  `username` varchar(32) NOT NULL COMMENT '评价人',
  `target` varchar(32) NOT NULL COMMENT '被评人',
  `content` varchar(10) DEFAULT NULL COMMENT '评价内容',
  `date` datetime DEFAULT NULL COMMENT '评价时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员评价表';


--
-- 表的结构 `dj_election`
--

CREATE TABLE IF NOT EXISTS `dj_election` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '评议编号',
  `name` varchar(32) NOT NULL COMMENT '评议名称',
  `create_at` datetime DEFAULT NULL COMMENT '创建日期',
  `start_date` datetime NOT NULL COMMENT '开始日期',
  `end_date` datetime NOT NULL COMMENT '截止日期',
  `vote_num` int(4) NOT NULL COMMENT '每人票数',
  `mark` varchar(500) DEFAULT NULL COMMENT '评议备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='民主评议表';

--
-- 表的结构 `dj_vote`
--

CREATE TABLE IF NOT EXISTS `dj_vote` (
  `id` int(12) NOT NULL PRIMARY KEY COMMENT '投票编号',
  `election_id` int(12) NOT NULL COMMENT '评议编号',
  `username` varchar(32) NOT NULL COMMENT '投票人',
  `target` varchar(32) NOT NULL COMMENT '被投票人',
  `date` datetime DEFAULT NULL COMMENT '投票时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='党员投票表';

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dj_dangfei`
--
ALTER TABLE `dj_dangfei`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_jiaona`
--
ALTER TABLE `dj_jiaona`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_lesson`
--
ALTER TABLE `dj_lesson`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_study`
--
ALTER TABLE `dj_study`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_users`
--
ALTER TABLE `dj_users`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_judge`
--
ALTER TABLE `dj_judge`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_pingjia`
--
ALTER TABLE `dj_pingjia`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_election`
--
ALTER TABLE `dj_election`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `dj_vote`
--
ALTER TABLE `dj_vote`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 添加数据 初始化数据表
--

INSERT INTO `dj_users` (`id`, `user_id`, `username`, `password`, `name`, `sex`, `birthday`, `idcard`, `education`, `volk`, `category`, `organization`, `joinDate`, `regularDate`, `price`, `phone`, `email`, `address`, `roleid`, `created_at`, `updated_at`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '管理员', '男', '1999-01-01', '12312319990101666X', '博士', '', 1, NULL, NULL, NULL, '50.00', 18866669999, 'wuguangnuo@qq.com', '厦门市集美区', 1, '2017-01-01 00:00:01', '2018-01-01 11:11:11');

INSERT INTO `dj_study` (`id`, `user_id`, `lessonid`, `date`) VALUES
(1, '1', 1, '2018-01-01 00:00:00');

INSERT INTO `dj_jiaona` (`id`, `user_id`, `dangfeiid`, `real_price`, `date`) VALUES
(1, '1', 1, '0.00', '2018-01-01 00:00:00');
