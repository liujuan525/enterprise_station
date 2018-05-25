                            -- 企业站
				-- 创建数据库
create database enterprise_station;
-- 使用数据库
use enterprise_station;

				-- 创建数据表
/**
 * 用户表
 */
create table es_admin(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,

    name varchar(64) NOT NULL DEFAULT '' COMMENT '管理员账号',
    password char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',

    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='用户表';
/**
 * 分类表
 */
create table es_category(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,

    category_name varchar(64) NOT NULL DEFAULT '' COMMENT '分类名称',
    category_type tinyint(1) NOT NULL DEFAULT 1 COMMENT '分类类型:1-文章列表 2-单页 3-图片列表',
    category_pid int(11) NOT NULL DEFAULT 0 COMMENT '父级id:默认为0',
    category_sort int(11) NOT NULL DEFAULT 10 COMMENT '排序',

    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='分类表';
-- 添加
alter table es_category add category_keywords varchar(64) NOT NULL DEFAULT '' COMMENT '栏目关键字';
alter table es_category add category_desc varchar(128) NOT NULL DEFAULT '' COMMENT '栏目描述';
alter table es_category add category_content text NOT NULL COMMENT '栏目内容';
-- 修改
alter table es_category modify category_keywords varchar(64) NOT NULL DEFAULT '' COMMENT '栏目关键字' after category_sort;
alter table es_category modify category_desc varchar(128) NOT NULL DEFAULT '' COMMENT '栏目描述' after category_keywords;
alter table es_category modify category_content text NOT NULL COMMENT '栏目内容' after category_desc;

/**
 * 文章表
 */
create table es_article(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,

    title varchar(64) NOT NULL DEFAULT '' COMMENT '文章标题',
    author varchar(32) NOT NULL DEFAULT '' COMMENT '文章作者',
    description varchar(128) NOT NULL DEFAULT '' COMMENT '文章描述',
    content text NOT NULL COMMENT '文章内容',
    category_id int(11) NOT NULL DEFAULT 0 COMMENT '所属栏目id',
    thumb_img varchar(255) NOT NULL DEFAULT '' COMMENT '图片缩略图',
    keywords varchar(64) NOT NULL DEFAULT '' COMMENT '关键字',
    browse_number int(11) NOT NULL DEFAULT 0 COMMENT '浏览数',
    like_number int(11) NOT NULL DEFAULT 0 COMMENT '点赞数',

    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='文章表';
/**
 * 链接表
 */
create table es_link(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,

    link_title varchar(64) NOT NULL DEFAULT '' COMMENT '链接标题',
    link_url varchar(128) NOT NULL DEFAULT '' COMMENT '链接地址',
    link_desc varchar(128) NOT NULL DEFAULT '' COMMENT '链接描述',
    link_sort int(5) NOT NULL DEFAULT 10 COMMENT '链接排序',

    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='链接表';
/**
 * 配置表
 */
create table es_conf(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,

    conf_cname varchar(64) NOT NULL DEFAULT '' COMMENT '配置中文名',
    conf_ename varchar(64) NOT NULL DEFAULT '' COMMENT '配置英文名',
    conf_type tinyint(2) NOT NULL DEFAULT 1 COMMENT '配置类型:1-单行文本 2-多行文本 3-单选按钮 4-复选框 5-下拉菜单',
    conf_value varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
    conf_values varchar(255) NOT NULL DEFAULT '' COMMENT '配置可选值',
    conf_sort int(3) NOT NULL DEFAULT 10 COMMENT '配置排序',

    isDel tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否删除:1-未删除,2-已删除',
    addTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录添加时间',
    updateTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT charset=utf8 COMMENT='配置表';






