
CREATE TABLE IF NOT EXISTS `__PREFIX__version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `oldversion` varchar(30) DEFAULT '' COMMENT '旧版本号',
  `newversion` varchar(30) DEFAULT '' COMMENT '新版本号',
  `packagesize` varchar(30) DEFAULT '' COMMENT '包大小',
  `content` varchar(500) DEFAULT '' COMMENT '升级内容',
  `downloadurl` varchar(255) DEFAULT '' COMMENT '下载地址',
  `enforce` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '强制更新',
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `updatetime` bigint(16) DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='版本表';

BEGIN;
INSERT INTO `__PREFIX__version` (`id`, `oldversion`, `newversion`, `packagesize`, `content`, `downloadurl`, `enforce`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, '1.1.1,2', '1.2.1', '20M', '更新内容', 'https://www.example.com', 1, 1520425318, 0, 0, 'normal');
COMMIT;