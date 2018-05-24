<?php
/**
 * 配置 验证器
 */
namespace app\admin\validate;
use think\Validate;

class Conf extends Validate
{
	/**
	 * 验证规则
	 */
	protected $rule=[
        'conf_cname'=>'require|max:60',
        'conf_ename'=>'require|max:60',
        'conf_type'=>'require',
    ];
	/**
	 * 错误信息
	 */
    protected $message=[
        'conf_cname.require'=>'中文名称不得为空！',
        'conf_cname.max'=>'中文名称不能大于60个字符！',
        'conf_ename.require'=>'英文名称不得为空！',
        'conf_ename.max'=>'英文名称不能大于60个字符！',
        'conf_type.require'=>'配置类型不得为空！',
    ];
    /**
	 * 验证场景
	 */
    protected $scene=[
    	'add' => ['conf_cname', 'conf_ename', 'conf_type'],
        'edit'=>['conf_cname', 'conf_ename'],
    ];


}