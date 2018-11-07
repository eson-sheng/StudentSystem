<?php
require_once __DIR__ . "/config.php";
//1.连接数据库
try {
    $pdo = new PDO("mysql:host=localhost;dbname=school;", "root", MYSQLPASSWORD);

} catch (PDOException $e) {
    die("数据库连接失败" . $e->getMessage());
}
//2.防止中文乱码
$pdo->query("SET NAMES 'UTF8'");
//3.通过action的值进行对应操作
switch ($_GET['action']) {
    case 'add':{   //增加操作

        $name = $_POST['name'];
        $number = $_POST['number'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $cate = $_POST['cate'];
        $class = $_POST['class'];
        $major = $_POST['major'];        

        //写sql语句
        $sql = "
        INSERT INTO `stu` (`name`,`number`,`sex`,`age`,`cate`,`class`,`major`) VALUES ('{$name}','{$number}','{$sex}','{$age}','{$cate}','{$class}','{$major}');
        ";

        $rw = $pdo->exec($sql);
        if ($rw > 0) {
            echo "<script> alert('增加成功');
                            window.location='index.php'; //跳转到首页
                 </script>";
        } else {
            echo "<script> alert('增加失败');
                            window.history.back(); //返回上一页
                 </script>";
        }
        break;
    }
    case "del": {    //1.获取表单信息
        $id = $_GET['id'];
        $sql = "DELETE FROM stu WHERE id={$id}";
        $pdo->exec($sql);
        header("Location:index.php");//跳转到首页
        break;
    }
    case "edit" :{   //1.获取表单信息
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $cate = $_POST['cate'];
        $class = $_POST['class'];
        $major = $_POST['major'];

        $sql = "
            UPDATE stu SET 
                `name` = '{$name}', 
                `number` = '{$number}',
                `sex` = '{$sex}',
                `age` = '{$age}',
                `cate` = '{$cate}',
                `class` = '{$class}',
                `major` = '{$major}'
            WHERE `id` = '{$id}';
        ";
        $rw=$pdo->exec($sql);
        if($rw>0){
            echo "<script>alert('修改成功');window.location='index.php'</script>";
        }else{
            echo "<script>alert('修改失败');window.history.back()</script>";
        }
        break;
    }
    case "search" :{
        // dd($_POST);
        
        $where_name = !empty($_POST['name']) ? "AND name LIKE \"%{$_POST['name']}%\" " : '';
        $where_number = !empty($_POST['number']) ? "AND number LIKE \"%{$_POST['number']}%\" " : '';
        $where_sex = !empty($_POST['sex']) ? "AND sex LIKE \"%{$_POST['sex']}%\" " : '';

        $where_age_low = !empty($_POST['age_low']) ? "AND age > \"{$_POST['age_low']}\" " : '';
        $where_age_high = !empty($_POST['age_high']) ? "AND age < \"{$_POST['age_high']}\" " : '';

        $where_cate = $_POST['cate'] == 'all' ? '' : "AND cate = \"{$_POST['cate']}\" ";
        $where_class = $_POST['class'] == 'all' ? '' : "AND class = \"{$_POST['class']}\" ";
        $where_major = $_POST['major'] == 'all' ? '' : "AND major = \"{$_POST['major']}\" ";


        $sql = "
        SELECT 
            `id`,`name`,`number`,`sex`,`age`,`cate`,`class`,`major` 
        FROM 
            `stu`
        WHERE
            `id` IS NOT NULL
            {$where_name}
            {$where_number}
            {$where_sex}
            {$where_age_low}
            {$where_age_high}
            {$where_cate}
            {$where_class}
            {$where_major}
        ";
        $stmt = $pdo->query($sql);
        $stu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo json_encode($stu);
        $txt = '';
        foreach ($stu as $row) {
            $txt .= "{$row['name']} ";
            $txt .= "{$row['number']} ";
            $sex = $row['sex'] == 'w' ?  '女' : '男';
            $txt .= "{$sex} ";
            $txt .= "{$row['age']} ";
            $txt .= "{$row['cate']} ";
            $txt .= "{$row['class']} ";
            $txt .= "{$row['major']} ";
            $txt .= "\n";
        }
        file_put_contents('./StudentInformation.txt', $txt);

        $html = <<<EOT
        <h3>查询的学生信息</h3>
        <a href="download.php">导出信息</a>
        <table width="600" border="1">
        <tr>
            <th>姓名</th>
            <th>学号</th>
            <th>性别</th>
            <th>年龄</th>
            <th>学院</th>
            <th>班级</th>
            <th>专业</th>
            <th>操作</th>
        </tr>
EOT;
        foreach ($stu as $row) {
            $html .= "<tr>";
            $html .= "<td>{$row['name']}</td>";
            $html .= "<td>{$row['number']}</td>";
            $sex = $row['sex'] == 'w' ?  '女' : '男';
            $html .= "<td>{$sex}</td>";
            $html .= "<td>{$row['age']}</td>";
            $html .= "<td>{$row['cate']}</td>";
            $html .= "<td>{$row['class']}</td>";
            $html .= "<td>{$row['major']}</td>";
            $html .= "<td>
                    <a href='javascript:doDel({$row['id']})'>删除</a>
                    <a href='edit.php?id=({$row['id']})'>修改</a>
                  </td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
        break;
    }
}