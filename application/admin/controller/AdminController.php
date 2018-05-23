<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use app\admin\model\Admin;
use think\Validate;

class AdminController extends BaseController
{
    /**
     * 前置方法
     */
    protected $beforeActionList = [
        'isLogin',
        // 'BeforeLoginUrl'
    ];
    // 管理员信息模型
    protected $admin;
    /**
     * 初始化
     */
    public function _initialize()
    {
        $this -> admin = new Admin();
    }
    /**
     * 添加管理员
     */
    public function add()
    {
        if (request() -> isPost()) {
            $data = input('post.');
            $this -> checkData('Admin', 'add', $data); // 验证数据
            $data['password'] = $this -> encryptString($data['password']); // 密码加密
            $this -> findAdmin($data['name']); // 校验管理员账号
            // 添加数据
            $result = $this -> admin -> addAdmin($data);
            if ($result) {
                $this -> success('添加管理员成功!',url('Admin/list'));
            } else {
                $this -> error('添加管理员失败!');
            }
        }
        return view();
    }
    /**
     * 修改管理员信息
     */
    public function edit(int $id)
    {
        $result = $this -> admin -> getAdminById($id);
        if (!$result) {
            $this -> error('管理员信息不存在!');
        }

        if (request() -> isPost()) {
            $data = input('post.');
            if (!$data['password']) {
                $data['password'] = $result['password']; // 原密码
            } else {
                $data['password'] = $this -> encryptString($data['password']); // 加密后的新密码
            }
            $this -> checkData('Admin', 'edit', $data); // 验证数据
            if ($data['name'] != $result['name']) {
                $this -> findAdmin($data['name']); // 校验管理员账号
            }
            // 更新信息
            $result = $this -> admin -> updateAdmin($data);
            if ($result) {
                $this -> success('更新管理员信息成功!', url('Admin/list'));
            } else {
                $this -> error('更新管理员信息失败!');
            }
        }
        $this -> assign('admin', $result);
        return view();
    }
    /**
     * 获取管理员列表
     */
    public function list()
    {
        $result = $this -> admin -> adminList();
        $this -> assign('admins', $result);
        return view();
    }
    /**
     * 删除管理员
     */
    public function delete(int $id)
    {
        // $id = input('post.id/d'); // 指定参数类型
        if (!$id || !is_numeric($id)) {
            $this -> error('数据格式错误!');
        }
        $result = $this -> admin -> deleteAdmin($id);
        if ($result) {
            $this -> success('删除管理员成功!', url('Admin/list'));
        } else {
            $this -> error('删除管理员失败!');
        }
    }
    /**
     * 根据账号查询管理员信息
     */
    private function findAdmin($name)
    {
        $result = $this -> admin -> getAdminByName($name);
        if ($result) {
            $this -> error('账号已存在!');
        }
    }




}