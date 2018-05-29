<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use app\admin\model\Admin;
use think\Validate;
use think\Db;

class AdminController extends BaseController
{
    /**
     * 前置方法
     */
    protected $beforeActionList = [
        'isLogin',
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
            $adminData['name'] = input('post.name');
            $adminData['password'] = input('post.password');
            $this -> checkData('Admin', 'add', $adminData); // 验证数据
            $adminData['password'] = $this -> encryptString($adminData['password']); // 密码加密
            $this -> findAdmin($adminData['name']); // 校验管理员账号
            Db::startTrans(); // 开启事务
            try{
                $id = $this -> admin -> addAdmin($adminData);
                if (!$id) {
                    throw new \Exception('添加管理员失败!');
                }
                $accessData['uid'] = $id;
                $accessData['group_id'] = $data['group_id'];
                $accessData['addTime'] = $accessData['updateTime'] = date('Y-m-d H:i:s', time());
                $result = Db::table('es_auth_group_access') -> insert($accessData);
                if (!$result) {
                    throw new \Exception('添加管理员失败!');
                }
                Db::commit(); // 提交
            } catch (\Exception $e) {
                Db::rollback(); // 回滚
                $this -> error($e -> getMessage());
            }
            $this -> success('添加管理员成功!',url('Admin/list'));
        }
        $authGroupRes = model('AuthGroup') -> getListInfo(100);
        $this -> assign('authGroupRes', $authGroupRes);
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
            $adminData['name'] = $data['name'];
            $adminData['password'] = $data['password'];
            $adminData['id'] = $data['id'];
            // 更新信息
            Db::startTrans();
            try{
                $adminRes = $this -> admin -> updateAdmin($adminData);
                if (!$adminRes) {
                    throw new \Exception('更新管理员信息失败!');
                }
                $accessData['group_id'] = $data['group_id'];
                $accessData['updateTime'] = date('Y-m-d H:i:s', time());
                $accessRes = db('auth_group_access') -> where('uid', $id) -> update($accessData);
                if (!$accessRes) {
                    throw new \Exception('更新管理员信息失败!');
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                $this -> error($e -> getMessage());
            }
            $this -> success('更新管理员信息成功!', url('Admin/list'));
        }
        $authGroupAccess=db('auth_group_access')->where(['uid'=>$id,'isDel' => 1])->find();
        $authGroupRes=db('auth_group')->select();
        $this -> assign([
            'admin' => $result,
            'authGroupRes' => $authGroupRes,
            'groupId' => $authGroupAccess['group_id'],
        ]);
        return view();
    }
    /**
     * 获取管理员列表
     */
    public function list()
    {
        $auth = new Auth();
        $result = $this -> admin -> adminList();
        foreach ($result as $k => $v) {
            $groupRes = $auth -> getGroups($v['id']);
            $groupTitle = $groupRes[0]['title'];
            $v['groupTitle'] = $groupTitle;
        }
        $this -> assign('admins', $result);
        return view();
    }
    /**
     * 删除管理员
     */
    public function delete(int $id)
    {
        if (!$id || !is_numeric($id)) {
            $this -> error('数据格式错误!');
        }
        Db::startTrans();
        try{
            $result = $this -> admin -> deleteAdmin($id);
            if (!$result) {
                throw new \Exception('删除管理员失败!');
            }
            $data['isDel'] = 2;
            $data['updateTime'] = date('Y-m-d H:i:s', time());
            $accessRes = Db::table('es_auth_group_access') -> where('uid', $id) -> update($data);
            if (!$accessRes) {
                throw new \Exception('删除管理员失败!');
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this -> error($e -> getMessage());
        }
        $this -> success('删除管理员成功!', url('Admin/list'));
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