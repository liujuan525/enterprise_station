                            -- 企业站
-- 创建数据库
create database enterprise_station;
-- 使用数据库
use enterprise_station;

-- 创建数据表
create table es_admin(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL DEFAULT '' COMMENT '管理员账号',
    password char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='用户表';

